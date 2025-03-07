
<?php $__env->startSection('settings_content'); ?>

<!--form-->
<div class="card">
    <div class="card-body" id="landlord-settings-form">

        <form class="form" id="settingsFormGeneral">
            <!--settings_gateways_default_product_name-->
            <div class="form-group row">
                <label class="col-12 control-label col-form-label"><?php echo app('translator')->get('lang.default_product_name'); ?></label>
                <div class="col-12">
                    <input type="text" class="form-control form-control-sm" id="settings_gateways_default_product_name"
                        name="settings_gateways_default_product_name"
                        value="<?php echo e($settings->settings_gateways_default_product_name ?? ''); ?>">
                </div>
            </div>

            <!--settings_gateways_default_product_description-->
            <div class="form-group row">
                <label class="col-12 control-label col-form-label"><?php echo app('translator')->get('lang.default_product_description'); ?></label>
                <div class="col-12">
                    <input type="text" class="form-control form-control-sm"
                        id="settings_gateways_default_product_description"
                        name="settings_gateways_default_product_description"
                        value="<?php echo e($settings->settings_gateways_default_product_description ?? ''); ?>">
                </div>
            </div>

            <div class="alert alert-info"><?php echo app('translator')->get('lang.default_product_name_info'); ?></div>
            <div class="line"></div>
            <!--submit-->
            <div class="text-right">
                <button type="submit" id="commonModalSubmitButton"
                    class="btn btn-rounded-x btn-danger waves-effect text-left ajax-request"
                    data-url="<?php echo e(url('app-admin/settings/gateways')); ?>" data-form-id="landlord-settings-form"
                    data-loading-target="" data-ajax-type="post" data-type="form"
                    data-on-start-submit-button="disable"><?php echo e(cleanLang(__('lang.save_changes'))); ?></button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('landlord.settings.wrapper', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/gilberto/Development/crm/grow/application/resources/views/landlord/settings/sections/gateways/general.blade.php ENDPATH**/ ?>