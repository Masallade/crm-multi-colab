
<?php $__env->startSection('content'); ?>

<section>
    <div id="file-viewer">
        <!-- Add #toolbar=0 to the PDF URL to hide the toolbar -->
        <iframe id="file-iframe" src="<?php echo e($file_data); ?>#toolbar=0" style="width:100%; height:100vh; border:none;"></iframe>
    </div>
</section>

<script>
    // Disable right-click context menu in the parent window
    document.addEventListener('contextmenu', function(e) {
        e.preventDefault();
    });

    // Disable keyboard shortcuts for print, save, etc. in the parent window
    document.addEventListener('keydown', function(e) {
        // Disable Ctrl+P (Print)
        if (e.ctrlKey && e.key === 'p') {
            e.preventDefault();
        }
        // Disable Ctrl+S (Save)
        if (e.ctrlKey && e.key === 's') {
            e.preventDefault();
        }
    });

    // Disable text selection in the parent window
    document.addEventListener('selectstart', function(e) {
        e.preventDefault();
    });

    // Prevent right-click inside the iframe
    const iframe = document.getElementById('file-iframe');
    iframe.onload = function() {
        const iframeWindow = iframe.contentWindow;
        const iframeDocument = iframe.contentDocument || iframeWindow.document;

        // Inject a script into the iframe to disable right-click
        const script = iframeDocument.createElement('script');
        script.text = `
            document.addEventListener('contextmenu', function(e) {
                e.preventDefault();
            });
        `;
        iframeDocument.head.appendChild(script);
    };
</script>

<style>
    #file-viewer {
        width: 100%;
        height: 100vh;
        overflow: hidden;
    }

    #file-iframe {
        overflow: auto; /* Enable scrolling */
    }

    /* Hide scrollbar for Chrome, Safari, and Opera */
    #file-iframe::-webkit-scrollbar {
        display: none;
    }

    /* Hide scrollbar for IE, Edge, and Firefox */
    #file-iframe {
        -ms-overflow-style: none;  /* IE and Edge */
        scrollbar-width: none;  /* Firefox */
    }
</style>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/baselinepractice/public_html/v2/crm/resources/views/file_manager/file_view.blade.php ENDPATH**/ ?>