 <?php $__env->startSection('content'); ?>
<!-- main content -->
<div class="container-fluid saas-home p-l-30 p-r-30">

    <!-- top panel stats -->
    <?php echo $__env->make('landlord.home.components.panel-top-stats', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <!-- income chart -->
    <?php echo $__env->make('landlord.home.components.panel-income-chart', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


        <!-- events timeline -->
        <?php echo $__env->make('landlord.home.components.panel-events', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


</div>
<!--main content -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('landlord.layout.wrapper', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/gbetus/Development/crm/grow/application/resources/views/landlord/home/wrapper.blade.php ENDPATH**/ ?>