<ul class="p-b-70">

    <!--start-->
    <li>
        <a class="<?php echo e($page['inner_menu_start'] ?? ''); ?>"
            href="<?php echo e(url('app-admin/frontend/start')); ?>"><?php echo app('translator')->get('lang.start'); ?></a>
    </li>

    <!--payment_gateways-->
    <li class="group-menu-wrapper <?php echo e($page['inner_group_menu_theme'] ?? ''); ?>">
        <a class="inner-menu-item <?php echo e($page['inner_group_menu_theme'] ?? ''); ?>" href="javascript:void(0);"
            aria-expanded="false"><?php echo app('translator')->get('lang.theme'); ?></a>
        <ul aria-expanded="false" class="hidden">
            <!--logo-->
            <li>
                <a class="<?php echo e($page['inner_menu_logo'] ?? ''); ?>"
                    href="<?php echo e(url('app-admin/frontend/logo')); ?>"><?php echo app('translator')->get('lang.logo'); ?></a>
            </li>
            <!--metat tags-->
            <li>
                <a class="<?php echo e($page['inner_menu_metatags'] ?? ''); ?>"
                    href="<?php echo e(url('app-admin/frontend/metatags')); ?>"><?php echo app('translator')->get('lang.meta_tags'); ?></a>
            </li>
            <!--code-->
            <li>
                <a class="<?php echo e($page['inner_menu_customcode'] ?? ''); ?>"
                    href="<?php echo e(url('app-admin/frontend/customcode')); ?>"><?php echo app('translator')->get('lang.code'); ?></a>
            </li>
        </ul>
    </li>

    <!--top menu-->
    <li>
        <a class="<?php echo e($page['inner_menu_main_menu'] ?? ''); ?>"
            href="<?php echo e(url('app-admin/frontend/mainmenu')); ?>"><?php echo app('translator')->get('lang.main_menu'); ?></a>
    </li>

    <!--hero header-->
    <li>
        <a class="<?php echo e($page['inner_menu_hero'] ?? ''); ?>"
            href="<?php echo e(url('app-admin/frontend/hero')); ?>"><?php echo app('translator')->get('lang.hero_header'); ?></a>
    </li>

    <!--home-->
    <li>
        <a class="<?php echo e($page['inner_menu_section_home'] ?? ''); ?>"
            href="<?php echo e(url('app-admin/frontend/section/1/list')); ?>"><?php echo app('translator')->get('lang.home_features'); ?></a>
    </li>

    <!--pricing-->
    <li>
        <a class="<?php echo e($page['inner_menu_pricing'] ?? ''); ?>"
            href="<?php echo e(url('app-admin/frontend/pricing')); ?>"><?php echo app('translator')->get('lang.pricing'); ?></a>
    </li>

    <!--contact us-->
    <li>
        <a class="<?php echo e($page['inner_menu_contact'] ?? ''); ?>"
            href="<?php echo e(url('app-admin/frontend/contact')); ?>"><?php echo app('translator')->get('lang.contact_us'); ?></a>
    </li>

    <!--signup-->
    <li>
        <a class="<?php echo e($page['inner_menu_signup'] ?? ''); ?>"
            href="<?php echo e(url('app-admin/frontend/signup')); ?>"><?php echo app('translator')->get('lang.sign_up'); ?></a>
    </li>

    <!--login-->
    <li>
        <a class="<?php echo e($page['inner_menu_login'] ?? ''); ?>"
            href="<?php echo e(url('app-admin/frontend/login')); ?>"><?php echo app('translator')->get('lang.log_in'); ?></a>
    </li>

    <!--FAQ-->
    <li>
        <a class="<?php echo e($page['inner_menu_faq'] ?? ''); ?>" href="<?php echo e(url('app-admin/frontend/faq')); ?>"><?php echo app('translator')->get('lang.faq'); ?></a>
    </li>

    <!--PAGES-->
    <li>
        <a class="<?php echo e($page['inner_menu_pages'] ?? ''); ?>"
            href="<?php echo e(url('app-admin/frontend/pages')); ?>"><?php echo app('translator')->get('lang.pages'); ?></a>
    </li>

    <!--footer-->
    <li>
        <a class="<?php echo e($page['inner_menu_footer'] ?? ''); ?>"
            href="<?php echo e(url('app-admin/frontend/footer')); ?>"><?php echo app('translator')->get('lang.footer'); ?></a>
    </li>


    <!--footer cta-->
    <li>
        <a class="<?php echo e($page['inner_menu_footercta'] ?? ''); ?>"
            href="<?php echo e(url('app-admin/frontend/footercta')); ?>"><?php echo app('translator')->get('lang.footer_cta'); ?></a>
    </li>
</ul><?php /**PATH /Users/gilberto/Development/crm/grow/application/resources/views/landlord/frontend/leftmenu.blade.php ENDPATH**/ ?>