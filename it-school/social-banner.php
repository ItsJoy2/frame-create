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
            height: 560px;
            max-width: 100%;
            background: #1a1a1a;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
        
        .user-photo-layer {
            position: absolute;
            width: 100%;
            height: 90%;
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
                <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center shadow-lg">
                    <img src="/favicon.png" alt="Logo" class="w-8 h-8 transition-transform hover:scale-110">
                </div>
                <div>
                    <h1 class="text-xl md:text-2xl font-bold text-white leading-tight">
                        Edulife Frame Creator
                    </h1>
                    <p class="text-purple-200 text-xs md:text-sm">
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
                        <img id="userPhoto" class="user-photo-layer" style="display: none;">
                        
                        <img id="frameOverlay" class="frame-overlay" src="/it-school/social-banner.png" alt="Frame" crossorigin="anonymous">
                        
                        <div id="placeholder" class="absolute inset-0 flex flex-col items-center justify-center text-white z-10">
                            <img src="https://i.ibb.co.com/R4b2kHxh/istockphoto-2014684899-612x612.jpg" alt="Upload Photo" class="w-24 h-24 mb-4 opacity-50 rounded-lg object-cover" style="margin-top: 150px;">
                            <p class="text-md opacity-75">Your photo will appear here</p>
                            <p class="text-sm opacity-50 mt-2">Behind the frame</p>
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

<script>
/* ================= CONFIG ================= */
const FRAME_URL = '/it-school/social-banner.png';
const CANVAS_WIDTH = 1600;
const CANVAS_HEIGHT = 1600;

const MAX_NAME_LENGTH = 19;
// বাংলা / emoji / English correct character count
const segmenter = new Intl.Segmenter('bn', { granularity: 'grapheme' });

const PHOTO_AREA = {
    x: 0,
    y: 400,
    width: 1600,
    height: 1200
};

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

/* ================= STATE ================= */
let uploadedImage = null;
let frameImage = null;
let frameLoaded = false;


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

/* ================= BUTTON STATE ================= */
function updateButtonState() {
    const hasPhoto = !!uploadedImage;
    const enable = hasPhoto;

    downloadBtn.disabled = !enable;
    resetBtn.disabled = !enable;
    shareBtn.disabled = !enable;
}

/* ================= IMAGE UPLOAD ================= */
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
        uploadedImage = new Image();
        uploadedImage.onload = ()=>{
            userPhoto.src = uploadedImage.src;
            userPhoto.style.display='block';
            placeholder.style.display='none';
            showNotification('Photo loaded');
            updateButtonState();
        };
        uploadedImage.src = e.target.result;
    };
    reader.readAsDataURL(file);
}


/* ================= RESET ================= */
function resetApplication(){
    uploadedImage=null;
    userPhoto.src='';
    userPhoto.style.display='none';
    placeholder.style.display='flex';
    fileInput.value='';
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