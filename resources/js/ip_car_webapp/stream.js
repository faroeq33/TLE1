import "../../css/stream.css";
import Serial from "./elements/serial"

//let webUsb= new Serial();

let sendChannel = null // channel waarover data gestuurd gaat worden
let textDecoder = new TextDecoder();
let textEncoder = new TextEncoder("utf-8");
let endpoint = 4;
/// prevent installing home page but installs the stream page
window.addEventListener('beforeinstallprompt', (e) => {
  e.preventDefault();
  })

let startButton = document.getElementById("startButton");
let switchVideoFeed= document.getElementById("switchVideoFeed");
let videoFeed = document.getElementById("videoFeed");

let cameraFunctions = document.getElementById("cameraToggle");
let micFunctions= document.getElementById("micToggle");
let modal= document.getElementById("controllerModal");
let modalBtn = document.getElementById("controllerButton");
let modalSpan = document.getElementsByClassName("close")[0];

let device = null
let result
let portrait = true;
let landscape = false;
let verbonden = false
let sender = null;

let changeColors = []
let ws;
let wsConnection = false;

let pan = 0;
let tilt= 0;
let roll = 0;

let clientStream
let ownStream

let clientFeed = false
let ownFeed = false; // switch value video feed

let incomingData = {
  st: 1500,
  sp: 1500
 }// data from app.js
let dataToArduino
let startTimer = false;
let disconnectTimer =3000 // after 3 seconds no webRTC UDP data, stop car.
let timeOutFunction = null // timeout function for disconnect

loadModeScreen()

function loadModeScreen(){
  if(window.innerWidth > window.innerHeight) {
    portrait= false
    landscape= true
   console.log("landscape")
   document.getElementById("portrait").style.display = "none"
   document.getElementById("landscape").style.display = "block"

 }
 if(window.innerHeight> window.innerWidth) {
   portrait= true
   landscape= false
   console.log("portrait")
   document.getElementById("portrait").style.display = "block"
   document.getElementById("landscape").style.display = "none"
 }
}


window.addEventListener('resize', loadModeScreen)

startWebsocket()

////////////////////////////////////////////// begin verbindt button ////////////////////////
startButton.onclick =  async function(e) {
  //this for the usb controller (custom made controller)

 navigator.usb.requestDevice({ filters: [   { 'vendorId': 0x1b4f, 'productId': 0x9204}] })
 .then(selectedDevice => {
     device = selectedDevice;
     if(verbonden==false){
      document.getElementById("status").innerHTML = "USB ok, wacht op controller"
     }
     return device.open(); // Begin a session.
   })
 .then(() => device.selectConfiguration(1)) // Select configuration #1 for the device.
 .then(() => device.claimInterface(2)) // Request exclusive control over interface #2.
 .then(() => device.controlTransferOut({
     requestType: 'class',
     recipient: 'interface',
     request: 0x22,
     value: 0x01,
     index: 0x02})) // Ready to receive data
.then(() => {readloop()})
.then(() => device.transferIn(5, 64)) // Waiting for 64 bytes of data from endpoint #5.
.then(result => {
  const decoder = new TextDecoder();
  console.log('Received: ' + decoder.decode(result.data));
 readloop();// start reading
})// Waiting for 64 bytes of data from endpoint #5.
 .catch(error => {
  console.error(error);
  document.getElementById("status").innerHTML = "USB error"
 });

 //if (device.opened){
  //console.log("conedted")
  // };
  videoStream();

   // ios device
   if (DeviceOrientationEvent && typeof(DeviceOrientationEvent.requestPermission) === "function") {

    const permissionState = await DeviceOrientationEvent.requestPermission();

      if (permissionState === "granted") {
          // Permission granted

         // document.getElementById("status").innerHTML = "Gryscope and GPS  Allowed Mobile"
          window.addEventListener("deviceorientation", (event) => {
            const leftToRight= event.alpha; // alpha: rotation around z-axis
            const rotateDegrees = event.beta; // gamma: left to right
            const upToDown = event.gamma; // beta: front back motion

              /// Normalize values
             // pan = leftToRight
              if(upToDown>1){

                tilt =upToDown
              }else{
             //   tilt = map(-1*upToDown, 90,0,90,180)
              }

             // tilt= map(tilt, 0,180,180,0)

         console.log({"Status":"gyroGimbal", "pan": Math.round(pan), "roll":Math.round(rotateDegrees),"tilt":Math.round(tilt)})

         ws.send(JSON.stringify({"status":"gyroGimbal","pan": Math.round(pan),"roll":Math.round(rotateDegrees),"tilt":Math.round(tilt)}))

        }, true);

      }
  }else{ // other devices than ios
     // document.getElementById("status").innerHTML = "Gryscope Allowed Desktop"

      window.addEventListener("deviceorientation", (event) => {
        const leftToRight= event.alpha; // alpha: rotation around z-axis pan
        const rotateDegrees = event.beta; // gamma: left to right tilt
        const upToDown = event.gamma; // beta: front back motion roll
       // document.getElementById("status").innerHTML = "Gryscope and GPS  Allowed Mobile"

        /// Normalize values
         // pan = leftToRight
          if(leftToRight<90){
            pan= map(-1*upToDown, 90,0,0,90)
          }else if(leftToRight>270 & leftToRight<360){
           pan = map(-1*upToDown, 360,270,90,180)
          }

          if(upToDown>1){
              tilt =upToDown
            }else{
             tilt = map(-1*upToDown, 90,0,90,180)
            }

       console.log({"Status":"gyroGimbal", "pan": Math.round(pan), "roll":Math.round(rotateDegrees),"tilt":Math.round(tilt)})

       ws.send(JSON.stringify({"status":"gyroGimbal","pan": Math.round(pan),"roll":Math.round(rotateDegrees),"tilt":Math.round(tilt)}))

      } , true);
  }
}
////////////////////////////////////////////// eind verbindt button ////////////////////////

/////////////////////////// function that read continues data from arduino pro micro

async function readloop(){

  device.transferIn(5, 64).then(result => {
    console.log(textDecoder.decode(result.data))
    readloop()
  }, error => {
    console.log(error)
  });

}
/////////////////////////// function that send continues data to arduino pro micro
async function sendloop(){

  if(device != null && device.opened == true){
   // console.log(device)
    dataToArduino = await device.transferOut(endpoint,textEncoder.encode(incomingData))

    if (dataToArduino.status === "stall") {
          console.warn("Endpoint stalled. Clearing.");
          await device.clearHalt("IN", 5);
    }
  }else{
    document.getElementById("status").innerHTML = "Check USB Connection"
  }

}


function map( x,  in_min,  in_max,  out_min,  out_max){ // maps de waardes van de controller zodat de de ESC ze begrijpt
  return ((x - in_min) * (out_max - out_min) / (in_max - in_min) + out_min).toFixed(0)
}

function startWebsocket(){

 // will run code on page load

 ws = new WebSocket('wss://ipcar.nl:6100/ipcar_car_smartphone');  //'wss://stepverder.nl:4084/controller' 'wss://fox-connect.nl:6000'
 //console.log("websocket")

 ws.onopen = (event) => {
   //console.log(ws)
   if (ws.readyState === 1) {
     wsConnection= true;

     console.log("WS connectie for data excahnge with server")
   }
 };

 ws.onmessage = function (event) {
   try {
     var msg = JSON.parse(event.data);
      console.log(msg)
     if(msg[0] == "ipcar"){ // incoming uuid data on connection from server and send back to TD/Cas
       wsUUID = msg[1]
      // console.log("uuid: "+ wsUUID)

     }


   } catch (err) {
    // console.log(err);
   }
 };

 ws.onerror = (e) => {
  document.getElementById("status").innerHTML = "Server error"
   // an error occurred
  // console.log(e.message);
 };

} // end webscoket connection smartphone IP-Car

switchVideoFeed.onclick =  async function(e) { // switch betweeen own camera and IP-Camera

  device.transferOut(endpoint,textEncoder.encode(JSON.stringify({test:3,hallo:"meesage"})))


  if(ownFeed == false && ownFeed == false){
   // document.getElementById("switchVideoFeed").innerHTML = "zie de ander"
  // window.videoFeed.volume = 0;
  // window.videoFeed.muted = 0;
    videoFeed.srcObject = ownStream;
   // window.videoFeed.play();
    ownFeed =true
    clientFeed =false
    return
  }
  if(clientFeed == false && ownFeed == true){
   //document.getElementById("switchVideoFeed").innerHTML = "zie je zelf"
  // window.videoFeed.volume = 0;
   //window.videoFeed.muted = 0;
    videoFeed.srcObject = clientStream
  // window.videoFeed.play()
    ownFeed =false;
    clientFeed =true
    return
  }

 }




 async function stopcar(){ // no UDP data after default 3 seconds
  console.log("no udp data coming in")
  incomingData = {
    st: 1500,
    sp: 1500
   }
 }

async function videoStream(){ /// begin video verbinding
  /// websocket WebRTC for live stream

  //console.log("in camera")
  const config = {
    iceServers: [{
      urls: 'turn:turn.stepverder.nl:3478', //'stun:stun.l.google.com:19302'  turn:178.62.209.37:3478 circusfamilyprojects.nl
       username: 'Dominique',
       credential: 'WS7Yq_jT'

    },],
    codecs: [
      { mimeType: "video/AV1" },
      { mimeType: "video/vp9" },
      { mimeType: "video/vp8" },
      { mimeType: "video/h264" },
    ]

  };
  // const getRandomId = () => {
  //   return Math.floor(Math.random() * 10000);
  // };
  const peerId = "jeanUser_ipcar"
  const peerType = 'ipcar';
  const connections = new Map();
  let ws;
  const getSocket = async (peerId, peerType) => {
    if (ws) return ws;
    return new Promise((resolve, reject) => {
      try {
        const protocol = (
          window.location.protocol === 'https:' ?
            'wss:' :
            'ws:'
        );
        ws = new WebSocket('wss://ipcar.nl:6100/ipcar_stream');  // ws://localhost:4083 online server wss://circusfamilyprojects.nl:8084
        console.log(ws)
        const onOpen = () => {

          ws.send(JSON.stringify({
            type: 'register',
            peerType,
            peerId,
          }));
          ws.removeEventListener('open', onOpen);
          resolve(ws);
        };
        ws.addEventListener('open', onOpen);
      } catch (e) {
        reject(e);
      }
    });
  };
  try {
    console.log('in camera');
  // console.log(this.carNumber);
    const mediaStream = await navigator.mediaDevices.getUserMedia({
       video: {
              width: {prefer: 1920},
              height: {prefer: 1080},
              frameRate: {
                           min: 25,
                           max: 60
                          },
              facingMode: 'environment'
              },
      audio: {
        AutoGainControl: true,
        EchoCancellation: true,
        NoiseSuppression: true
      },
    });
    mediaStream.echoCancellation = true
    ownStream = mediaStream
    videoFeed.srcObject = mediaStream;
   // window.videoFeed.volume = 0;
   // window.videoFeed.muted = 0;
    videoFeed.play();


    const socket = await getSocket(peerId, peerType);
    socket.addEventListener('message', async (e) => {
         //  console.log(e);
      const msg = JSON.parse(e.data);
      console.log('msg', msg);
      if (msg.type === 'clients') {
        console.log("krijg alle clients binnen")

        for (let client of msg.clients) {
          console.log(client)
          const peerConnection = new RTCPeerConnection(config);
          connections.set(client, peerConnection);
          // peerConnection.addStream(window.v.srcObject);

          sendChannel = peerConnection.createDataChannel('sendDataChannel', {ordered: false, maxRetransmits: 0})
          sendChannel.onopen = function(event) {
            verbonden = true
                document.getElementById("status").innerHTML = "Verbonden"
                console.log("hi you")
                sendChannel.send(['Hi Arduino!']);
          }
          sendChannel.onmessage= async(event)=>{
            //console.log(event.data)
            incomingData = event.data

            if (startTimer ==false){
              timeOutFunction = setTimeout(stopcar, 3000)// stop car after 3 seconds
              startTimer = true
            }else if (startTimer == true){ // reset timer because connection is still there
              clearTimeout( timeOutFunction);
              sendloop();

              startTimer = false
            }


          }

          peerConnection.ontrack = (e) => {
            console.log('on track', e);
            clientStream = e.streams[0];
            videoFeed.srcObject = e.streams[0];
           //window.videoFeed.volume = 1;
           // window.videoFeed.muted = 1;
             videoFeed.play();
            //window.wait.classList.add('hidden');
           // window.controls.classList.remove('hidden');
          };

          for (let track of mediaStream.getTracks()) {
           peerConnection.addTrack(track, mediaStream);

           //peerConnection.getSenders()[0].getParameters().encodings[0].maxBitrate = 90000; //90kbs audio

           }
           const audioparameters = peerConnection.getSenders()[0]
           const videoparameters = peerConnection.getSenders()[1]

           audioparameters.getParameters().encodings[0].maxBitrate = 90000; //90kbs audio
           audioparameters.setParameters(audioparameters.getParameters()).then(success, error);
           console.log(audioparameters)

          videoparameters.getParameters().encodings[0].maxBitrate = 1000000; //1000kbs video
          videoparameters.setParameters(videoparameters.getParameters()).then(success, error);
          //console.log(peerConnection.getSenders()[1].getParameters().encodings[0])



          function success(){
              console.log("bandwidth success adjust");
          };

          function error(err){
              console.log("bandwidth error"+err);
          };


          const sdp = await peerConnection.createOffer();
          await peerConnection.setLocalDescription(sdp);



          peerConnection.onicecandidate = (e) => {
            if (e.candidate) {
              console.log("set ice candidate")
             // console.log(e)

              socket.send(JSON.stringify({
                type: 'candidate',
                from: peerId,
                to: client,
                data: e.candidate,
              }));
            }
          };

          socket.send(JSON.stringify({
            type: 'offer',
            to: client,
            from: peerId,
            data: peerConnection.localDescription,
          }));
          //console.log(peerConnection.localDescription.sdp)
        console.log(peerConnection.connectionState)
        }
      }
      if (msg.type === 'answer') {
       // console.log("antwoord van screen")
        const peerConnection = connections.get(msg.from);
        await peerConnection.setRemoteDescription(msg.data);
        console.log(peerConnection)
      }
      if (msg.type === 'disconnect') {
        const connection = connections.get(msg.from);
        verbonden = false
        // stops IP-Car
        incomingData = {
          st: 1500,
          sp: 1500
         }

         document.getElementById("status").innerHTML = "Connection lost"
        if (connection) {
         // console.log('Disconnecting from', msg.from);
          connection.close();
          connections.delete(msg.from);
        }
      }
      if (msg.type === 'candidate') {
        const connection = connections.get(msg.from);

        //console.log(connection.getSenders()[0].getParameters())
        if (connection) {
         // console.log('Adding candidate to', msg.from);

          connection.addIceCandidate(new RTCIceCandidate(
            msg.data
          ));

          console.log(connection.connectionState)
        }
      }
    });
  } catch (e) {
    verbonden = false
    console.log("error: "+e);
    document.getElementById("status").innerHTML = "Server error"
    videoStream()
  }

}  // einde video verbinding

cameraFunctions.onclick =  async function(e) { // Turn your own camera on or off
    // let image = document.getElementById("cameraIcon").src;
    //
    // if (image.indexOf('webcam_blue.png')!==-1) {
    //     document.getElementById('cameraIcon').src  = "/public/storage/icons/webcam_black.png"
    // }
    // else {
    //     document.getElementById('cameraIcon').src = "/public/storage/icons/webcam_blue.png"
    // }

    ownStream.getVideoTracks().forEach(track => {
        track.enabled = !track.enabled
    });
}

micFunctions.onclick =  async function(e) { // Turn your own microphone on or off
    ownStream.getAudioTracks().forEach(track => {
        track.enabled = !track.enabled
    });
}

// When the user clicks on the button, open the modal
modalBtn.onclick = function() {
    modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
modalSpan.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
