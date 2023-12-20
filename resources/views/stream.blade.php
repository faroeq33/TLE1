@extends('layouts.app')

@section('head')
    <head>
        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="manifest" href="../js/ip_car_webapp/manifest.json"/>

        <meta name="mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta name="apple-mobile-web-app-title" content="Car control">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0 viewport-fit=cover">

        <meta name="description" content="Control everything">
        <meta http-equiv="cache-control" content="no-cache"/>
        <meta http-equiv="Cache-Control" content="no-store"/>
        <meta http-equiv="Pragma" content="no-cache">
        <meta name="keywords" content="html tutorial template">
        {{--    <link rel="stylesheet" type="text/css" media="screen" href="../css/stream.css"/>--}}
        <link href="https://fonts.googleapis.com/css2?family=Lobster&family=Poppins:wght@700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/stream.css', 'resources/js/ip_car_webapp/stream.js'])
    </head>
@endsection

@section('content')
    <div class="application">
        <div id="landscape">
            <div class="information" >
                <h4 class="namecar">IP CAR Stream</h4>
                <button class="connect" id="startButton" >Verbind</button>
                <button class="camera" id="switchVideoFeed">Zie je zelf</button>
                <ul>
                    <li>Status: <span id="status">Offline</span></li>
                </ul>

                <!-- <li>Pan: <span id="x">0</span></p></li>
                <li>Roll <span id="y">0</span></p></li>
                <li>Tilt: <span id="z">0</span></p></li> -->
                <div class="version">versie: 2.16</div>
            </div>
            <div class="videoFeed">
                <div class="liveVideoFeed">
                    <video mute='true' playsinline autoplay id='videoFeed'  ></video> <!--  //v-bind:style="{ 'border': '7px solid'+color1.hex+'' }" -->
                </div>
            </div>

            <div id="toggleButtons">
                <!-- Toggle Camera On/Off button -->
                <button id="cameraToggle">
                    <img src="{{ Vite::asset('/public/storage/icons/webcam_blue.png') }}" alt="Camera icon" width="19"
                         height="19" class="pointer-events-none" id="cameraIcon">
                </button>

                <!-- Toggle Mic On/Off button -->
                <button id="micToggle">
                    <img src="{{ Vite::asset('/public/storage/icons/microphone_blue.png') }}" alt="Microphone icon"
                         width="19" height="19" class="pointer-events-none" id="micIcon">
                </button>

                <!-- Trigger/Open The Modal -->
                @auth
                    <button id="controllerButton">
                        <img src="{{ Vite::asset('/public/storage/icons/question_mark_blue.png') }}" alt="Help icon"
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
        </div>    <!--einde landscape-->
        <div id="portrait">
            <div class="welcomeText">
                <h1>Welkom</h1>
                <div class="welcomeInfo">
                    <p>Kantel je smartphone, in landscape mode om de app te gebruiken</p>
                    <p>Het is aan te raden om de website te installeren op het homescherm. Dit kan via de instellingen
                        van de browser</p>
                </div>
            </div>
        </div>
    </div>
@endsection
