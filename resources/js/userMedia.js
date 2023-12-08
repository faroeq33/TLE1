// Define audio and video constraints
const MediaStreamConstraints = {
    audio: true,
    video: {
        facingMode: "user" //prefers front camera if available
        // or facingMode: "environment"  --> prefers rear camera if available
    }
}; // Inherently sets video content to true or "required"

// navigator.mediaDevices.getUserMedia( MediaStreamConstraints )
//     .then( MediaStream => {
//         /*assuming that there is a video tag having
//         an id 'video' in the index.blade.php*/
//         const videoElem = document.getElementById( 'video');
//
//         /*it is important to use the srcObject
//         attribute and not the src attribute
//         because, the src attribute does not
//         support the mediaStream as a value*/
//         videoElem.srcObject = MediaStream;
//
//         //Don't forget to set the autoplay attribute to true
//         videoElem.autoplay = true;
//
//     }).catch( error => {
//     //code to handle the error
// });

//Or using async/await —

async function accessCamera() {
    const videoElem = document.getElementById( 'video');
    let stream = null;

    try {
        stream = await navigator.mediaDevices.getUserMedia( MediaStreamConstraints );

        //adding the received stream to the source of the video element
        videoElem.srcObject = stream;

        videoElem.autoplay = true;
    } catch(err) {
        //code to handle the error
    }
}

