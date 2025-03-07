<div class="col-sm-12 col-md-6 col-lg-4 col-xl-3" id="package_<?php echo e($package->package_id); ?>">
    <div class="package-pricing-box m-b-40">
        <div class="pricing-header">
            <div class="x-heading">
                <?php echo e($package->package_name); ?>

                <?php if($package->package_featured == 'yes'): ?>
                <span class="sl-icon-star text-danger p-l-5" data-toggle="tooltip"
                    title="<?php echo app('translator')->get('lang.featured'); ?>"></span>
                <?php endif; ?>
            </div>
            <div class="x-price-month">
                <?php echo e(runtimeMoneyFormatSaaS($package->package_amount_monthly)); ?><span>/<?php echo app('translator')->get('lang.month'); ?></span>
            </div>
            <div class="x-price-cycle">
                <?php echo e(runtimeMoneyFormatSaaS($package->package_amount_yearly)); ?><span>/<?php echo app('translator')->get('lang.year'); ?></span>
            </div>
        </div>
        <div class="price-table-content">
            <div class="price-row"><strong><?php echo e($package->package_limits_clients); ?></strong> <?php echo app('translator')->get('lang.clients'); ?></div>
            <div class="price-row"><strong><?php echo e($package->package_limits_projects); ?></strong> <?php echo app('translator')->get('lang.project'); ?></div>
            <div class="price-row"><strong><?php echo e($package->package_limits_team); ?></strong> <?php echo app('translator')->get('lang.team_members'); ?>
            </div>

            <!--package_module_tasks-->
            <div class="price-row">
                <?php if($package->package_module_tasks == 'yes'): ?>
                <i class="sl-icon-check text-success"></i>
                <?php else: ?>
                <i class="sl-icon-close text-danger"></i>
                <?php endif; ?>
                <?php echo app('translator')->get('lang.tasks'); ?>
            </div>

            <!--package_module_invoices-->
            <div class="price-row">
                <?php if($package->package_module_invoices == 'yes'): ?>
                <i class="sl-icon-check text-success"></i>
                <?php else: ?>
                <i class="sl-icon-close text-danger"></i>
                <?php endif; ?>
                <?php echo app('translator')->get('lang.invoices'); ?>
            </div>

            <!--package_module_estimates-->
            <div class="price-row">
                <?php if($package->package_module_estimates == 'yes'): ?>
                <i class="sl-icon-check text-success"></i>
                <?php else: ?>
                <i class="sl-icon-close text-danger"></i>
                <?php endif; ?>
                <?php echo app('translator')->get('lang.estimates'); ?>
            </div>

            <!--package_module_proposals-->
            <div class="price-row">
                <?php if($package->package_module_proposals == 'yes'): ?>
                <i class="sl-icon-check text-success"></i>
                <?php else: ?>
                <i class="sl-icon-close text-danger"></i>
                <?php endif; ?>
                <?php echo app('translator')->get('lang.proposals'); ?>
            </div>

            <!--package_module_contracts-->
            <div class="price-row">
                <?php if($package->package_module_contracts == 'yes'): ?>
                <i class="sl-icon-check text-success"></i>
                <?php else: ?>
                <i class="sl-icon-close text-danger"></i>
                <?php endif; ?>
                <?php echo app('translator')->get('lang.contracts'); ?>
            </div>

            <!--settings_modules_messages-->
            <div class="price-row">
                <?php if($package->package_module_messages == 'yes'): ?>
                <i class="sl-icon-check text-success"></i>
                <?php else: ?>
                <i class="sl-icon-close text-danger"></i>
                <?php endif; ?>
                <?php echo app('translator')->get('lang.instant_messaging'); ?>
            </div>

            <!--package_module_expense-->
            <div class="price-row">
                <?php if($package->package_module_expense == 'yes'): ?>
                <i class="sl-icon-check text-success"></i>
                <?php else: ?>
                <i class="sl-icon-close text-danger"></i>
                <?php endif; ?>
                <?php echo app('translator')->get('lang.expenses'); ?>
            </div>

            <!--package_module_leads-->
            <div class="price-row">
                <?php if($package->package_module_leads == 'yes'): ?>
                <i class="sl-icon-check text-success"></i>
                <?php else: ?>
                <i class="sl-icon-close text-danger"></i>
                <?php endif; ?>
                <?php echo app('translator')->get('lang.leads'); ?>
            </div>

            <!--package_module_knowledgebase-->
            <div class="price-row">
                <?php if($package->package_module_knowledgebase == 'yes'): ?>
                <i class="sl-icon-check text-success"></i>
                <?php else: ?>
                <i class="sl-icon-close text-danger"></i>
                <?php endif; ?>
                <?php echo app('translator')->get('lang.knowledgebase'); ?>
            </div>

            <!--package_module_subscriptions-->
            <div class="price-row">
                <?php if($package->package_module_subscriptions == 'yes'): ?>
                <i class="sl-icon-check text-success"></i>
                <?php else: ?>
                <i class="sl-icon-close text-danger"></i>
                <?php endif; ?>
                <?php echo app('translator')->get('lang.subscriptions'); ?>
            </div>

            <!--package_module_tickets-->
            <div class="price-row">
                <?php if($package->package_module_tickets == 'yes'): ?>
                <i class="sl-icon-check text-success"></i>
                <?php else: ?>
                <i class="sl-icon-close text-danger"></i>
                <?php endif; ?>
                <?php echo app('translator')->get('lang.tickets'); ?>
            </div>

            <!--package_module_calendar-->
            <div class="price-row">
                <?php if($package->package_module_calendar == 'yes'): ?>
                <i class="sl-icon-check text-success"></i>
                <?php else: ?>
                <i class="sl-icon-close text-danger"></i>
                <?php endif; ?>
                <?php echo app('translator')->get('lang.calendar'); ?>
            </div>

            <!--package_module_timetracking-->
            <div class="price-row">
                <?php if($package->package_module_timetracking == 'yes'): ?>
                <i class="sl-icon-check text-success"></i>
                <?php else: ?>
                <i class="sl-icon-close text-danger"></i>
                <?php endif; ?>
                <?php echo app('translator')->get('lang.time_tracking'); ?>
            </div>

            <!--package_module_reminders-->
            <div class="price-row">
                <?php if($package->package_module_reminders == 'yes'): ?>
                <i class="sl-icon-check text-success"></i>
                <?php else: ?>
                <i class="sl-icon-close text-danger"></i>
                <?php endif; ?>
                <?php echo app('translator')->get('lang.reminders'); ?>
            </div>
        </div>

        <!--LANDLORD BUTTONS-->
        <?php if(config('visibility.landlord')): ?>
        <div class="price-footer p-t-20 p-b-10">
            <!--archive-->
            <?php if($package->package_status == 'active'): ?>
            <button type="button" class="btn btn-warning btn-sm confirm-action-danger"
                data-confirm-title="<?php echo app('translator')->get('lang.archive'); ?>" data-confirm-text="<?php echo app('translator')->get('lang.are_you_sure'); ?>"
                data-ajax-type="GET" data-url="<?php echo e(url('app-admin/packages/'.$package->package_id).'/archive'); ?>">
                <?php echo app('translator')->get('lang.archive'); ?>
            </button>
            <?php endif; ?>

            <!--restore-->
            <?php if($package->package_status == 'archived'): ?>
            <button type="button" class="btn btn-success btn-sm confirm-action-danger"
                data-confirm-title="<?php echo app('translator')->get('lang.restore'); ?>" data-confirm-text="<?php echo app('translator')->get('lang.are_you_sure'); ?>"
                data-ajax-type="GET" data-url="<?php echo e(url('app-admin/packages/'.$package->package_id).'/restore'); ?>">
                <?php echo app('translator')->get('lang.restore'); ?>
            </button>
            <?php endif; ?>

            <!--delete-->
            <?php if($package->count_subscriptions > 0): ?>
            <a href="javascript:void(0);" class="btn btn-default btn-sm" disabled="disabled" data-toggle="tooltip"
                title="<?php echo app('translator')->get('lang.package_has_subscriptions_cannot_delete'); ?>">
                <?php echo app('translator')->get('lang.delete'); ?>
            </a>
            <?php else: ?>
            <button type="button" class="btn btn-danger btn-sm confirm-action-danger"
                data-confirm-title="<?php echo app('translator')->get('lang.delete'); ?>" data-confirm-text="<?php echo app('translator')->get('lang.are_you_sure'); ?>"
                data-ajax-type="DELETE" data-url="<?php echo e(url('app-admin/packages/'.$package->package_id)); ?>">
                <?php echo app('translator')->get('lang.delete'); ?>
            </button>
            <?php endif; ?>
            <!--edit-->
            <button type="button"
                class="btn btn-info btn-sm edit-add-modal-button js-ajax-ux-request reset-target-modal-form"
                data-toggle="modal" data-target="#commonModal"
                data-url="<?php echo e(url('app-admin/packages/'.$package->package_id).'/edit'); ?>"
                data-loading-target="commonModalBody" data-modal-title="<?php echo app('translator')->get('lang.edit'); ?>" data-modal-size="modal-xl"
                data-action-url="<?php echo e(url('app-admin/packages/'.$package->package_id)); ?>" data-action-method="PUT"
                data-action-ajax-class="js-ajax-ux-request">
                <?php echo app('translator')->get('lang.edit'); ?>
            </button>

        </div>
        <?php endif; ?>

        <!--TENANT BUTTONS-->
        <?php if(config('visibility.tenant')): ?>
        <div class="price-footer p-t-20 p-b-10">


            <!--this is your current plan-->
            <?php if(config('system.settings_saas_package_id') == $package->package_id): ?>
            <span
                class="label label-light-inverse p-t-9 p-b-9 p-l-10 p-r-10"><?php echo app('translator')->get('lang.this_is_your_current_plan'); ?></span>
            <?php else: ?>
            <button type="button" class="btn btn-info btn-sm js-ajax-ux-request"
                data-url="<?php echo e(url('settings/account/'.$package->package_id).'/change-plan'); ?>">
                <?php echo app('translator')->get('lang.select_plan'); ?>
            </button>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
</div><?php /**PATH /Users/gilberto/Development/crm/grow/application/resources/views/landlord/packages/packages.blade.php ENDPATH**/ ?>