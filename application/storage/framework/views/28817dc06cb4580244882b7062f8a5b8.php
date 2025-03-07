<div class="subscription-details p-t-10 email-settings">

    <div class="x-heading">
        <?php if($customer->tenant_email_config_type == 'local'): ?>
        <?php echo app('translator')->get('lang.mail_local'); ?>
        <?php else: ?>
        <?php echo app('translator')->get('lang.mail_smtp'); ?>
        <?php endif; ?>
    </div>


    <?php if($customer->tenant_email_config_type == 'local'): ?>
    <table class="table no-border">
        <tbody>
            <tr>
                <td><?php echo app('translator')->get('lang.local_email_address'); ?></td>
                <td class="font-medium w-30"><?php echo e($customer->tenant_email_local_email ?? '---'); ?></td>
            </tr>
            <tr>
                <td><?php echo app('translator')->get('lang.forward_to'); ?></td>
                <td class="font-medium w-30"><?php echo e($customer->tenant_email_forwarding_email ?? '---'); ?></td>
            </tr>
        </tbody>
    </table>

    <div class="line  m-t-30 p-b-40"></div>

    <h5 class="p-b-10"><?php echo app('translator')->get('lang.actions'); ?></h5>


    <?php if($customer->tenant_email_config_type == 'local' && $customer->tenant_email_config_status == 'completed'): ?>
    <div class="alert alert-info">
        <?php echo app('translator')->get('lang.no_action_is_required'); ?>
    </div>
    <?php endif; ?>

    <?php if($customer->tenant_email_config_type == 'local' && $customer->tenant_email_config_status == 'pending'): ?>
    <div class="p-b-20 email_settings_pending_<?php echo e($customer->tenant_id); ?>"><?php echo app('translator')->get('lang.email_settings_comment'); ?></div>

    <div class="email_settings_pending_<?php echo e($customer->tenant_id); ?>">
        <div class="alert alert-danger">
            <div><strong>(<?php echo app('translator')->get('lang.step_1'); ?>)</strong> - <?php echo app('translator')->get('lang.forwarding_email_address_needs_setting'); ?></div>
            <div class="m-t-8 font-weight-400 text-danger"><?php echo e($customer->tenant_email_local_email); ?></div>
        </div>
        <div class="alert alert-danger">
            <div><strong>(<?php echo app('translator')->get('lang.step_2'); ?>)</strong> - <?php echo app('translator')->get('lang.forwarding_email_address_needs_setting_2'); ?></div>
            <div class="m-t-8 font-weight-400 text-danger"><?php echo e($customer->tenant_email_forwarding_email); ?></div>
        </div>
    </div>
    <div class="alert alert-info hidden" id="email_settings_completed_<?php echo e($customer->tenant_id); ?>">
        <?php echo app('translator')->get('lang.no_action_is_required'); ?>
    </div>

    <!--questions about this process-->
    <div class="m-b-30 email_settings_pending_<?php echo e($customer->tenant_id); ?>">

        <div class="p-t-7"><a href="javascript:void(0);"
                id="why_is_this_needed_question"><?php echo app('translator')->get('lang.why_is_this_needed'); ?>?</a></div>

        <div class="p-t-7"><a href="javascript:void(0);"
                id="how_can_i_automate_question"><?php echo app('translator')->get('lang.how_can_i_automate_question'); ?>?</a></div>

        <!--why_is_this_needed-->
        <div class="modal-selector email_questions_answers m-t-20 m-l-0 m-r-0 p-b-25 hidden" id="why_is_this_needed_answer">
            <?php echo app('translator')->get('lang.why_is_this_needed_1'); ?>
            </br /></br />
            <?php echo app('translator')->get('lang.why_is_this_needed_2'); ?>
            </br /></br />
            <?php echo app('translator')->get('lang.why_is_this_needed_3'); ?>
        </div>

        <!--how_can_i_automate-->
        <div class="modal-selector email_questions_answers m-t-20 m-l-0 m-r-0 p-b-25 hidden" id="how_can_i_automate_answer">
            <?php echo app('translator')->get('lang.how_can_i_automate_answer'); ?>
        </br />
        </div>

    </div>

    <div class="text-center p-t-10" id="email_settings_button">
        <button id="submitButton" class="btn btn-danger waves-effect text-left ajax-request"
            data-url="<?php echo e(url('app-admin/customers/'.$customer->tenant_id.'/updated-email-forwarding?source=page')); ?>"
            data-button-loading-annimation="yes"
            data-ajax-type="GET"
            data-on-start-submit-button="disable"><?php echo app('translator')->get('lang.mark_as_done'); ?></button>
    </div>
    <?php endif; ?>
    <?php endif; ?>

    <?php if($customer->tenant_email_config_type == 'smtp'): ?>
    <div class="alert alert-info">
        <?php echo app('translator')->get('lang.customer_is_using_own_stmp'); ?>
    </div>
    <?php endif; ?>



</div><?php /**PATH /Users/gilberto/Development/crm/grow/application/resources/views/landlord/customer/email/email-settings.blade.php ENDPATH**/ ?>