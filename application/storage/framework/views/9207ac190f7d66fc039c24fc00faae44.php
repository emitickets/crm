<!--CRUMBS CONTAINER (RIGHT)-->
<div class="col-md-12  col-lg-7 p-b-9 align-self-center text-right <?php echo e($page['list_page_actions_size'] ?? ''); ?> <?php echo e($page['list_page_container_class'] ?? ''); ?>"
    id="list-page-actions-container">
    <div id="list-page-actions">
       <!--archived-->
        <a data-toggle="tooltip" title="<?php echo e(cleanLang(__('lang.archived'))); ?>"
            class="list-actions-button btn btn-page-actions waves-effect waves-dark <?php echo e(saasToggleArchivedPackages()); ?>"
            href="<?php echo e(url('app-admin/packages?package_status=archived')); ?>">
            <i class="ti-archive"></i>
        </a>

        <!--ADD NEW ITEM-->
        <button type="button"
            class="btn btn-danger btn-add-circle edit-add-modal-button js-ajax-ux-request reset-target-modal-form"
            data-toggle="modal" data-target="#commonModal" data-url="<?php echo e(url('/app-admin/packages/create')); ?>"
            data-loading-target="commonModalBody" data-modal-title="<?php echo app('translator')->get('lang.create_package'); ?>"
            data-action-url="<?php echo e(url('/app-admin/packages')); ?>" data-action-method="POST" data-modal-size="modal-xl"
            data-action-ajax-loading-target="commonModalBody">
            <i class="ti-plus"></i>
        </button>
    </div>
</div><?php /**PATH /Users/gbetus/Development/crm/grow/application/resources/views/landlord/packages/actions/page-actions.blade.php ENDPATH**/ ?>