<ul class="inner-menu p-b-70">

    <!--general settings-->
    <li>
        <a class="inner-menu-item <?php echo e($page['inner_menu_general'] ?? ''); ?>"
            href="<?php echo e(url('app-admin/settings/general')); ?>"><?php echo app('translator')->get('lang.general_settings'); ?></a>
    </li>

    <!--domain settings-->
    <li>
        <a class="inner-menu-item <?php echo e($page['inner_menu_domain'] ?? ''); ?>"
            href="<?php echo e(url('app-admin/settings/domain')); ?>"><?php echo app('translator')->get('lang.domain_settings'); ?></a>
    </li>

    <!--account_settings-->
    <li>
        <a class="inner-menu-item <?php echo e($page['inner_menu_defaults'] ?? ''); ?>"
            href="<?php echo e(url('app-admin/settings/defaults')); ?>"><?php echo app('translator')->get('lang.account_settings'); ?></a>
    </li>

    <!--company details-->
    <li>
        <a class="inner-menu-item <?php echo e($page['inner_menu_company'] ?? ''); ?>"
            href="<?php echo e(url('app-admin/settings/company')); ?>"><?php echo app('translator')->get('lang.company_details'); ?></a>
    </li>

    <!--email-->
    <li class="group-menu-wrapper <?php echo e($page['inner_group_menu_email'] ?? ''); ?>">
        <a class="inner-menu-item <?php echo e($page['inner_group_menu_email'] ?? ''); ?>" href="javascript:void(0);"
            aria-expanded="false"><?php echo app('translator')->get('lang.email'); ?></a>
        <ul aria-expanded="false" class="hidden">
            <!--email_templates-->
            <li>
                <a class="<?php echo e($page['inner_menu_emailtemplates'] ?? ''); ?>"
                    href="<?php echo e(url('app-admin/settings/emailtemplates')); ?>"><?php echo app('translator')->get('lang.email_templates'); ?></a>
            </li>

            <!--email_settings-->
            <li>
                <a class="<?php echo e($page['inner_menu_email'] ?? ''); ?>"
                    href="<?php echo e(url('app-admin/settings/email')); ?>"><?php echo app('translator')->get('lang.email_settings'); ?></a>
            </li>


            <!--email_log-->
            <li>
                <a class="<?php echo e($page['inner_menu_email_log'] ?? ''); ?>"
                    href="<?php echo e(url('app-admin/settings/emaillog')); ?>"><?php echo app('translator')->get('lang.email_log'); ?></a>
            </li>

            <!--smtp settings-->
            <li>
                <a class="<?php echo e($page['inner_menu_smtp'] ?? ''); ?>"
                    href="<?php echo e(url('app-admin/settings/smtp')); ?>"><?php echo app('translator')->get('lang.smtp_settings'); ?></a>
            </li>
        </ul>
    </li>


    <!--currency settings-->
    <li>
        <a class="inner-menu-item <?php echo e($page['inner_menu_currency'] ?? ''); ?>"
            href="<?php echo e(url('app-admin/settings/currency')); ?>"><?php echo app('translator')->get('lang.currency'); ?></a>
    </li>


    <!--logo settings-->
    <li>
        <a class="inner-menu-item <?php echo e($page['inner_menu_logo'] ?? ''); ?>"
            href="<?php echo e(url('app-admin/settings/logo')); ?>"><?php echo app('translator')->get('lang.logo'); ?></a>
    </li>


    <!--cronjob-->
    <li>
        <a class="inner-menu-item <?php echo e($page['inner_menu_cronjob'] ?? ''); ?>"
            href="<?php echo e(url('app-admin/settings/cronjob')); ?>"><?php echo app('translator')->get('lang.cronjob'); ?></a>
    </li>

    <!--free trial-->
    <li>
        <a class="inner-menu-item <?php echo e($page['inner_menu_free_trial'] ?? ''); ?>"
            href="<?php echo e(url('app-admin/settings/freetrial')); ?>"><?php echo app('translator')->get('lang.free_trial'); ?></a>
    </li>



    <!--payment_gateways-->
    <li class="group-menu-wrapper <?php echo e($page['inner_group_menu_billing'] ?? ''); ?>">
        <a class="inner-menu-item <?php echo e($page['inner_group_menu_billing'] ?? ''); ?>" href="javascript:void(0);"
            aria-expanded="false"><?php echo app('translator')->get('lang.payment_gateways'); ?></a>
        <ul aria-expanded="false" class="hidden">
            <!--general-->
            <li>
                <a class="<?php echo e($page['inner_menu_gateways'] ?? ''); ?>"
                    href="<?php echo e(url('app-admin/settings/gateways')); ?>"><?php echo app('translator')->get('lang.general_settings'); ?></a>
            </li>
            <!--stripe-->
            <li>
                <a class="<?php echo e($page['inner_menu_stripe'] ?? ''); ?>"
                    href="<?php echo e(url('app-admin/settings/stripe')); ?>">Stripe</a>
            </li>
            <!--paypal-->
            <li>
                <a class="<?php echo e($page['inner_menu_paypal'] ?? ''); ?>"
                    href="<?php echo e(url('app-admin/settings/paypal')); ?>">Paypal</a>
            </li>
            <!--paystack-->
            <li>
                <a class="<?php echo e($page['inner_menu_paystack'] ?? ''); ?>"
                    href="<?php echo e(url('app-admin/settings/paystack')); ?>">Paystack</a>
            </li>
            <!--razorpay-->
            <li>
                <a class="<?php echo e($page['inner_menu_razorpay'] ?? ''); ?>"
                    href="<?php echo e(url('app-admin/settings/razorpay')); ?>">Razorpay</a>
            </li>
            <!--offline-->
            <li>
                <a class="<?php echo e($page['inner_menu_offline_payment'] ?? ''); ?>"
                    href="<?php echo e(url('app-admin/settings/offlinepayments')); ?>"><?php echo app('translator')->get('lang.offline_payments'); ?></a>
            </li>
        </ul>
    </li>

    <!--system-->
    <li>
        <a class="inner-menu-item <?php echo e($page['inner_menu_system'] ?? ''); ?>"
            href="<?php echo e(url('app-admin/settings/system')); ?>"><?php echo app('translator')->get('lang.system'); ?></a>
    </li>


    <!--reCPATCH-->
    <li>
        <a class="inner-menu-item <?php echo e($page['inner_menu_captcha'] ?? ''); ?>"
            href="<?php echo e(url('app-admin/settings/captcha')); ?>">reCAPTCHA</a>
    </li>


    <!--updates-->
    <li>
        <a class="inner-menu-item <?php echo e($page['inner_menu_updates'] ?? ''); ?>"
            href="<?php echo e(url('app-admin/settings/updates')); ?>"><?php echo app('translator')->get('lang.updates'); ?></a>
    </li>

    <!--debugging-->
    <li class="group-menu-wrapper <?php echo e($page['inner_group_menu_debugging'] ?? ''); ?>">
        <a class="inner-menu-item <?php echo e($page['inner_group_menu_debugging'] ?? ''); ?>" href="javascript:void(0);"
            aria-expanded="false"><?php echo app('translator')->get('lang.debugging'); ?></a>
        <ul aria-expanded="false" class="hidden">
            <!--updates_log-->
            <li>
                <a class="<?php echo e($page['inner_menu_updating_log'] ?? ''); ?>"
                    href="<?php echo e(url('app-admin/settings/updateslog')); ?>"><?php echo app('translator')->get('lang.updates_log'); ?></a>
            </li>
            <!--eror log-->
            <li>
                <a class="<?php echo e($page['inner_menu_error_logs'] ?? ''); ?>"
                    href="<?php echo e(url('app-admin/settings/errorlogs')); ?>"><?php echo app('translator')->get('lang.error_logs'); ?></a>
            </li>
        </ul>
    </li>


</ul><?php /**PATH /Users/gbetus/Development/crm/grow/application/resources/views/landlord/settings/leftmenu.blade.php ENDPATH**/ ?>