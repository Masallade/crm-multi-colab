<?php
use App\Models\Employee;
use App\Models\Attendance;
use Illuminate\Support\Facades\DB;

// Handle stream status updates
if (request()->has('employee_id') && request()->has('should_stream')) {
    try {
        $employeeId = request()->input('employee_id');
        $shouldStream = request()->input('should_stream');

        $attendance = Attendance::where('employee_id', $employeeId)
            ->orderByDesc('attendance_date')
            ->orderByDesc('id')
            ->first();

        if ($attendance) {
            $attendance->should_stream = $shouldStream;
            $attendance->save();
            
            // If streaming is stopped, clear the image file
            // Files are in domain root: portal.urtasker.com/streaming/{staffId}.txt
            if (!$shouldStream && request()->has('staff_id')) {
                $staffId = request()->input('staff_id');
                $filePath = base_path("../../streaming/{$staffId}.txt");
                // Alternative absolute path
                if (!file_exists($filePath)) {
                    $filePath = "/home/urtasker/portal.urtasker.com/streaming/{$staffId}.txt";
                }
                if (file_exists($filePath)) {
                    file_put_contents($filePath, '');
                }
            }
            
            if (request()->ajax()) {
                return response()->json(['success' => true]);
            }
        }
    } catch (\Exception $e) {
        \Log::error('Error updating stream status', [
            'error' => $e->getMessage(),
            'employee_id' => $employeeId
        ]);
        
        if (request()->ajax()) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
?>

<div class="row">
    <?php $__empty_1 = true; $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="col-md-4 mb-4">
            <div class="card h-100 border shadow-sm d-flex flex-column justify-content-between">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <h4 class="card-title text-center"><?php echo e($employee['name']); ?></h4>
                    <p class="card-text text-center">Staff ID: <?php echo e($employee['staff_id']); ?></p>
                    <p class="card-text text-center mb-1">Last Clock Up: <?php echo e($employee['clock_up']); ?></p>
                    <?php if($employee['status'] === 'Active' && empty($hide_stream_button)): ?>
                        <button class="btn btn-primary mt-2" onclick="openImageStreamModal('<?php echo e($employee['staff_id']); ?>', <?php echo e($employee['employee_id']); ?>)">View Stream</button>
                    <?php endif; ?>
                </div>
                <div class="card-footer bg-white border-0 text-center">
                    <span class="badge <?php echo e($employee['status'] === 'Active' ? 'badge-success' : 'badge-secondary'); ?>" style="font-size: 1.1em;">
                        <?php echo e($employee['status']); ?>

                    </span>
                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="col-12 text-center text-muted">No employees found.</div>
    <?php endif; ?>
</div>

<!-- Modal for image streaming -->
<div class="modal fade" id="imageStreamModal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Live Snapshot Stream</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeImageStreamModal()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="imageStreamBody">
                <div id="streamingMessage" class="text-center d-none">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <p class="mt-2">Loading snapshot...</p>
                </div>
                <img id="liveImage" src="" width="100%" style="display: none;" />
            </div>
        </div>
    </div>
</div>

<!-- Session Expired Modal -->
<div class="modal fade" id="sessionExpiredModal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-warning text-white">
        <h5 class="modal-title">
          <i class="fas fa-exclamation-triangle"></i> Session Expired
        </h5>
      </div>
      <div class="modal-body text-center">
        <div class="mb-3">
          <i class="fas fa-clock fa-3x text-warning"></i>
        </div>
        <h6 class="mb-3">Your session has expired</h6>
        <p class="text-muted">Please refresh the page to continue using the application.</p>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-primary btn-lg" onclick="refreshPage()">
          <i class="fas fa-sync-alt"></i> Refresh Page
        </button>
      </div>
    </div>
  </div>
</div>

<script>
// Function to get fresh CSRF token from meta tag
function getCsrfToken() {
    return document.querySelector('meta[name="csrf-token"]').content;
}

let imageInterval = null;
let currentStaffId = null;
let currentEmployeeId = null;
let displayCheckInterval = null;
let isModalVisible = false;
let lastImageData = null;

function refreshPage() {
    window.location.reload();
}

function showSessionExpiredModal() {
    if (isModalVisible) {
        $('#imageStreamModal').modal('hide');
        closeImageStreamModal();
    }
    $('#sessionExpiredModal').modal('show');
}

function handleImageError() {
    document.getElementById('streamingMessage').classList.remove('d-none');
    document.getElementById('liveImage').style.display = 'none';
}

function handleImageLoad() {
    document.getElementById('streamingMessage').classList.add('d-none');
    document.getElementById('liveImage').style.display = 'block';
}

async function updateStreamStatus(employeeId, shouldStream) {
    try {
        const url = new URL(window.location.href);
        url.searchParams.set('employee_id', employeeId);
        url.searchParams.set('should_stream', shouldStream ? 1 : 0);
        
        // Add staff_id when stopping the stream
        if (!shouldStream && currentStaffId) {
            url.searchParams.set('staff_id', currentStaffId);
        }
        
        const response = await fetch(url.toString());
        if (!response.ok) {
            throw new Error('Failed to update stream status');
        }
        
        const data = await response.json();
        if (!data.success) {
            throw new Error(data.error || 'Failed to update stream status');
        }
    } catch (error) {
        console.error('Error updating stream status:', error);
    }
}

async function fetchAndUpdateImage() {
    if (!isModalVisible || !currentStaffId) return;
    
    try {
        // Files are in domain root: portal.urtasker.com/streaming/{staffId}.txt
        // Use absolute path to ensure we get domain root, not relative to current path
        const baseUrl = window.location.origin; // Gets https://portal.urtasker.com
        const streamingUrl = `${baseUrl}/streaming/${currentStaffId}.txt`;
        const response = await fetch(streamingUrl, {
            cache: 'no-store',
            headers: {
                'Cache-Control': 'no-cache',
                'Pragma': 'no-cache'
            }
        });
        
        if (!response.ok) throw new Error('Failed to fetch image data');
        
        const base64Data = await response.text();
        if (!base64Data.trim()) throw new Error('No image data available');

        // Only update if the image data has changed
        if (base64Data.trim() !== lastImageData) {
            const img = document.getElementById('liveImage');
            // Create a new temporary image to preload
            const tempImg = new Image();
            tempImg.onload = function() {
                // Once new image is loaded, update the visible image
                img.src = this.src;
                lastImageData = base64Data.trim();
                handleImageLoad();
            };
            tempImg.src = `data:image/jpeg;base64,${base64Data.trim()}`;
        }
    } catch (error) {
        console.error('Error fetching image:', error);
        handleImageError();
    }
}

function startImageStream() {
    // Initial fetch
    fetchAndUpdateImage();
    
    // Set up continuous fetching every 200ms (5 times per second)
    imageInterval = setInterval(fetchAndUpdateImage, 100);
}

function stopImageStream() {
    if (imageInterval) {
        clearInterval(imageInterval);
        imageInterval = null;
    }
    lastImageData = null;
}

function openImageStreamModal(staffId, employeeId) {
    currentStaffId = staffId;
    currentEmployeeId = employeeId;
    isModalVisible = true;

    // Update stream status immediately
    updateStreamStatus(employeeId, true);

    $('#imageStreamModal').modal({
        backdrop: 'static',
        keyboard: false
    });
    
    // Start continuous image streaming
    startImageStream();
    
    if (!displayCheckInterval) {
        displayCheckInterval = setInterval(checkModalVisibility, 1000);
    }
}

function closeImageStreamModal() {
    if (currentEmployeeId) {
        updateStreamStatus(currentEmployeeId, false);
    }
    
    // Stop image streaming
    stopImageStream();
    
    $('#imageStreamModal').modal('hide');
    clearInterval(displayCheckInterval);
    displayCheckInterval = null;
    document.getElementById('liveImage').src = '';
    document.getElementById('streamingMessage').classList.add('d-none');
    document.getElementById('liveImage').style.display = 'none';
    currentStaffId = null;
    currentEmployeeId = null;
    isModalVisible = false;
}

function checkModalVisibility() {
    const modalElement = document.getElementById('imageStreamModal');
    const isCurrentlyVisible = $(modalElement).is(':visible');
    
    if (isModalVisible && !isCurrentlyVisible) {
        isModalVisible = false;
        closeImageStreamModal();
    }
    isModalVisible = isCurrentlyVisible;
}

// Add event listeners for modal events
$(document).ready(function() {
    $('#imageStreamModal').modal({
        backdrop: 'static',
        keyboard: false
    });

    $('#imageStreamModal').on('hidden.bs.modal', function () {
        closeImageStreamModal();
    });

    document.addEventListener('visibilitychange', function() {
        if (document.hidden && isModalVisible) {
            closeImageStreamModal();
        }
    });

    window.addEventListener('beforeunload', function() {
        if (isModalVisible) {
            closeImageStreamModal();
        }
    });

    $('#sessionExpiredModal').modal({
        backdrop: 'static',
        keyboard: false,
        show: false
    });
});

window.addEventListener('unhandledrejection', function(event) {
    console.error('Unhandled promise rejection:', event.reason);
    
    if (event.reason && event.reason.message && 
        (event.reason.message.includes('SESSION_EXPIRED') || 
         event.reason.message.includes('403'))) {
        showSessionExpiredModal();
    }
});
</script><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/urtasker_crm/resources/views/streaming/_employee_grid.blade.php ENDPATH**/ ?>