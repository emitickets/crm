
<?php $__env->startSection('settings_content'); ?>

<!--form-->
<div class="card">
    <div class="card-body" id="landlord-settings-form">

        <form class="form" id="settingsFormGeneral">

            <!--settings_base_domain-->
            <div class="form-group row">
                <label class="col-12 control-label col-form-label"><?php echo e(cleanLang(__('lang.base_domain_name'))); ?></label>
                <div class="col-12">
                    <input type="text" class="form-control form-control-sm" id="settings_base_domain"
                        name="settings_base_domain" value="<?php echo e($settings->settings_base_domain ?? ''); ?>">
                </div>
            </div>

            <div class="alert alert-info m-b-20">
                <div><?php echo app('translator')->get('lang.base_domain_name_info'); ?></div>
                <div class="m-t-8"><?php echo app('translator')->get('lang.base_domain_name_info_2'); ?> <span class="font-weight-400">*.</span><span
                        class="font-weight-400"
                        id="settings_base_domain_example_1"><?php echo e($settings->settings_base_domain ?? 'yourdomain.com'); ?></span>
                </div>
                <div class="font-15 font-weight-600 text-underlined m-t-10"><?php echo app('translator')->get('lang.example_usage'); ?>:</div>
                <div class="font-16 font-weight-400 m-t-15 text-info">
                    https://customer.<span
                        id="settings_base_domain_example_2"><?php echo e($settings->settings_base_domain ?? '---'); ?>

                    </span></div>
            </div>

            <div class="line"></div>

            <!--settings_email_domain-->
            <div class="form-group row">
                <label class="col-12 control-label col-form-label"><?php echo e(cleanLang(__('lang.email_domain_name'))); ?></label>
                <div class="col-12">
                    <input type="text" class="form-control form-control-sm" id="settings_email_domain"
                        name="settings_email_domain" value="<?php echo e($settings->settings_email_domain ?? ''); ?>">
                </div>
            </div>

            <div class="alert alert-info m-b-20">
                <div><?php echo app('translator')->get('lang.email_domain_name_info_1'); ?></div>
                <div class="m-t-8"><?php echo app('translator')->get('lang.email_domain_name_info_2'); ?></div>
                <div class="m-t-8"><?php echo app('translator')->get('lang.email_domain_name_info_3'); ?></div>
                <div class="font-15 font-weight-600 text-underlined m-t-10"><?php echo app('translator')->get('lang.example_usage'); ?>:</div>
                <div class="font-16 font-weight-400 m-t-15 text-info">
                    customer@<span id="settings_email_domain_example"><?php echo e($settings->settings_email_domain ?? 'yourdomain.com'); ?>

                    </span></div>
            </div>

            <div class="line"></div>


            <!--item-->
            <div class="form-group row">
                <label class="col-sm-12 text-left control-label col-form-label"><?php echo app('translator')->get('lang.reserved_words'); ?></label>
                <div class="col-sm-12">
                    <textarea class="form-control form-control-sm" rows="5" name="settings_reserved_words"
                        id="settings_reserved_words"><?php echo e($settings->settings_reserved_words ?? ''); ?></textarea>
                </div>
            </div>
            <div class="alert alert-info"><?php echo app('translator')->get('lang.reserved_words_info'); ?></div>

            <!--submit-->
            <div class="text-right">
                <button type="submit" id="commonModalSubmitButton"
                    class="btn btn-rounded-x btn-danger waves-effect text-left ajax-request"
                    data-url="<?php echo e(url('app-admin/settings/domain')); ?>" data-form-id="landlord-settings-form"
                    data-loading-target="" data-ajax-type="post" data-type="form"
                    data-on-start-submit-button="disable"><?php echo e(cleanLang(__('lang.save_changes'))); ?></button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('landlord.settings.wrapper', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/gilberto/Development/crm/grow/application/resources/views/landlord/settings/sections/domain/page.blade.php ENDPATH**/ ?>