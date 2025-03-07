 <?php $__env->startSection('content'); ?>
<!-- main content -->
<div class="container-fluid">

    <!--page heading-->
    <div class="row page-titles">

        <!-- bread crumbs -->
        <?php echo $__env->make('landlord.misc.crumbs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <!-- bread crumbs -->

    </div>
    <!--page heading-->


    <!-- Row -->
    <div class="row">
        <!-- Column -->
        <div class="col-12">
            <div class="card">
                <div class="card-body dynamic-content-container">
                    <div id="dynamic-content-container">
                        <!--dynamic events-->
                    </div>

                    <!--load more button-->
                    <?php echo $__env->make('landlord.misc.load-more-dynamic-button', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
        </div>
        <!-- Column -->
    </div>
    <!-- Row -->

</div>
<!--main content -->

<!--dynamically load timeline events-->
<script src="public/js/landlord/dynamic/timeline.js?v=<?php echo e(config('system.versioning')); ?>" id="dynamic-load-timeline-events"
    data-loading-target="dynamic-content-container" data-progress-bar="hidden" data-url="<?php echo e(url('app-admin/events?source=events')); ?>">
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('landlord.layout.wrapper', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/gilberto/Development/crm/grow/application/resources/views/landlord/events/wrapper.blade.php ENDPATH**/ ?>