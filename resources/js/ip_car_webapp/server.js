import express from "express";
import bodyParser from "body-parser";
import http from "http";
import cors from "cors";
import WebSocket from "ws";
import {v4 as uuidv4} from "uuid";

// variable
import debug from "debug";

const app = express();
//const socketApp = express(); // for socket.io
const info = debug('app:server:info');
const warn = debug('app:server:warn');

const sockets = new Map(); //webrtc audio stream
const producers = new Map(); // list of producers which are combined with there peerID

const ipcars = new Set();
const clients = new Set();
let clientUuids= []


const setByType = {
 ipcar: ipcars,
 client: clients,
};


// middleware
app.use(bodyParser.json());

app.use(cors());
// Handle production
if(process.env.NODE_ENV === 'production'){
    app.use(history());

    //static folder
      //app.use(express.static(__dirname, 'build'));
      //socketApp.use(express.static(__dirname + '/public'))  //socket.io

    //handle SPA
    app.get(/.*/, (req,res) =>res.sendFile(__dirname + 'guide.blade.php'));
    console.log(req.url)
    //socketApp.get(/.*/, (req,res) =>res.sendFile(__dirname + '/public/guide.blade.php')); //socket.io

}

//const wsPort = 6050
//const server = http.createServer(express);

//const wss = new WebSocket.Server({port: 6050}); // server voor webRTC live video stream

const server = http.createServer(app);
const wss1 = new WebSocket.Server({ noServer: true });  // wss1 is for exchanging data betweeen client and IP-car
const wss2 = new WebSocket.Server({ noServer: true }); // wss2 is for WebRTC

let carID = [];  // esp32 on IP-Car connectie
let carSmartphoneID = []; // smartphone in gimbal on IP-Car connectie
let controllerID = []; // esp32 in controller connectie
let clientID = []; // smartphone client(jean)


/////////////////////////////////////////////////////
          // websocket conection for data
////////////////////////////////////////////////////
wss1.on("connection", (ws, request) =>{
    console.log("new connection made")

    /// give every connection an Universally Unique Identifier
    ws.uuid = uuidv4().replace(/-/g, '_')
    ws.gps = false

   // clientUuids.unshift(ws.uuid)

    /// wordt eenmaal aangeroepen wanneer de connectie wordt gemaakt bij een nieuwe gebruiker
    if (request.url === '/ipcar_client') {  // stores the controller ID
       console.log("ipcar client/jean")
       clientID = ws.uuid
       ws.send(JSON.stringify(["welkom controller"]))// send welkom to
    }

    if (request.url === '/ipcar_car_smartphone') {  // stores the smartphone car ID
      console.log("ipcar client/jean")
      carSmartphoneID = ws.uuid
      ws.send(JSON.stringify(["welkom stream smartphone"]))
    }

    if (request.url === '/ipcar_car') {  // stores de car ID
      console.log("welkom to IP-Car")
      carID = ws.uuid
      ws.send(JSON.stringify(["welkom car "]))


      }

    ws.on("message", data=>{
    // console.log("incomming message" + request.url)
     //const msg = JSON.parse(data);

     //sending incoming client data to IPcar
     if (request.url === '/ipcar_client') {

         const msg = JSON.parse(data);

          //console.log(msg)
          if(msg.status == "gyro" ){
            wss1.clients.forEach(function each(ipcar_car){ // find Car websocket connection
              // console.log(client.uuid) // uuid of Car
              if(ipcar_car.uuid === carID && clientJean.readyState === WebSocket.OPEN){

               // console.log("sending control data from client to car")
                ipcar_car.send(JSON.stringify(msg)) // send control data to Car

              }

            })
      }
     }

       //sending incoming smartphone car gyroscope data to client(jean)
       if (request.url === '/ipcar_car_smartphone') {

        const msg = JSON.parse(data);

         //console.log(msg)
         if(msg.status == "gyroGimbal" ){
           wss1.clients.forEach(function each(client_ID){ // find Car camera websocket connection
             // console.log(client.uuid) // uuid of Car
             if (client_ID.uuid ===   clientID && client_ID.readyState === WebSocket.OPEN){
              // console.log("sending gyro data from phone to car")
              console.log("Camera gyro data to ip-car client")
              client_ID.send(JSON.stringify(msg)) // send gyroscope data Car

             }

           })

     }

    }

    })
    ws.on("close", ()=>{
       // remove client
        console.log("connection is closed: "+ws.uuid)


        // // sending an update to TD
        // wss1.clients.forEach(function each(client){
        //   if(client.uuid === touchDesignerID && client.readyState === WebSocket.OPEN){
        //       console.log("sending delete to TD")
        //       if(wss1.clients.size !=1){ // there is still 1 client or more
        //         client.send(JSON.stringify(["newUser",(wss1.clients.size-1)]))  // data is send the TD/Cas
        //       }else{ // all clients are gone
        //         client.send(JSON.stringify(["active",0]))
        //       }


        //     }
        // })

    })
})





/////////////////////////////////////////////////////
          // end websocket conection for data
////////////////////////////////////////////////////

/////////////////////////////////////////////////////
          // wss2 video/audio webrtc
////////////////////////////////////////////////////


// hier kan de video server komen
wss2.on('connection', async (socket,req) => {

  let peerId;
  var webURL =req.url

  //connectedClients.push({ socket,webURL});
  const onMessage = (e) => {
    //connectedClients.push(e);

    const msg = JSON.parse(e);


    if (msg.type === 'register') {
      peerId = msg.peerId;
      const { peerType } = msg;

      info(`${peerType} registered, id: ${peerId}`);
      console.log(`${peerType} registered, id: ${peerId}`)
      setByType[peerType].add(peerId);
      sockets.set(peerId, socket);

     // console.log( sockets);


     // this is if there are first clients before there is a IP-car
      if (peerType === 'ipcar') {
        socket.send(JSON.stringify({
          type: 'clients',
          clients: Array.from(clients), // send evry body who is watching to the tream
        }));
      }
      // when there is a new client send the new client to the IP-car
      if (peerType === 'client') {
        for (let ipcarId of ipcars) {
          const ipcarSocket = sockets.get(ipcarId);
          if (peerId == ipcarId.slice(0,8)){ // als de camera client id en  ipcar id het zelfde zijn stuur dan de screenId (broadcast car)
            ipcarSocket.send(JSON.stringify({
              type: 'clients',
              clients: [ peerId ],
            }));
          }
           else{
            console.log("client: "+peerId +" camera komt niet overeen met camera Ip-car: " + ipcarId.slice(0, 8));
            }

        }
      }
    }

    if (msg.type === 'offer') {
      console.log("offer")
      var selectedClient = msg.to
      if(msg.from.slice(0, 8)  == selectedClient){ /// vergelijkt het camera beeld met de geselcteerde auto
         console.log("camera en beeld zijn het zelfde");
        info(`camera ${msg.from} sent offer to screen ${msg.to}`);
        if (!clients.has(msg.to)) {
          warn(`offer sent to screen ${msg.to} that's not registered`);
          return;
        }

        var selectedCar = msg.to

        console.log(`camera ${msg.from} sent offer to screen ${selectedCar}`);
        const socket = sockets.get(msg.to);
        socket.send(JSON.stringify(msg));
      }  else{
        console.log("client: "+msg.to +" camera komt niet overeen met camera Ip-car: " + msg.from.slice(0, 8));
        }
    }

    if (msg.type === 'answer') {
     // console.log("antwoord ontvangen van scherm en stuur naar car")
        info(`screen ${msg.from} sent answer to camera ${msg.to}`);
        if (!ipcars.has(msg.to)) {
          warn(`offer sent to camera ${msg.to} that's not registered`);
          return;
        }

      const socket = sockets.get(msg.to);
      socket.send(JSON.stringify(msg));

    }

    if (msg.type === 'candidate') {
     // console.log(msg)
      info(`ice candidate from ${msg.from} to ${msg.to}`);
      const socketTo = sockets.get(msg.to);

      if (!socketTo) {
        warn(`candidate sent to ${msg.to}, that's not registered`);
        return;
      }

      socketTo.send(JSON.stringify(msg));
    }

  // }

  //   }else{
  //     console.log(obj.webURL+"is niet gelijk aan: "+ cameraURL);
  //       connectedClients.splice(i ,1);
  //   }
  //   })
  };

  const onClose = () => {
    info(`socket closed ${peerId}`);

    let sendDisconnectTo;
    if (clients.has(peerId)) {
      sendDisconnectTo = ipcars;
    }

    if (ipcars.has(peerId)) {
      sendDisconnectTo = clients;
    }

    for (let targetId of sendDisconnectTo) {
      sockets.get(targetId).send(JSON.stringify({
        type: 'disconnect',
        from: peerId
      }));
    }

    socket.off('message', onMessage);
    socket.off('close', onClose);

    ipcars.delete(peerId);
    clients.delete(peerId);
    sockets.delete(peerId);
  };

  socket.on('message', onMessage);
  socket.on('close', onClose);

});


/////////////////////////////////////////////////////
          // end wss2 video/audio webrtc
////////////////////////////////////////////////////

// upgrade om meerdere websockers servers mogelijk te maken op één poort
server.on('upgrade', function upgrade(request, socket, head) {
  //const { pathname } = parse(request.url);
  console.log(request.url)

  // websocket connection if you are a client
  if (request.url === '/ipcar_client') {
    wss1.handleUpgrade(request, socket, head, function done(ws) {
      wss1.emit('connection', ws, request);
       console.log("path is wright to server ")
    });
  }
  // websocket connectie smartphone on IP-Car
  if (request.url === '/ipcar_car_smartphone') {
    wss1.handleUpgrade(request, socket, head, function done(ws) {
      wss1.emit('connection', ws, request);
       console.log("path is wright to server ")
    });
  }

  //websocket connection when you are the car
  if (request.url === '/ipcar_car') {
    wss1.handleUpgrade(request, socket, head, function done(ws) {
      wss1.emit('connection', ws, request);
       console.log("path is wright to server ")
    });
 }

  // websocket connection for webRTC video/audio stream
  if (request.url === '/ipcar_stream') {
    wss2.handleUpgrade(request, socket, head, function done(ws) {
      wss2.emit('connection', ws, request);
       console.log("path is wright to webrtc ws server ")
    });
  }


});

  server.listen(6200,()=>console.log("websocket connection is listening on port 6200")); // port is used for websocket data en webRTC connection port 6200



//server.listen(wsPort,()=>console.log(`Websocket server is listening on port ${wsPort}`));

const port = process.env.PORT || 7000;
app.listen(port,()=>console.log(`Server started on port ${port}`));
