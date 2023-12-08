{{--Dit is de oude index.html (van Dominque). Dit werd gerefereerd op regel 43 van
server.js, dus ik heb het voor nu erin gelaten.--}}
<!doctype html>
<html >
<head>
    <title>IP-Car</title>
    <link rel="manifest" crossorigin="use-credentials" href="../js/ip_car_webapp/manifest.json"/>

    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="Car control">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0 viewport-fit=cover">

    <meta name="description" content="Control everything">
    <meta name="keywords" content="html tutorial template">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="expires" content="0">

    <!-- <script src="/js/Gradient.js" ></script>  -->
    <!-- <link rel="stylesheet" type="text/css" media="screen" href="css/styles.css"/> -->
    <link href="https://fonts.googleapis.com/css2?family=Lobster&family=Poppins:wght@700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="mainpage">
            <div id="landscape">
              <div class="information" >
                  <h4 class="namecar">IP CAR</h4>
                  <button class="connect" id="startButton" >Verbind</button>
                  <button class="camera" id="switchVideoFeed">Zie je zelf</button>
                  <ul>
                    <li>Status: <span id="status">Offline</span></p></li>
                    <!-- <li>Snelheid: 10km/h</li>
                    <li>Accu: 100%</li> -->

                    <div class="container">
                      <div class="wrapper-dropdown" id="dropdown">
                        <div class="setting-description-text" style="margin-left: 15px">
                          <h10>Kies je besturing</h10>
                        </div>
                        <span class="selected-display" id="destination"></span>
                        <svg id="drp-arrow" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="arrow transition-all ml-auto rotate-180">
                          <path d="M7 14.5l5-5 5 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                        <ul class="dropdown">
                          <li class="item">Touch</li>
                          <li class="item">Playstation</li>
                          <li class="item">ControlX</li>
                        </ul>
                      </div>
                    </div>
                    <!-- <li>Verlichting: {{light}}</li>
                    <li>Camera: {{camera}}</li> -->
                    <!-- <li>Pan: <span id="x">0</span></p></li>
                    <li>Roll <span id="y">0</span></p></li>
                    <li>Tilt: <span id="z">0</span></p></li> -->
                  </ul>
                  <div class="version">versie: 2.16</div>
                </div>
                <div class="videoFeed">
                  <div class="livefeedIP_Car">
                      <video mute='true' playsinline autoplay id='videoFeed'  ></video> <!--  //v-bind:style="{ 'border': '7px solid'+color1.hex+'' }" -->
                  </div>
                 <!-- <div class="livefeedOwn"> -->
                    <!-- <video mute='true' playsinline autoplay id='ownFeed'  ></video> &lt;!&ndash;  //v-bind:style="{ 'border': '7px solid'+color1.hex+'' }" &ndash;&gt;-->
                 <!-- </div> -->
                </div>
              <div id="joystick">
                <div class="joystick1">
                  <div id="stick1"></div>
                </div>
                <div class="joystick2">
                  <div id="stick2"></div>
                </div>
             </div>
              <!-- <MultiTouch  class="multitouch"/>       -->
           </div>
           <div id="portrait">
             <div class="welcomeText">
                <h1>Welkom</h1>
                <div class="welcomeInfo">
                  <p>Kantel je smartphone, in landscape mode om de app te gebruiken</p>
                  <p>Het is aan te raden om de website te installeren op het homescherm. Dit kan via de instellingen van de browser</p>
                </div>
             </div>
            </div>
          </div>
    </div>


    <!-- <script src="js/app.js"></script> -->
</body>
</html>
