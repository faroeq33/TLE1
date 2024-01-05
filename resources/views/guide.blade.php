@extends('layouts.app')

@section('head')
    <head>
        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="manifest" crossorigin="use-credentials" href="../js/ip_car_webapp/manifest.json"/>

        <meta name="mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta name="apple-mobile-web-app-title" content="Car control">
        <meta name="viewport"
              content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0 viewport-fit=cover">

        <meta name="description" content="Control everything">
        <meta name="keywords" content="html tutorial template">
        <meta http-equiv="Pragma" content="no-cache">
        <meta http-equiv="expires" content="0">

        <!-- <script src="/js/Gradient.js" ></script>  -->
        <!-- <link rel="stylesheet" type="text/css" media="screen" href="css/styles.css"/> -->
        <link href="https://fonts.googleapis.com/css2?family=Lobster&family=Poppins:wght@700&display=swap" rel="stylesheet">
        <!-- Scripts -->
        @vite(['resources/css/styles.css', 'resources/js/ip_car_webapp/app.js'])
    </head>
@endsection

@section('content')
    <body>
    <div class="mainpage">
        <div id="landscape">
            <div class="information">
                <h4 class="namecar">IP CAR</h4>
                <div x-data="{ connected: false }">
                    <button class="connect" id="startButton" @click="connected = !connected">
                        Verbind
                    </button>
{{--                    <button class="camera" id="switchVideoFeed">Zie je zelf</button>--}}

                    <div id="toggleButtons" x-show="connected" class="p-4 space-x-2">
                        <!-- Toggle Camera On/Off button. Hover is disabled for small screens (smartphones) -->
                        <button id="cameraToggle" x-data="{ cameraOff: false }"
                                :class="{ 'bg-red-500 border-2 border-red-500 lg:hover:bg-green-600 lg:hover:border-green-500': cameraOff, 'bg-green-500 border-2 border-green-500 lg:hover:bg-red-600 lg:hover:border-red-500': !cameraOff }"
                                @click="cameraOff = !cameraOff">
                            <img src="{{ Vite::asset('/public/storage/icons/webcam_blue.png') }}" alt="Camera icon"
                                 width="19" height="19" class="pointer-events-none" id="cameraIcon">
                        </button>

                        <!-- Toggle Mic On/Off button. Hover is disabled for small screens (smartphones) -->
                        <button id="micToggle" x-data="{ micOff: false }"
                                :class="{ 'bg-red-500 border-2 border-red-500 lg:hover:bg-green-600 lg:hover:border-green-500': micOff, 'bg-green-500 border-2 border-green-500 lg:hover:bg-red-600 lg:hover:border-red-500': !micOff }"
                                @click="micOff = !micOff">
                            <img src="{{ Vite::asset('/public/storage/icons/microphone_blue.png') }}"
                                 alt="Microphone icon"
                                 width="19" height="19" class="pointer-events-none" id="micIcon">
                        </button>

                        <!-- Trigger/Open The Modal -->
                        @auth
                            <button id="controllerButton">
                                <img src="{{ Vite::asset('/public/storage/icons/question_mark_blue.png') }}"
                                     alt="Help icon"
                                     width="19" height="19" class="pointer-events-none" id="helpIcon">
                            </button>

                            <!-- The Modal -->
                            <div id="controllerModal" class="modal">

                                <!-- Modal content -->
                                <div class="modal-content">
                                    <span class="close">&times;</span>
                                    <img src="{{ Vite::asset('/resources/img/SteeringInstructions.png') }}" alt="Instructions on driving the IP-Car. Hold W to go straight ahead. Hold A to steer to the left and hold D to steer to the right. Hold S to go backwards. Keep in mind that in order to turn, you have to hold both your steering key (A or D) and the W key.">
                                </div>

                            </div>
                        @endauth
                    </div>
                </div>

                <ul>
                    <li>Status: <span id="status">Offline</span></li>
                    <!-- <li>Snelheid: 10km/h</li>
                    <li>Accu: 100%</li> -->

                    <div class="container">
                        <div class="wrapper-dropdown" id="dropdown">
                            <div class="setting-description-text" style="margin-left: 15px">
                                <h10>Kies je besturing</h10>
                            </div>
                            <span class="selected-display" id="destination"></span>
                            <svg id="drp-arrow" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg" class="arrow transition-all ml-auto rotate-180">
                                <path d="M7 14.5l5-5 5 5" stroke="currentColor" stroke-width="1.5"
                                      stroke-linecap="round"
                                      stroke-linejoin="round"></path>
                            </svg>
                            <ul class="dropdown">
{{--                                <li class="item">Touch</li>--}}
                                <li class="item">Playstation</li>
{{--                                <li class="item">ControlX</li>--}}
                            </ul>
                        </div>
                    </div>
                    {{--                                        <!-- <li>Verlichting: {{light}}<li>--}}
                    {{--                                        <li>Camera: {{camera}}</li> -->--}}
                    {{--                                        <!-- <li>Pan: <span id="x">0</span></p></li>--}}
                    {{--                                        <li>Roll <span id="y">0</span></p></li>--}}
                    {{--                                        <li>Tilt: <span id="z">0</span></p></li> -->--}}
                </ul>
                <div class="version p-4">versie: 2.16</div>
            </div>

            <div class="videoFeed">
                <div class="livefeedIP_Car">
                    <video mute='true' playsinline autoplay id='streamFeed'></video>
                    <!--  //v-bind:style="{ 'border': '7px solid'+color1.hex+'' }" -->
                </div>
                <div class="livefeedOwn">
                    <video mute='true' playsinline autoplay id='ownFeed'></video>
                </div>
                <div class="livefeedViewers">
                    <img src="{{ Vite::asset('/public/storage/icons/user_group_blue.png') }}" alt="Placeholder image showing a group of users"
                         class="relative right-1/3 left-1/3 w-1/5 h-/3 overflow-hidden bg-gray-500 z-10">
                    >
                </div>
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
                    <p>Het is aan te raden om de website te installeren op het homescherm. Dit kan via de instellingen van
                        de browser</p>
                </div>
            </div>
        </div>
    </div>

    <!-- <script src="js/app.js"></script> -->
    </body>
@endsection

