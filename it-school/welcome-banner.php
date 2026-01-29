<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edulife Photo Frame Creator</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="https://i.ibb.co.com/ymPMtgBw/edulife-agency.png">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        
        .frame-container {
            position: relative;
            width: 600px;
            height: 600px;
            max-width: 100%;
            background: #1a1a1a;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
        
        .user-photo-layer {
            position: absolute;
            top: 44%;
            left: 35%;
            width: 31%;
            height: 31%;
            /* object-fit: cover ensures the image covers the container */
            object-fit: cover; 
            object-position: center;
            z-index: 1;
        }
        
        .frame-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 2;
            pointer-events: none;
        }
        
        .upload-zone {
            border: 3px dashed rgba(255, 255, 255, 0.3);
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }
        
        .upload-zone:hover {
            border-color: rgba(255, 255, 255, 0.6);
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-2px);
        }
        
        .upload-zone.dragover {
            border-color: #fbbf24;
            background: rgba(251, 191, 36, 0.1);
        }
        .name-overlay {
            position: absolute;
            bottom: 75px;
            width: 100%;
            text-align: center;
            font-size: 30px;
            font-weight: 700;
            color: #21256f;
            text-shadow: 0 3px 8px rgba(0,0,0,0.6);
            z-index: 3;
            pointer-events: none;
        }
        .branchOverlay{
            position: absolute;
            bottom: 50px; 
            font-size: 17px; 
            display:none; 
            color: #21256f;

        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }
        
        .btn-secondary {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }
        
        .btn-secondary:hover:not(:disabled) {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 16px 24px;
            background: rgba(16, 185, 129, 0.95);
            color: white;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            transform: translateX(400px);
            transition: transform 0.3s ease;
            z-index: 1000;
            backdrop-filter: blur(10px);
        }
        
        .notification.show {
            transform: translateX(0);
        }
        
        .notification.error {
            background: rgba(239, 68, 68, 0.95);
        }
        
        .notification.info {
            background: rgba(59, 130, 246, 0.95);
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }
        
        .fade-in {
            animation: fadeIn 0.5s ease-out;
        }
        
        @media (max-width: 768px) {
            .frame-container {
                width: 100%;
                height: auto;
                aspect-ratio: 1/1;
            }
        }
    </style>
</head>
<body class="min-h-screen">
    <header class="py-5 px-4 bg-transparent">
        <div class="max-w-7xl mx-auto flex items-center justify-between">

            <!-- Left: Logo & Title -->
            <div class="flex items-center space-x-3">
                <div class="w-7 h-7 bg-white rounded-xl flex items-center justify-center shadow-lg">
                    <img src="/favicon.png" alt="Logo" class="w-4 h-4 transition-transform hover:scale-110">
                </div>
                <div>
                    <h1 class="text-xl md:text-xl font-bold text-white leading-tight">
                        Edulife Frame Creator
                    </h1>
                    <p class="text-purple-200 text-sm md:text-sm">
                        Your photo behind our frame
                    </p>
                </div>
            </div>

            <!-- Center: Navigation -->
            <nav class="hidden md:flex space-x-8 font-medium">
                <!-- Anniversary (normal link) -->
                <a href="/index.php" class="relative text-white px-1 py-1 group">
                    Anniversary
                    <span class="absolute left-0 bottom-0 w-0 h-0.5 bg-purple-400 transition-all group-hover:w-full"></span>
                </a>

                <!-- IT School Dropdown -->
                <div class="relative group">
                    <button class="text-white px-1 py-1 flex items-center space-x-1 focus:outline-none">
                        <span>IT School</span>
                        <i class="fas fa-chevron-down text-xs"></i>
                    </button>
                    <div class="absolute left-0 mt-2 w-44 bg-white rounded-lg shadow-lg opacity-0 group-hover:opacity-100 invisible group-hover:visible transition-all duration-300 z-50">
                        <a href="/it-school/welcome-banner.php" class="block px-4 py-2 text-gray-800 hover:bg-purple-100">Welcome Banner</a>
                        <a href="/it-school/social-banner.php" class="block px-4 py-2 text-gray-800 hover:bg-purple-100">Social Banner</a>
                    </div>
                </div>

                <!-- After School Dropdown -->
                <div class="relative group">
                    <button class="text-white px-1 py-1 flex items-center space-x-1 focus:outline-none">
                        <span>After School</span>
                        <i class="fas fa-chevron-down text-xs"></i>
                    </button>
                    <div class="absolute left-0 mt-2 w-44 bg-white rounded-lg shadow-lg opacity-0 group-hover:opacity-100 invisible group-hover:visible transition-all duration-300 z-50">
                        <a href="/after-school/welcome-banner.php" class="block px-4 py-2 text-gray-800 hover:bg-purple-100">Welcome Banner</a>
                        <!-- <a href="/after-school/social-banner.php" class="block px-4 py-2 text-gray-800 hover:bg-purple-100">Social Banner</a> -->
                    </div>
                </div>
            </nav>

            <!-- Right: Social -->
            <div class="flex items-center space-x-3">
                <a href="https://www.facebook.com/edulife.agency/" 
                target="_blank"
                class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center 
                        hover:bg-white/20 transition duration-300">
                    <i class="fab fa-facebook-f text-white text-lg"></i>
                </a>
            </div>

        </div>
    </header>

    <main class="container mx-auto px-4 py-8 pb-20">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-10">
                <h2 class="text-4xl font-bold text-white mb-4">Frame Your Perfect Moment</h2>
                <p class="text-purple-100 text-lg">Upload your photo and see it behind our exclusive frame design</p>
            </div>

            <div class="grid lg:grid-cols-2 gap-8 items-start">
                <div class="flex flex-col items-center">

                    <div class="frame-container mb-6" id="frameContainer">
                        <div id="branchOverlay" class="name-overlay branchOverlay"></div>

                        <img id="userPhoto" class="user-photo-layer" style="display: none;">
                        
                        <img id="frameOverlay" class="frame-overlay" src="/it-school/welcome-banner.png" alt="Frame" crossorigin="anonymous">
                        
                        <div id="placeholder" class="absolute inset-0 flex flex-col items-center justify-center text-white z-10">
                            <img src="https://i.ibb.co.com/R4b2kHxh/istockphoto-2014684899-612x612.jpg" alt="Upload Photo" class="w-20 h-20 mb-4 opacity-50 rounded-lg object-cover" style="margin-top: 110px;">
                            <p class="text-md opacity-75" style="font-size: 12px;">Your photo will appear here</p>
                            <p class="text-sm opacity-50" style="font-size: 10px;">Behind the frame</p>
                        </div>
                        <div id="nameOverlay" class="name-overlay" style="display:none;">
                            Kids Name
                        </div>
                    </div>
                    
                    <div class="flex space-x-4 w-full max-w-md">
                        <button id="downloadBtn" class="btn-primary text-white font-semibold py-3 px-6 rounded-xl flex items-center justify-center flex-1 disabled:opacity-50 disabled:cursor-not-allowed transition" disabled>
                            <i class="fas fa-download mr-2"></i>
                            Download
                        </button>
                        <button id="resetBtn" class="btn-secondary text-white font-semibold py-3 px-6 rounded-xl flex items-center justify-center flex-1 disabled:opacity-50 disabled:cursor-not-allowed transition" disabled>
                            <i class="fas fa-redo mr-2"></i>
                            Reset
                        </button>
                        <button id="shareBtn" class="btn-secondary text-white font-semibold py-3 px-6 rounded-xl flex items-center justify-center flex-1 disabled:opacity-50 disabled:cursor-not-allowed transition" disabled>
                            <i class="fas fa-share-alt mr-2"></i>
                            Share
                        </button>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="glass-card rounded-2xl p-6">
                        <h3 class="text-xl font-bold text-white mb-4">
                            <i class="fas fa-building text-blue-400 mr-2"></i>
                            Select Campus
                        </h3>
                        <select id="branchSelect" class="w-full px-4 py-3 rounded-xl bg-white/20 text-white placeholder-purple-200 focus:outline-none focus:ring-2 focus:ring-purple-400" required>
                            <option class="text-black" value="" disabled selected>Select a Campus</option>
                            <option class="text-black" value="Khagrachari Campus">Khagrachari Campus</option>
                            <option class="text-black" value="Matiranga Campus">Matiranga Campus</option>
                            <option class="text-black" value="Guimara Campus">Guimara Campus</option>
                            <option class="text-black" value="Laxmichari Campus">Laxmichari Campus</option>
                        </select>
                    </div>

                    <div class="glass-card rounded-2xl p-6">
                        <h3 class="text-xl font-bold text-white mb-4">
                            <i class="fas fa-user text-blue-400 mr-2"></i>
                            Kids Name
                        </h3>
                        <input type="text" id="nameInput" maxlength="18" placeholder="Write Your Name" class="w-full px-4 py-3 rounded-xl bg-white/20 text-white placeholder-purple-200 focus:outline-none focus:ring-2 focus:ring-purple-400" required>
                    </div>

                    <div class="upload-zone rounded-2xl p-8 text-center cursor-pointer" id="uploadZone">
                        <input type="file" id="fileInput" accept="image/*" class="hidden">
                        <div class="mb-4">
                            <i class="fas fa-camera text-6xl text-white mb-4"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-2">Upload Your Photo</h3>
                        <p class="text-purple-100 mb-6">Your photo will appear behind the frame</p>
                        <button id="uploadBtn" class="btn-primary text-white font-semibold py-3 px-8 rounded-xl" type="button">
                            <i class="fas fa-upload mr-2"></i>
                            Choose Photo
                        </button>
                        <p class="text-purple-200 text-sm mt-4 opacity-75">
                            Supports: JPG, PNG, GIF, WebP (Max 10MB)
                        </p>
                    </div>

                    <!-- <div class="glass-card rounded-2xl p-6">
                        <h3 class="text-xl font-bold text-white mb-4">
                            <i class="fas fa-info-circle text-blue-400 mr-2"></i>
                            How It Works
                        </h3>
                        <div class="space-y-3 text-purple-100">
                            <div class="flex items-start">
                                <span class="bg-purple-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs mr-3 mt-0.5">1</span>
                                <span>Upload your photo (any size)</span>
                            </div>
                            <div class="flex items-start">
                                <span class="bg-purple-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs mr-3 mt-0.5">2</span>
                                <span>Your photo appears as background</span>
                            </div>
                            <div class="flex items-start">
                                <span class="bg-purple-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs mr-3 mt-0.5">3</span>
                                <span>Frame overlay shows on top</span>
                            </div>
                            <div class="flex items-start">
                                <span class="bg-purple-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs mr-3 mt-0.5">4</span>
                                <span>Download or share your creation</span>
                            </div>
                        </div>
                    </div>

                    <div class="glass-card rounded-2xl p-6">
                        <h3 class="text-xl font-bold text-white mb-4">
                            <i class="fas fa-star text-yellow-400 mr-2"></i>
                            Features
                        </h3>
                        <ul class="space-y-3 text-purple-100">
                            <li class="flex items-start">
                                <i class="fas fa-layer-group text-green-400 mr-3 mt-1"></i>
                                <span><strong>Layered Design:</strong> Photo behind frame overlay</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-expand text-green-400 mr-3 mt-1"></i>
                                <span><strong>Auto-fit:</strong> Adjusts any photo size</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-magic text-green-400 mr-3 mt-1"></i>
                                <span><strong>Instant Preview:</strong> See results immediately</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-download text-green-400 mr-3 mt-1"></i>
                                <span><strong>High Quality:</strong> Download in full resolution</span>
                            </li>
                        </ul>
                    </div> -->
                </div>
            </div>
        </div>
    </main>

    <div class="notification" id="notification">
        <div class="flex items-center">
            <i id="notificationIcon" class="fas fa-check-circle mr-3 text-xl"></i>
            <span id="notificationText">Success!</span>
        </div>
    </div>



<!-- CROP MODAL -->
<div id="cropModal" class="fixed inset-0 bg-black/70 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl p-4 w-[420px]">
        <h3 class="text-lg font-semibold mb-2 text-center">Crop Photo</h3>

        <canvas id="cropCanvas" width="400" height="400"
                class="border rounded mb-3 cursor-move"></canvas>

        <input type="range" id="cropZoom" min="1" max="3" step="0.01" value="1"
               class="w-full mb-3">

        <div class="flex gap-2">
            <button id="cropConfirm"
                    class="flex-1 bg-purple-600 text-white py-2 rounded">
                Confirm
            </button>
            <button id="cropCancel"
                    class="flex-1 bg-gray-300 py-2 rounded">
                Cancel
            </button>
        </div>
    </div>
</div>



    
<script>
/* ================= CONFIG ================= */
const FRAME_URL = '/it-school/welcome-banner.png';
const CANVAS_WIDTH = 1600;
const CANVAS_HEIGHT = 1600;

const MAX_NAME_LENGTH = 20;
// বাংলা / emoji / English correct character count
const segmenter = new Intl.Segmenter('bn', { granularity: 'grapheme' });

/* ================= CROP STATE ================= */
let cropImg = null;
let cropScale = 1;
let cropX = 0;
let cropY = 0;
let cropDragging = false;
let cropStartX = 0;
let cropStartY = 0;


/* ================= DOM ================= */
const fileInput = document.getElementById('fileInput');
const uploadBtn = document.getElementById('uploadBtn');
const uploadZone = document.getElementById('uploadZone');
const userPhoto = document.getElementById('userPhoto');
const frameOverlay = document.getElementById('frameOverlay');
const placeholder = document.getElementById('placeholder');
const downloadBtn = document.getElementById('downloadBtn');
const resetBtn = document.getElementById('resetBtn');
const shareBtn = document.getElementById('shareBtn');
const notification = document.getElementById('notification');
const notificationText = document.getElementById('notificationText');
const notificationIcon = document.getElementById('notificationIcon');
const nameInput = document.getElementById('nameInput');
const nameOverlay = document.getElementById('nameOverlay');
const branchSelect = document.getElementById('branchSelect');
const branchOverlay = document.getElementById('branchOverlay');

const cropModal = document.getElementById('cropModal');
const cropCanvas = document.getElementById('cropCanvas');
const cropCtx = cropCanvas.getContext('2d');
const cropZoom = document.getElementById('cropZoom');
const cropConfirm = document.getElementById('cropConfirm');
const cropCancel = document.getElementById('cropCancel');



/* ================= STATE ================= */
let uploadedImage = null;
let frameImage = null;
let frameLoaded = false;

/* ================= PHOTO AREA (CSS EXACT MATCH) ================= */
const PHOTO_AREA = {
    x: CANVAS_WIDTH * 0.34,      // left: 44%
    y: CANVAS_HEIGHT * 0.44,     // top: 25%
    width: CANVAS_WIDTH * 0.32,  // width: 31%
    height: CANVAS_HEIGHT * 0.32 // height: 31%
};

/* ================= INIT ================= */
document.addEventListener('DOMContentLoaded', () => {
    frameImage = new Image();
    frameImage.crossOrigin = 'anonymous';
    frameImage.onload = () => { 
        frameLoaded = true; 
        frameOverlay.style.display = 'block'; 
    };
    frameImage.onerror = () => { showNotification('Frame load failed','error'); };
    frameImage.src = FRAME_URL;
});

/* ================= NOTIFICATIONS ================= */
function showNotification(message, type='success', duration=3000){
    notification.className='notification';
    notificationText.textContent = message;
    notification.classList.add('show');
    if(type==='error'){
        notification.classList.add('error');
        notificationIcon.className='fas fa-exclamation-circle mr-3 text-xl';
    }else if(type==='info'){
        notification.classList.add('info');
        notificationIcon.className='fas fa-info-circle mr-3 text-xl';
    }else{
        notificationIcon.className='fas fa-check-circle mr-3 text-xl';
    }
    setTimeout(()=>notification.classList.remove('show'), duration);
}

/* ================= NAME LIVE PREVIEW ================= */
nameInput.addEventListener('input', ()=>{
    const value = nameInput.value.trim();
    if(value){
        nameOverlay.textContent = value;
        nameOverlay.style.display = 'block';
    }else{
        nameOverlay.style.display = 'none';
    }
});



/* ================= BUTTON STATE ================= */
function updateButtonState() {
    const hasPhoto = uploadedImage && uploadedImage.src && uploadedImage.src.startsWith('data:image');
    const hasName = nameInput.value.trim().length > 0;
    const hasBranch = branchSelect.value && branchSelect.value.trim().length > 0;
    const enable = hasPhoto && hasName && hasBranch;

    downloadBtn.disabled = !enable;
    resetBtn.disabled = !enable;
    shareBtn.disabled = !enable;
}

/* ================= Branch LIVE PREVIEW ================= */
branchSelect.addEventListener('change', () => {
    const branchName = branchSelect.value.trim();
    if (branchName) {
        branchOverlay.textContent = branchName;
        branchOverlay.style.display = 'block';
    } else {
        branchOverlay.style.display = 'none';
    }
        updateButtonState();
});

/* ================= NAME LIVE PREVIEW ================= */
nameInput.addEventListener('input', () => {
    let value = nameInput.value;

    // correct character count (বাংলা সহ)
    if (getCharCount(value) > MAX_NAME_LENGTH) {
        value = trimToMaxChars(value, MAX_NAME_LENGTH);
        nameInput.value = value;
        showNotification('নাম সর্বোচ্চ 18 অক্ষরের হতে পারবে', 'info');
    }

    value = value.trim();

    if (value) {
        nameOverlay.textContent = value;
        nameOverlay.style.display = 'block';
    } else {
        nameOverlay.style.display = 'none';
    }
    updateButtonState();
});

/* ================= IMAGE UPLOAD ================= */
// function handleFileUpload(file){
//     if(!file || !file.type.startsWith('image/')){
//         showNotification('Invalid image file','error');
//         return;
//     }
//     if(file.size > 10*1024*1024){
//         showNotification('Max 10MB allowed','error');
//         return;
//     }

//     const reader = new FileReader();
//     reader.onload = e=>{
//         uploadedImage = new Image();
//         uploadedImage.onload = ()=>{
//             userPhoto.src = uploadedImage.src;
//             userPhoto.style.display='block';
//             placeholder.style.display='none';
//             showNotification('Photo loaded');
//             updateButtonState();
//         };
//         uploadedImage.src = e.target.result;
//     };
//     reader.readAsDataURL(file);
// }

function handleFileUpload(file){
    if(!file || !file.type.startsWith('image/')){
        showNotification('Invalid image file','error');
        return;
    }
    if(file.size > 10*1024*1024){
        showNotification('Max 10MB allowed','error');
        return;
    }

    const reader = new FileReader();
    reader.onload = e=>{
        cropImg = new Image();
        cropImg.onload = openCropModal;
        cropImg.src = e.target.result;
    };
    reader.readAsDataURL(file);
}



function openCropModal(){
    cropModal.classList.remove('hidden');

    cropCanvas.width = 400;
    cropCanvas.height = 400;

    cropScale = 1;
    cropX = 0;
    cropY = 0;
    cropZoom.value = 1;

    drawCrop();
}

function drawCrop(){
    cropCtx.clearRect(0,0,400,400);

    const iw = cropImg.width * cropScale;
    const ih = cropImg.height * cropScale;

    cropCtx.drawImage(cropImg, cropX, cropY, iw, ih);
}

cropCanvas.addEventListener('mousedown', e=>{
    cropDragging = true;
    cropStartX = e.offsetX - cropX;
    cropStartY = e.offsetY - cropY;
});

cropCanvas.addEventListener('mousemove', e=>{
    if(!cropDragging) return;
    cropX = e.offsetX - cropStartX;
    cropY = e.offsetY - cropStartY;
    drawCrop();
});

document.addEventListener('mouseup', ()=>{
    cropDragging = false;
});

cropZoom.addEventListener('input', ()=>{
    cropScale = parseFloat(cropZoom.value);
    drawCrop();
});

cropConfirm.onclick = () => {
    const out = document.createElement('canvas');
    out.width = 1200;
    out.height = 1200;

    out.getContext('2d').drawImage(
        cropCanvas,
        0, 0, 400, 400,
        0, 0, 1200, 1200
    );

    uploadedImage = new Image();
    uploadedImage.onload = () => {
        // Preview update
        userPhoto.src = uploadedImage.src;
        userPhoto.style.display = 'block';
        placeholder.style.display = 'none';

        // ✅ crop confirm দেওয়ার সাথে সাথে button update
        updateButtonState();

        showNotification('Photo cropped');
    };

    uploadedImage.src = out.toDataURL();
    cropModal.classList.add('hidden');
};
    cropCancel.onclick = ()=>{
        cropModal.classList.add('hidden');
    };

/* ================= RESET ================= */
function resetApplication(){
    uploadedImage=null;
    userPhoto.src='';
    userPhoto.style.display='none';
    placeholder.style.display='flex';
    nameInput.value='';
    nameOverlay.style.display='none';
    fileInput.value='';
    branchSelect.value = '';
    branchOverlay.style.display = 'none'; 
    updateButtonState();
    showNotification('Reset done','info');
}

/* ================= DRAW IMAGE (OBJECT-FIT: COVER) ================= */
function drawImageCover(ctx,img,x,y,w,h){
    const ir = img.width / img.height;
    const cr = w / h;
    let dw, dh, dx, dy;

    if(ir > cr){
        dh = h;
        dw = h * ir;
        dx = x - (dw - w) / 2;
        dy = y;
    }else{
        dw = w;
        dh = w / ir;
        dx = x;
        dy = y - (dh - h) / 2;
    }
    ctx.drawImage(img, dx, dy, dw, dh);
}

/* ================= CREATE FINAL IMAGE ================= */
async function createFramedImage(){
    if(!uploadedImage || !frameLoaded) throw new Error('Images not ready');

    await document.fonts.ready;

    const canvas = document.createElement('canvas');
    canvas.width = CANVAS_WIDTH;
    canvas.height = CANVAS_HEIGHT;
    const ctx = canvas.getContext('2d');

    // background
    ctx.fillStyle = '#1a1a1a';
    ctx.fillRect(0,0,canvas.width,canvas.height);

    // photo
    drawImageCover(
        ctx,
        uploadedImage,
        PHOTO_AREA.x,
        PHOTO_AREA.y,
        PHOTO_AREA.width,
        PHOTO_AREA.height
    );

    // frame FIRST
    ctx.drawImage(frameImage, 0, 0, canvas.width, canvas.height);

    // Branch
    const branchName =
    branchOverlay.style.display !== 'none'
        ? branchOverlay.textContent.trim()
        : '';

    //  NAME
    const name =
        nameOverlay.style.display !== 'none'
            ? nameOverlay.textContent.trim()
            : '';

    if(name){
        ctx.font = '700 92px Inter';
        ctx.fillStyle = '#21256f';
        ctx.textAlign = 'center';
        ctx.textBaseline = 'bottom';
        ctx.shadowColor = 'rgba(0,0,0,0.6)';
        ctx.shadowBlur = 8;
        ctx.fillText(name, canvas.width / 2, canvas.height * 0.86);
        ctx.shadowBlur = 0;
    }
    if(branchName){
        ctx.font = '600 40px Inter';
        ctx.fillStyle = '#21256f';
        ctx.textAlign = 'center';
        ctx.textBaseline = 'bottom';
        ctx.shadowColor = 'rgba(0, 0, 0, 0.6)';
        ctx.shadowBlur = 8;
        ctx.fillText(branchName, canvas.width / 2, canvas.height - 155);
        ctx.shadowBlur = 0;
    }
    return canvas;
}

/* ================= DOWNLOAD ================= */
async function downloadFramedImage(){
    try{
        const canvas = await createFramedImage();
        const link = document.createElement('a');
        link.download = `edulife-frame-${Date.now()}.png`;
        link.href = canvas.toDataURL('image/png');
        link.click();
        showNotification('Downloaded successfully');
    }catch{
        showNotification('Download failed','error');
    }
}

/* ================= SHARE ================= */
async function shareOnFacebook(){
    await downloadFramedImage();
    window.open(
        'https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(location.href),
        '_blank',
        'width=600,height=400'
    );
}

/* ================= EVENTS ================= */
uploadBtn.onclick = ()=>fileInput.click();
fileInput.onchange = e=>handleFileUpload(e.target.files[0]);
uploadZone.ondragover = e=>e.preventDefault();
uploadZone.ondrop = e=>{
    e.preventDefault();
    handleFileUpload(e.dataTransfer.files[0]);
};
downloadBtn.onclick = downloadFramedImage;
resetBtn.onclick = resetApplication;
shareBtn.onclick = shareOnFacebook;



function getCharCount(str) {
    return [...segmenter.segment(str)].length;
}

function trimToMaxChars(str, max) {
    return [...segmenter.segment(str)]
        .slice(0, max)
        .map(seg => seg.segment)
        .join('');
}

</script>



<script defer src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015" integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ==" data-cf-beacon='{"version":"2024.11.0","token":"1b1a37ba40004d049be93c64f1df4389","r":1,"server_timing":{"name":{"cfCacheStatus":true,"cfEdge":true,"cfExtPri":true,"cfL4":true,"cfOrigin":true,"cfSpeedBrain":true},"location_startswith":null}}' crossorigin="anonymous"></script>
</body>
</html>