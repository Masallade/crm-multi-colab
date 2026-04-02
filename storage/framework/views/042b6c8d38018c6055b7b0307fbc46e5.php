<?php $__env->startSection('content'); ?>
    <div class="container mt-5">
        <h1 class="mb-4">Exe Working Report</h1>
        <form id="exe-working-search-form" method="GET" action="" class="mb-4">
            <div class="row">
                <div class="col-md-6 mb-2">
                    <div class="input-group">
                        <input type="text" name="search" id="search" class="form-control" placeholder="Search by name or staff ID" value="<?php echo e(request('search', $search ?? '')); ?>">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">Search</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-2">
                    <select name="status" id="status" class="form-control">
                        <option value="">All Status</option>
                        <option value="Active" <?php echo e((request('status', $status ?? '') == 'Active') ? 'selected' : ''); ?>>Active</option>
                        <option value="Inactive" <?php echo e((request('status', $status ?? '') == 'Inactive') ? 'selected' : ''); ?>>Inactive</option>
                    </select>
                </div>
                <div class="col-md-3 mb-2">
                    <div class="input-daterange input-group">
                        <input type="date" class="form-control" id="start_date" name="start_date" value="<?php echo e(request('start_date')); ?>" placeholder="Start date">
                        <span class="input-group-addon" style="padding: 0 8px; line-height: 34px;">to</span>
                        <input type="date" class="form-control" id="end_date" name="end_date" value="<?php echo e(request('end_date')); ?>" placeholder="End date">
                    </div>
                </div>
            </div>
        </form>
        <div id="employee-grid">
            <?php echo $__env->make('streaming._employee_grid', [
                'employees' => $employees,
                // Hide stream button unless we're on a streaming* route
                'hide_stream_button' => !request()->is('streaming*')
            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('exe-working-search-form');
        const grid = document.getElementById('employee-grid');
        
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            fetchGrid();
        });
        
        document.getElementById('status').addEventListener('change', function() {
            fetchGrid();
        });
        document.getElementById('start_date').addEventListener('change', fetchGrid);
        document.getElementById('end_date').addEventListener('change', fetchGrid);
        
        function fetchGrid() {
            const formData = new FormData(form);
            const params = new URLSearchParams(formData).toString();
            
            fetch(window.location.pathname + '?' + params, {
                headers: { 
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': getCsrfToken()
                },
                credentials: 'same-origin'
            })
            .then(response => {
                if (response.status === 419 || response.status === 403) {
                    showSessionExpiredModal();
                    throw new Error('SESSION_EXPIRED');
                }
                return response.json();
            })
            .then(data => {
                grid.innerHTML = data.html;
            })
            .catch(error => {
                console.error('Error fetching grid:', error);
            });
        }
        
        function getCsrfToken() {
            return document.querySelector('meta[name="csrf-token"]').content;
        }
        
        function showSessionExpiredModal() {
            $('#sessionExpiredModal').modal('show');
        }
    });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/urtasker_crm/resources/views/streaming/index.blade.php ENDPATH**/ ?>