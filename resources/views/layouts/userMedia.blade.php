@extends('layouts.app')

@section('head')
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,
	initial-scale=1.0">
        <title>GetUserMedia demo</title>
    </head>
@endsection

@section('content')
    <body class="text-center flex flex-col justify-center items-center">
    <h1> WebRTC getUserMedia() demo</h1>

{{--    <video--}}
{{--        width="1000"--}}
{{--        height="1000"--}}
{{--        class="border border-black">--}}
{{--    </video>--}}

    <div class="mx-auto w-6 drop-shadow rounded-md absolute bottom-0 right-0">
        <!-- Expandable settings menu -->
        <details class="bg-secondary open:bg-white duration-300">
            <summary class="bg-secondary cursor-pointer"></summary>

            <div id="togglebuttons">
                <!-- Toggle Camera On/Off button -->
                <button id="cameraToggle" onclick="toggleCam()">
                    <img src="{{ Vite::asset('/public/storage/icons/webcam_blue.png') }}" alt="Dropdown menu" width="19" height="19" class="pointer-events-none">
                </button>

                <!-- Toggle Mic On/Off button -->
                <button id="micToggle" onclick="toggleMic()">
                    <img src="{{ Vite::asset('/public/storage/icons/microphone_blue.png') }}" alt="Dropdown menu" width="19" height="19" class="pointer-events-none">
                </button>
            </div>
        </details>
    </div>

    <!-- If you use the playsinline attribute then
    the video is played "inline". If you omit this
    attribute then it works normal in the desktop
    browsers, but for the mobile browsers, the video
    takes the fullscreen by default. And don't forget
    to use the autoplay attribute-->
    <video class="bg-black absolute"
           id='video'
           width="500"
           height="500"
           autoplay playsinline>
        Sorry, video element not supported in your browser
    </video>

    <div
        id="error"
        class="text-red-600 p-2.5 bg-pink-300 mb-2.5 hidden">
    </div>

    <script>
        const videoElem = document.getElementById('video');
        const errorElem = document.getElementById('error');
        let receivedMediaStream = null;
        let isPlaying = !!videoElem.srcObject;

        window.onload = function() {
            accessUserMedia();
        };

        // function cameraOnOff() {
        //     if (!isPlaying) {
        //         accessUserMedia();
        //     } else {
        //         toggleCam();
        //     }
        // }

        //Declare the MediaStreamConstraints object
        const constraints = {
            audio: {
                noiseSuppression: false,
                echoCancellation: false,
            },
            video: {
                facingMode: "user" //prefers front camera if available
                // or facingMode: "environment"  --> prefers rear camera if available
            }
        }

        // when the page first loads, ask user for mic permission and get stream if allowed
        // should also add any error handling here for all the failure cases like user denies permission, no devices available, etc.
        async function accessUserMedia() {
            // const videoElem = document.getElementById( 'video');
            let stream = null;

            try {
                stream = await navigator.mediaDevices.getUserMedia( constraints );

                //adding the received stream to the source of the video element
                videoElem.srcObject = stream;

                // make the received mediaStream available globally
                receivedMediaStream = stream;
                // console.log(receivedMediaStream);

                isPlaying = true;

                videoElem.autoplay = true;
            } catch(err) {
                // handling the error if any
                // errorElem.innerHTML = err;
                // errorElem.style.display = "block";
                window.alert(err);
            }
        }

        // const closeCamera = () => {
        //     if (!receivedMediaStream) {
        //         errorElem.innerHTML = "Camera is already closed!";
        //         errorElem.style.display = "block";
        //     } else {
        //         /* MediaStream.getTracks() returns an array of all the
        //         MediaStreamTracks being used in the received mediaStream
        //         we can iterate through all the mediaTracks and
        //         stop all the mediaTracks by calling its stop() method*/
        //         receivedMediaStream.getTracks().forEach(mediaTrack => {
        //             mediaTrack.stop();
        //             isPlaying = false;
        //         });
        //     }
        // }

        // use the global mediaStream variable to act on the same stream you first instantiated
        const toggleCam = () => {
            receivedMediaStream.getVideoTracks().forEach(track => {
                track.enabled = !track.enabled
            });
        };

        // use the global mediaStream variable to act on the same stream you first instantiated
        const toggleMic = () => {
            receivedMediaStream.getAudioTracks().forEach(track => {
                track.enabled = !track.enabled
            });
        };
    </script>
    </body>
@endsection


