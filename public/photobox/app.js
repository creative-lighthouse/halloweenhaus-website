const video = document.getElementById('video');
const canvas = document.getElementById('canvas');
const captureBtn = document.getElementById('captureBtn');
const saveBtn = document.getElementById('saveBtn');
const dismissBtn = document.getElementById('dismissBtn');
const toggleCameraBtn = document.getElementById('toggleCameraBtn');
const overlayPreview = document.getElementById('overlayPreview');
const countdownEl = document.getElementById('countdown');
const loadingEl = document.getElementById('loading');
loadingEl.classList.add("hidden");
const context = canvas.getContext('2d');

const controls = document.getElementById('controls');
const videoContainer = document.getElementById('videoContainer');
const afterCaptureControls = document.getElementById('afterCaptureControls');
const restartButton = document.getElementById('restart_button');
let countdownInterval = null;

const qrcodeHolder = document.getElementById('qrcode_holder');
const qrcodeImage = document.getElementById('qrcode_image');
var qrcodeText = "";

let currentState = 'camera'; // camera, preview, saving
let currentOverlayID = 0;
const nextOverlayBtn = document.getElementById('nextOverlayBtn');
const previousOverlayBtn = document.getElementById('previousOverlayBtn');

let currentStream = null;
let currentDeviceId = null;
let videoDevices = [];

const imagesize = 1000;

const overlays = [
    "filters/overlay1.png",
    "filters/overlay2.png",
    "filters/overlay3.png",
    "filters/overlay4.png",
    "filters/overlay5.png",
];


let currentOverlay = overlays[currentOverlayID];

countdownEl.style.opacity = 0;
afterCaptureControls.classList.add("hidden");
canvas.classList.add("hidden");

//Initialize the first camera to find
initilizeCamera();

changeState('camera');

renderOverlay();

nextOverlayBtn.addEventListener('click', nextOverlay);
previousOverlayBtn.addEventListener('click', previousOverlay);

function initilizeCamera() {
    // Access the available devices
    navigator.mediaDevices.enumerateDevices().then(devices => {
        videoDevices = devices.filter(device => device.kind === 'videoinput');
        if (videoDevices.length > 0) {
            currentDeviceId = videoDevices[0].deviceId;
            startCamera(currentDeviceId);
        }
    }).catch(err => {
        console.error("Error accessing devices: ", err);
    });
}

// Function to start the camera stream
function startCamera(deviceId) {

    if (currentStream) {
        currentStream.getTracks().forEach(track => track.stop());
    }

    navigator.mediaDevices.getUserMedia({
        video: {
        deviceId: { exact: deviceId },
        width: imagesize,
        height: imagesize
        }
    }).then(stream => {
        currentStream = stream;
        video.srcObject = stream;
    }).catch(err => {
        console.error("Error starting camera: ", err);
    });
}

// Capture the image from the video stream after a countdown
captureBtn.addEventListener('click', () => {
    let countdown = 5;
    countdownEl.textContent = countdown;
    countdownEl.style.opacity = 1;

    countdownInterval = setInterval(() => {
        countdown--;
        if (countdown > 0) {
            countdownEl.textContent = countdown;
            countdownEl.style.opacity = 1;
        } else {
            changeState('preview');
            captureImage();
        }
    }, 1000);
});

function captureImage()
{
    // Ensure the canvas is square
    const videoWidth = video.videoWidth;
    const videoHeight = video.videoHeight;
    const squareSize = Math.min(videoWidth, videoHeight);

    // Calculate the top-left corner of the square region
    const cropX = (videoWidth - squareSize) / 2;
    const cropY = (videoHeight - squareSize) / 2;

    // Clear the canvas and set it to square size
    canvas.width = imagesize;
    canvas.height = imagesize;

    // Draw the square region from the video onto the canvas
    context.drawImage(video, cropX, cropY, squareSize, squareSize, 0, 0, imagesize, imagesize);

    // Apply the overlay if available
    if (currentOverlay) {
        applyOverlay(currentOverlay);
    } else {
        applyOverlay(overlays[0]);
    }
}

// Apply the overlay to the final captured image
function applyOverlay(overlaySrc) {
  const overlayImage = new Image();
  overlayImage.src = overlaySrc;
  overlayImage.onload = () => {
    context.drawImage(overlayImage, 0, 0, canvas.width, canvas.height);
  };
}

// Save the image
saveBtn.addEventListener('click', () => {
    const imageDataURL = canvas.toDataURL('image/png');
    loadingEl.classList.remove("hidden");

    const bodyData = JSON.stringify({ image: imageDataURL });
    afterCaptureControls.classList.add("hidden");

    const form = new FormData();
    const now = new Date().toISOString().replace(/[-T:.Z]/g, '');

    form.append("action_submit", "Submit");
    canvas.toBlob((blob) => {
        if (blob) {
            form.append('Image', blob, `${now}.jpg`);
            fetch('../api/BoothImageEntryForm', {
                method: 'POST',
                body: form,
            }).then(response => response.json())
            .then(data => {
                console.log('Image saved:', data);
                qrcodeText = data.qrlink;
                changeState('saving');
                loadingEl.classList.add("hidden");
            })
            .catch(error => console.error('Error saving image:', error));
        }
    }, 'image/jpeg');
});

dismissBtn.addEventListener('click', () => {
    changeState('camera');
});

restartButton.addEventListener('click', () => {
    changeState('camera');
});

function changeState(newstate) {
    console.log('Changing state to', newstate);
    switch (newstate) {
        case 'camera':
            currentState = 'camera';
            controls.classList.remove("hidden");
            afterCaptureControls.classList.add("hidden");
            videoContainer.classList.remove("hidden");
            canvas.classList.add("hidden");
            qrcodeHolder.classList.add("hidden");
            nextOverlayBtn.disabled = false;
            previousOverlayBtn.disabled = false;
            break;
        case 'preview':
            currentState = 'preview';
            controls.classList.add('hidden');
            afterCaptureControls.classList.remove("hidden")
            videoContainer.classList.add("hidden");
            canvas.classList.remove("hidden");
            qrcodeHolder.classList.add("hidden");
            nextOverlayBtn.disabled = true;
            previousOverlayBtn.disabled = true;

            if (countdownInterval) {
                clearInterval(countdownInterval);
            }
            countdownEl.textContent = '';
            countdownEl.style.opacity = 0;
            break;
        case 'saving':
            currentState = 'saving';
            controls.classList.add("hidden");
            afterCaptureControls.classList.add("hidden");
            videoContainer.classList.add("hidden");
            canvas.classList.remove("hidden");
            qrcodeHolder.classList.remove("hidden");
            nextOverlayBtn.disabled = true;
            previousOverlayBtn.disabled = true;

            if(qrcodeText != "") {
                qrcodeImage.src = qrcodeText;
            }
            break;
        default:
            console.error('Invalid state');
    }
}

function renderOverlay() {
    if (currentOverlayID >= overlays.length) {
        currentOverlayID = 0;
    } else if(currentOverlayID < 0) {
        currentOverlayID = overlays.length - 1;
    }

    currentOverlay = overlays[currentOverlayID];
    overlayPreview.src = currentOverlay;
    overlayPreview.classList.remove('hidden');

    const overlayImage = new Image();
    overlayImage.src = currentOverlay;
    overlayImage.onload = () => {
        context.drawImage(overlayImage, 0, 0, canvas.width, canvas.height);
    };
}

function nextOverlay() {
    currentOverlayID++;
    renderOverlay();
}

function previousOverlay() {
    currentOverlayID--;
    renderOverlay();
}
