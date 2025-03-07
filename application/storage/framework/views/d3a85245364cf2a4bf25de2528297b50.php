<!DOCTYPE html>
<html lang="en" class="app-admin logged-out">

<!--html header-->
<?php echo $__env->make('landlord.layout.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<!--html header-->

<body class="<?php echo e($page['page'] ?? ''); ?>">
    <!--preloader-->
    <div class="preloader">
        <div class="loader">
            <div class="loader-loading"></div>
        </div>
    </div>
    <!--preloader-->

    <!--main content-->
    <div id="main-wrapper">
        <?php echo $__env->yieldContent('content'); ?>
    </div>
</body>

<?php echo $__env->make('landlord.layout.footerjs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</html><?php /**PATH /Users/gilberto/Development/crm/grow/application/resources/views/landlord/layout/wrapperplain.blade.php ENDPATH**/ ?>