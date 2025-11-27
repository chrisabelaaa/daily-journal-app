@extends('layouts.app')

@section('title', 'Profile Photo')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">
        <i class="fas fa-camera"></i> Profile Photo
    </h1>
    <p class="page-subtitle">
        Upload or change your profile picture to personalize your account.
    </p>
</div>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; align-items: start;">
    <!-- Current Photo & Upload -->
    <div class="content-card">
        <h2 style="font-size: 1.8rem; font-weight: 600; margin-bottom: 25px; color: #2d3748;">
            <i class="fas fa-image"></i> Current Photo
        </h2>
        
        <!-- Current Photo Display -->
        <div style="text-align: center; margin-bottom: 30px;">
            <div style="position: relative; display: inline-block;">
                @if(auth()->user()->photo)
                    <img id="currentPhoto" src="{{ asset('storage/profile/' . auth()->user()->photo) }}" 
                         alt="Profile Photo" 
                         style="width: 200px; height: 200px; border-radius: 50%; object-fit: cover; 
                                border: 6px solid transparent; 
                                background: linear-gradient(135deg, #ff6b9d, #e91e63) padding-box, 
                                           linear-gradient(135deg, #ff6b9d, #e91e63) border-box;
                                box-shadow: 0 15px 35px rgba(255, 107, 157, 0.3);">
                @else
                    <div id="currentPhoto" 
                         style="width: 200px; height: 200px; border-radius: 50%; 
                                background: linear-gradient(135deg, #ff6b9d, #e91e63);
                                display: flex; align-items: center; justify-content: center; color: white;
                                font-size: 4rem; box-shadow: 0 15px 35px rgba(255, 107, 157, 0.3);">
                        <i class="fas fa-user"></i>
                    </div>
                @endif
                
                <!-- Camera overlay -->
                <div style="position: absolute; bottom: 10px; right: 10px; 
                           width: 50px; height: 50px; border-radius: 50%; 
                           background: linear-gradient(135deg, #e91e63, #c2185b);
                           display: flex; align-items: center; justify-content: center; 
                           color: white; font-size: 1.5rem; cursor: pointer;
                           box-shadow: 0 5px 15px rgba(233, 30, 99, 0.4);
                           transition: all 0.3s ease;"
                     onclick="document.getElementById('photoInput').click()"
                     onmouseover="this.style.transform='scale(1.1)'"
                     onmouseout="this.style.transform='scale(1)'">
                    <i class="fas fa-camera"></i>
                </div>
            </div>
        </div>
        
        <!-- Upload Form -->
        <form method="POST" action="{{ route('profile.photo') }}" enctype="multipart/form-data" id="photoForm">
            @csrf
            <div class="form-group">
                <label class="form-label" style="text-align: center; display: block;">
                    <i class="fas fa-upload"></i> Choose New Photo
                </label>
                <input type="file" id="photoInput" name="photo" accept="image/*" 
                       class="form-input" 
                       style="display: none;"
                       onchange="previewImage(this)">
                
                <div onclick="document.getElementById('photoInput').click()" 
                     id="uploadZone"
                     style="border: 2px dashed #ff6b9d; border-radius: 12px; padding: 30px; 
                            text-align: center; cursor: pointer; transition: all 0.3s ease;
                            background: #f8f9fa;"
                     onmouseover="this.style.backgroundColor='#f1f3f4'; this.style.borderColor='#e91e63'"
                     onmouseout="this.style.backgroundColor='#f8f9fa'; this.style.borderColor='#ff6b9d'">
                    <i class="fas fa-cloud-upload-alt" style="font-size: 3rem; color: #ff6b9d; margin-bottom: 15px;"></i>
                    <p style="color: #6c757d; font-size: 1.1rem; margin: 0;">
                        Click here to select a photo<br>
                        <span style="font-size: 0.9rem; opacity: 0.8;">JPG, PNG, GIF, WebP up to 2MB</span>
                    </p>
                </div>
            </div>
            
            <!-- Preview Area -->
            <div id="previewArea" style="display: none; margin-bottom: 25px;">
                <label class="form-label">
                    <i class="fas fa-eye"></i> Preview
                </label>
                <div style="text-align: center; padding: 20px; background: #f8f9fa; border-radius: 12px;">
                    <img id="previewImage" style="width: 150px; height: 150px; border-radius: 50%; object-fit: cover; 
                                                 border: 4px solid #ff6b9d; box-shadow: 0 10px 25px rgba(255, 107, 157, 0.2);">
                </div>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <button type="button" onclick="cancelUpload()" class="btn btn-secondary" id="cancelBtn" style="display: none;">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <button type="submit" class="btn btn-primary" id="uploadBtn" style="grid-column: 1 / -1;" disabled>
                    <i class="fas fa-upload"></i> Upload Photo
                </button>
            </div>
        </form>
    </div>
    
    <!-- Photo Guidelines & Actions -->
    <div class="content-card">
        <h2 style="font-size: 1.8rem; font-weight: 600; margin-bottom: 25px; color: #2d3748;">
            <i class="fas fa-info-circle"></i> Photo Guidelines
        </h2>
        
        <div style="display: grid; gap: 20px;">
            <div style="padding: 20px; background: #f8f9fa; border-radius: 12px; border-left: 4px solid #ff6b9d;">
                <div style="font-weight: 600; color: #2d3748; margin-bottom: 10px;">
                    <i class="fas fa-check-circle" style="color: #28a745;"></i> Recommended
                </div>
                <ul style="color: #6c757d; margin: 0; padding-left: 20px; line-height: 1.6;">
                    <li>Square aspect ratio (1:1)</li>
                    <li>Minimum 200x200 pixels</li>
                    <li>Clear, well-lit photo</li>
                    <li>Face clearly visible</li>
                </ul>
            </div>
            
            <div style="padding: 20px; background: #f8f9fa; border-radius: 12px; border-left: 4px solid #e91e63;">
                <div style="font-weight: 600; color: #2d3748; margin-bottom: 10px;">
                    <i class="fas fa-file-image" style="color: #6f42c1;"></i> Supported Formats
                </div>
                <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                    <span style="background: #e3f2fd; color: #1976d2; padding: 5px 10px; border-radius: 15px; font-size: 0.9rem;">JPG</span>
                    <span style="background: #e8f5e8; color: #388e3c; padding: 5px 10px; border-radius: 15px; font-size: 0.9rem;">PNG</span>
                    <span style="background: #fff3e0; color: #f57c00; padding: 5px 10px; border-radius: 15px; font-size: 0.9rem;">GIF</span>
                </div>
            </div>
            
            <div style="padding: 20px; background: #f8f9fa; border-radius: 12px; border-left: 4px solid #c2185b;">
                <div style="font-weight: 600; color: #2d3748; margin-bottom: 10px;">
                    <i class="fas fa-exclamation-triangle" style="color: #ffc107;"></i> File Size
                </div>
                <p style="color: #6c757d; margin: 0; line-height: 1.6;">
                    Maximum file size: <strong>2MB</strong><br>
                    Larger files will be automatically resized.
                </p>
            </div>
        </div>
        
        <!-- Action Buttons -->
        <div style="margin-top: 30px; display: grid; gap: 15px;">
            @if(auth()->user()->photo)
            <form method="POST" action="{{ route('profile.photo') }}" style="margin: 0;">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Are you sure you want to remove your profile photo?')" 
                        class="btn btn-danger" style="width: 100%; justify-content: center;">
                    <i class="fas fa-trash"></i> Remove Current Photo
                </button>
            </form>
            @endif
            
            <a href="{{ route('profile') }}" class="btn btn-secondary" style="justify-content: center;">
                <i class="fas fa-arrow-left"></i> Back to Profile
            </a>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            const previewArea = document.getElementById('previewArea');
            const previewImg = document.getElementById('previewImage');
            const cancelBtn = document.getElementById('cancelBtn');
            const uploadBtn = document.getElementById('uploadBtn');
            
            previewImg.src = e.target.result;
            previewArea.style.display = 'block';
            cancelBtn.style.display = 'block';
            uploadBtn.style.gridColumn = 'auto';
            uploadBtn.disabled = false; // Enable upload button
            
            // Add animation
            previewArea.style.opacity = '0';
            previewArea.style.transform = 'translateY(10px)';
            setTimeout(() => {
                previewArea.style.transition = 'all 0.3s ease';
                previewArea.style.opacity = '1';
                previewArea.style.transform = 'translateY(0)';
            }, 10);
        };
        
        reader.readAsDataURL(input.files[0]);
    }
}

function cancelUpload() {
    const photoInput = document.getElementById('photoInput');
    const previewArea = document.getElementById('previewArea');
    const cancelBtn = document.getElementById('cancelBtn');
    const uploadBtn = document.getElementById('uploadBtn');
    
    photoInput.value = '';
    previewArea.style.display = 'none';
    cancelBtn.style.display = 'none';
    uploadBtn.style.gridColumn = '1 / -1';
    uploadBtn.disabled = true; // Disable upload button again
}

// Auto submit form after file selection (optional)
document.getElementById('photoInput').addEventListener('change', function() {
    if (this.files && this.files[0]) {
        // Show loading state
        const uploadBtn = document.getElementById('uploadBtn');
        const originalText = uploadBtn.innerHTML;
        uploadBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
        uploadBtn.disabled = true;
        
        // Auto submit after a short delay to show the preview
        setTimeout(() => {
            uploadBtn.innerHTML = originalText;
            uploadBtn.disabled = false;
        }, 2000);
    }
});

// Drag and drop functionality
const dropZone = document.querySelector('[onclick*="photoInput"]');

dropZone.addEventListener('dragover', function(e) {
    e.preventDefault();
    this.style.backgroundColor = '#e3f2fd';
    this.style.borderColor = '#2196f3';
    this.style.transform = 'scale(1.02)';
});

dropZone.addEventListener('dragleave', function(e) {
    e.preventDefault();
    this.style.backgroundColor = '#f8f9fa';
    this.style.borderColor = '#ff6b9d';
    this.style.transform = 'scale(1)';
});

dropZone.addEventListener('drop', function(e) {
    e.preventDefault();
    this.style.backgroundColor = '#f8f9fa';
    this.style.borderColor = '#ff6b9d';
    this.style.transform = 'scale(1)';
    
    const files = e.dataTransfer.files;
    if (files.length > 0) {
        document.getElementById('photoInput').files = files;
        previewImage(document.getElementById('photoInput'));
    }
});

// Prevent form submission if no file selected
document.getElementById('photoForm').addEventListener('submit', function(e) {
    const photoInput = document.getElementById('photoInput');
    if (!photoInput.files || !photoInput.files[0]) {
        e.preventDefault();
        alert('Please select a photo before uploading!');
        return false;
    }
});
</script>
@endsection
