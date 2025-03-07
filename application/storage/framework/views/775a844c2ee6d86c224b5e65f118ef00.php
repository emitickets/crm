 <?php $__env->startSection('content'); ?>
<!-- main content -->
<div class="container-fluid">

    <!--page heading-->
    <div class="row page-titles">

        <!-- bread crumbs -->
        <?php echo $__env->make('landlord.misc.crumbs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <!-- bread crumbs -->

        <!-- action buttons -->
        <?php echo $__env->make('landlord.packages.actions.page-actions', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <!-- action buttons -->

    </div>
    <!--page heading-->


    <!-- page content -->
    <div class="row">
        <div class="col-12">
        
            <?php if(@count($packages) > 0): ?>
              <div class="row" id="packages-container">
                  <?php $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <?php echo $__env->make('landlord.packages.packages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </div>
            <?php else: ?>
            <!--nothing found-->
            <?php echo $__env->make('notifications.no-results-found', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>
        </div>
    </div>
    <!--page content -->

</div>
<!--main content -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('landlord.layout.wrapper', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/gilberto/Development/crm/grow/application/resources/views/landlord/packages/wrapper.blade.php ENDPATH**/ ?>