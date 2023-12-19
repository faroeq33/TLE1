import "../../css/styles.css"
import JoystickController from "./elements/joystick"


let options = {

  'protocol': "wss",
};

let joystick1 = new JoystickController("stick1", 64, 8); // id, maxdistance, deadzone
let joystick2 = new JoystickController("stick2", 64, 8); // id, maxdistance, deadzone

let joystickValue1
let joystickValue2

  // controls playstation controoler
let kruisje
let speed
let reverse
let  xAxesLeft

let sendSpeedValue;

let device = null
let textDecoder = new TextDecoder();
let textEncoder = new TextEncoder("utf-8");

//const client  = mqtt.connect('mqtt://ipcar.nl:1883',options)

let startButton = document.getElementById("startButton");
let switchVideoFeed= document.getElementById("switchVideoFeed");
let touchCheckBox = document.getElementById ("checkbox");
let videoFeed = document.getElementById("videoFeed");

let cameraFunctions = document.getElementById("cameraToggle");
let micFunctions= document.getElementById("micToggle");
let modal= document.getElementById("controllerModal");
let modalBtn = document.getElementById("controllerButton");
let modalSpan = document.getElementsByClassName("close")[0];

let portrait = true;
let landscape = false;


let ws; // connectie for websocket sending data to TD
let wsUUID;


let wsConnection = false;
let socket =null
let dataChannel = null
let sendedData ={}
let verbonden = false

let panPosistion = 0;
let tiltPosistion= 0;
let rollPosistion = 0;

let panSpeed = 0;
let tiltSpeed= 0;
let rollSpeed = 0;

let incomingPan = 0;
let incomingTilt = 0;
let incomingRoll = 0;

let ipCarStream
let ownStream

let ipCarFeed = false
let ownFeed = false; // switch value video feed

let gamePad = null;
let checkBox={checked:false}

window.addEventListener("scroll", (e) => { // prevent scrolling
  e.preventDefault();
  window.scrollTo(0, 0);
});

loadModeScreen()

loop()

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
///////////////////////////////////////////////////////////
function loop()
{
	requestAnimationFrame(loop);
	update();
}

function update(){
  //console.log(joystick1.value.x)

 joystickValue1 = map(joystick1.value.x,-1,1,1000,2000); //x as linkerkant sturen steering
 joystickValue2 = map(joystick2.value.y,-1,1,1400,1600); //y as rechterkant sturen speed

 sendedData = {
  st: joystickValue1,
  sp: joystickValue2
 }

 if(verbonden == false ){

 }else if (verbonden == true && gamePad != null){
  console.log("joepie send "+ gamePad + " data")
  dataChannel.send(JSON.stringify(sendedData))
 }
}

function switchController(){

  if(gamePad == "ControlX"){ // aansluiten via usb
    controlX();
  }

  if(gamePad == "Playstation"){ // bluetooth
    gameController();
  }
   // touch controlls
   if (gamePad == "Touch"){ // toushscreen
    console.log("Cheked")
    document.getElementById("joystick").style.display = "block"

   } else {
     console.log("un Cheked")
     document.getElementById("joystick").style.display = "none"

   }
}

window.addEventListener('gamepadconnected', (event) => {
  const update = () => {
    const gamepads = navigator.getGamepads()
    console.log(gamepads);

      if(gamepads[0]){
        // console.log(gamepads[0]);
       let gamepadState ={
          id: gamepads[0].id,
          axes:[
              gamepads[0].axes[0],
          ],
          buttons:[
              {button_1: gamepads[0].buttons[0].value},
              {button_3: gamepads[0].buttons[3].value},
              {button_4: gamepads[0].buttons[4].value},
              {button_5: gamepads[0].buttons[5].value},
              {button_6: gamepads[0].buttons[6].value},
              {button_7: gamepads[0].buttons[7].value},
              {button_9: gamepads[0].buttons[7].value},
              {button_14: gamepads[0].buttons[14].value},
              {button_15: gamepads[0].buttons[15].value},
          ]
        }

        // set button values eagle to vue variable so they can be send via OSC

        kruisje = gamepads[0].buttons[0].value;  // kruisje
      // this.L1 = gamepads[0].buttons[4].value;  //L1
      // this.R1 = gamepads[0].buttons[5].value;  //R1

      // maping speed to km/h
        speed = map(gamepads[0].buttons[6].value,0,1,1500,1600);  //R2
        reverse = map(gamepads[0].buttons[7].value,0,1,1500,1400);  //L2
        joystickValue1 = map(gamepads[0].axes[0],-1,1,1000,2000); //x as linkerkant sturen
      //  this.BL = gamepads[0].buttons[14].value;  //Button left
      //  this.BR = gamepads[0].buttons[15].value;  //Button right


      // function zodat je niet kan remmen en gas geven tegelijk
      if( speed >1501){
        joystickValue2= speed // send voorruit rijden
      } else if(reverse <1501){
        joystickValue2 = reverse // send achteruit rijden
      }else if(reverse <1499 && speed >1501){
        joystickValue2 = 1500; // voor en achteruit tegelijk is 0
      }
      //console.log(   joystickValue1)

      if(verbonden == false){

      }else if (verbonden == true && gamePad != null){

        sendedData = {
          st: joystickValue1,
          sp: joystickValue2
         }

       dataChannel.send(JSON.stringify(sendedData))
      }
    }
    requestAnimationFrame(update);
  };
  update();
});

function gameController(){
  // gamepadconnected with pc for the ps4 controller

    window.addEventListener("gamepadconnected", () => {
        //this.hideGamepad = false;
        console.log("controller")
        inputController();
       //gamepads is an array with all the gamepad buttons
      // gamePads = navigator.getGamepads();


      });

     // gamepadconnected disconnected with pc
     window.addEventListener("gamepaddisconnected", () => {
        // this.hideGamepad = true;
   });

}

function controlX(){
  //this for the usb controller (custom made controller)
  navigator.usb.requestDevice({ filters: [   { 'vendorId': 0x1b4f, 'productId': 0x9204}] })
 .then(selectedDevice => {
     device = selectedDevice;
     if(verbonden==false){
      document.getElementById("status").innerHTML = "ControlX ok, wacht op beeld"
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
  //console.log('Received: ' + decoder.decode(result.data));
 readloop();// start reading
})// Waiting for 64 bytes of data from endpoint #5.
 .catch(error => {
  console.error(error);
  document.getElementById("status").innerHTML = "USB error"
 });
}
 // einde input controller

/////////////////////////// function that read continues data from arduino pro micro
async function readloop(){

  device.transferIn(5, 64).then(result => {
    if(textDecoder.decode(result.data).charAt(0) === "{"){// filter arduino serial input values
      const obj = JSON.parse(textDecoder.decode(result.data))
      console.log(obj)
     }
    readloop()
  }, error => {
    console.log(error)
  });

} ///////////

startWebsocket();


startButton.onclick =  async function(e) {
  videoStream();
  //startWebsocket()

    // ios device
    if (DeviceOrientationEvent && typeof(DeviceOrientationEvent.requestPermission) === "function") {

      const permissionState = await DeviceOrientationEvent.requestPermission();

        if (permissionState === "granted") {
            // Permission granted

           // document.getElementById("status").innerHTML = "Gyro allowed"
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

          //  console.log({"Status":"gyro", "pan": Math.round(pan), "roll":Math.round(rotateDegrees),"tilt":Math.round(tilt)})
            //client.publish('ipcar', JSON.stringify([leftToRight,rotateDegrees,upToDown]))

           // ws.send(JSON.stringify({"status":"gyro","pan": Math.round(pan),"roll":Math.round(rotateDegrees),"tilt":Math.round(tilt)}))
                  }, true);

        } else {



        }
    }else{ // other devices than ios
       // document.getElementById("status").innerHTML = "Gryscope Allowed Desktop"
        // this isnt really important, for now
        window.addEventListener("deviceorientation", (event) => {
          const leftToRight= event.alpha; // alpha: rotation around z-axis pan
          const rotateDegrees = event.beta; // gamma: left to right tilt
          const upToDown = event.gamma; // beta: front back motion roll

          /// Normalize values
           // pan = leftToRight
            if(leftToRight<90){
            //  pan= map(-1*upToDown, 90,0,0,90)
            }else if(leftToRight>270 & leftToRight<360){
          //   pan = map(-1*upToDown, 360,270,90,180)
            }

              if(upToDown>1){

        //        tilt =upToDown
              }else{
        //        tilt = map(-1*upToDown, 90,0,90,180)
              }

        //  console.log({"Status":"gyro", "pan": Math.round(pan), "roll":Math.round(rotateDegrees),"tilt":Math.round(tilt)})
          //client.publish('ipcar', JSON.stringify([leftToRight,rotateDegrees,upToDown]))

          // ws.send(JSON.stringify({"status":"gyro","pan": Math.round(pan),"roll":Math.round(rotateDegrees),"tilt":Math.round(tilt)}))

      }, true);


    }
    // this isnt really important, for now rhis is for custom controll with device motion but isnt used
    window.addEventListener('devicemotion', (event) => {

      const x = event.rotationRate.alpha; // pan
      const y = event.rotationRate.beta; // roll
      const z = event.rotationRate.gamma; // tilt

      panSpeed =   map(x, -100,100,2047,0)
      rollSpeed =  map(y, -100,100,0,2047)
      tiltSpeed =  map(z, -100,100,2047,0)

      if(x>-4 && x< 4){
        pan = 1023
      }
      if(y>-4 && y< 4){
        roll = 1023
      }
      if(z>-4 && z< 4){
       tilt = 1023
      }

      document.getElementById("x").innerHTML = Math.round(panSpeed)
      document.getElementById("y").innerHTML = Math.round(rollSpeed)
      document.getElementById("z").innerHTML = Math.round(tiltSpeed)

      ws.send(JSON.stringify({"status":"gyro","pan": Math.round(panSpeed),"roll":Math.round(rollSpeed),"tilt":Math.round(tiltSpeed)}))
    },true);
}////////////////////////////////////////////// eind start knop

function map( x,  in_min,  in_max,  out_min,  out_max){ // maps the values from controller so the ESC can read them
  return ((x - in_min) * (out_max - out_min) / (in_max - in_min) + out_min).toFixed(0)
}
 // webscoket connection sending control data
function startWebsocket(){

  // will run code on page load
  ws = new WebSocket('wss://ipcar.nl:6100/ipcar_client');  //'wss://stepverder.nl:4084/controller' 'wss://fox-connect.nl:6000'
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

      if(msg[0] == "ipcar"){ // incoming uuid data on connection from server
        wsUUID = msg[1]
       // console.log("uuid: "+ wsUUID)

      }

    } catch (err) {
     // console.log(err);
    }
  };

  ws.onerror = (e) => {
    // an error occurred
   // console.log(e.message);
  };

}
 // end webscoket connection sending control data

switchVideoFeed.onclick =  async function(e) { // switch betweeen own camera and IP-Camera

  if(ownFeed == false && ownFeed == false){
    //document.getElementById("switchVideoFeed").innerHTML = "zie de ander"
    window.videoFeed.srcObject = ownStream;
   // window.videoFeed.play();
    ownFeed =true
    ipCarFeed =false
    return
  }
  if(ipCarFeed == false && ownFeed == true){
   // document.getElementById("switchVideoFeed").innerHTML = "zie je zelf"
    window.videoFeed.srcObject = ipCarStream
  // window.videoFeed.play()
    ownFeed =false;
    ipCarFeed =true
    return
  }

 }

async function videoStream(){ /// begin video verbinding
              /// websocket WebRTC for live stream

            //  console.log("in camera client")
              const config = {
                iceServers: [{
                  urls: 'turn:turn.stepverder.nl:3478', //'stun:stun.l.google.com:19302'  turn:178.62.209.37:3478 circusfamilyprojects.nl
                   username: 'Dominique',
                   credential: 'WS7Yq_jT'

                }],
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
              const peerId = "jeanUser"
              const peerType = 'client';
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
                   // console.log(ws)
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
               // document.getElementById("status").innerHTML = "Finding camera"
                console.log('in camera');
                document.getElementById("status").innerHTML = "Wacht op IP-Car"
              // console.log(this.carNumber);
                const mediaStream = await navigator.mediaDevices.getUserMedia({
                   video: {
                          width: {prefer: 1920},
                          height: {prefer: 1080},
                          frameRate: {
                                       min: 25,
                                       max: 60
                                      }
                          },
                  audio: {
                      AutoGainControl: true,
                      EchoCancellation: true,
                      NoiseSuppression: true
                  },
                });
                ownStream =  mediaStream
                window.videoFeed.srcObject = mediaStream;
                // window.videoFeed.volume = 0;
                // window.videoFeed.muted = 0;
                window.videoFeed.play();

               // document.getElementById("status").innerHTML = "Own camera feed"

                const socket = await getSocket(peerId, peerType);
                socket.addEventListener('message', async (e) => {
                  //console.log(e)
                  try {
                    const msg = JSON.parse(e.data)
                     console.log(msg)

                    if (msg.type === 'offer') {
                      const peerConnection = new RTCPeerConnection(config);
                      connections.set(msg.from, peerConnection);
                        console.log('incoming data ');
                        document.getElementById("status").innerHTML = "Server ok, wacht op IP-Car"

                      peerConnection.ontrack = (e) => {
                        console.log('on track', e);
                        ipCarStream = e.streams[0];
                        window.videoFeed.srcObject = e.streams[0];
                         window.videoFeed.play();
                         document.getElementById("status").innerHTML = "Verbonden"
                        //window.wait.classList.add('hidden');
                       // window.controls.classList.remove('hidden');
                      };

                      peerConnection.ondatachannel=(event) =>{
                        verbonden = true
                        dataChannel = event.channel
                        document.getElementById("status").innerHTML = "Verbonden"
                        console.log("datachannel")
                      }




                      peerConnection.onicecandidate = (e) => {
                          console.log('set icecandidate');
                          //console.log( e.candidate);
                        if (e.candidate) {
                          socket.send(JSON.stringify({
                            type: 'candidate',
                            from: peerId,
                            to: msg.from,
                            data: e.candidate,
                          }));
                        }
                      };
                      await peerConnection.setRemoteDescription(msg.data);

                      for (let track of mediaStream.getTracks()) {
                        peerConnection.addTrack(track, mediaStream);
                        //console.log(track)
                      }


                      const sdp = await peerConnection.createAnswer();
                      await peerConnection.setLocalDescription(sdp);

                     // console.log('sending answer');
                      socket.send(JSON.stringify({
                        to: msg.from,
                        from: peerId,
                        type: 'answer',
                        data: peerConnection.localDescription
                      }));
                    }
                    if (msg.type === 'disconnect') {
                      verbonden = false;
                      document.getElementById("status").innerHTML = "Connection lost"
                      const connection = connections.get(msg.from);
                      if (connection) {

                        console.log('Disconnecting from', msg.from);
                        connection.ontrack = null;
                        connection.ondatachannel = null;
                        connection.onicecandidate = null;
                        connection.close();
                        connections.delete(msg.from);
                      }
                    }
                    if (msg.type === 'candidate') {
                      console.log(msg.data)
                      //document.getElementById("status").innerHTML = "Wacht op IP-Car"
                      const connection = connections.get(msg.from);
                        //console.log(connection)
                      if (connection) {
                        console.log('Adding candidate to', msg.from);
                        connection.addIceCandidate(new RTCIceCandidate(
                          msg.data
                        ));

                      }
                    }

                  } catch (e) {
                    console.error(e);
                         console.log("error video beeld niet ontvangen "+ e)
                         document.getElementById("status").innerHTML = "Error, verbind opnieuw"
                         videoStream()
                  }
                });
               } catch (e) {
                  console.error(e);
                  console.log("error verbinding mislukt: "+e)
                  document.getElementById("status").innerHTML = "Error, verbind opnieuw"
                }

          } // einde video verbinding

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

//////////////////////
const selectedAll = document.querySelectorAll(".wrapper-dropdown");

selectedAll.forEach((selected) => {
  const optionsContainer = selected.children[2];
  const optionsList = selected.querySelectorAll("div.wrapper-dropdown li");

  selected.addEventListener("click", () => {
    let arrow = selected.children[1];

    if (selected.classList.contains("active")) {
      handleDropdown(selected, arrow, false);
    } else {
      let currentActive = document.querySelector(".wrapper-dropdown.active");

      if (currentActive) {
        let anotherArrow = currentActive.children[1];
        handleDropdown(currentActive, anotherArrow, false);
      }

      handleDropdown(selected, arrow, true);
    }
  });

  // update the display of the dropdown
  for (let o of optionsList) {
    o.addEventListener("click", () => {
      selected.querySelector(".selected-display").innerHTML = o.innerHTML;
      gamePad = o.innerHTML
      switchController()
      console.log(o.innerHTML);

    });
  }
});

// check if anything else ofther than the dropdown is clicked
window.addEventListener("click", function (e) {
  if (e.target.closest(".wrapper-dropdown") === null) {
    closeAllDropdowns();
  }
});

// close all the dropdowns
function closeAllDropdowns() {
  const selectedAll = document.querySelectorAll(".wrapper-dropdown");
  selectedAll.forEach((selected) => {
    const optionsContainer = selected.children[2];
    let arrow = selected.children[1];

    handleDropdown(selected, arrow, false);
  });
}

// open all the dropdowns
function handleDropdown(dropdown, arrow, open) {
  if (open) {
    arrow.classList.add("rotated");
    dropdown.classList.add("active");
  } else {
    arrow.classList.remove("rotated");
    dropdown.classList.remove("active");
  }
}
