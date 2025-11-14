<?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<!--each row-->
<tr id="user_<?php echo e($user->id); ?>">
    <!--name-->
    <td class="col_name">
        <img src="<?php echo e(getUsersAvatar($user->avatar_directory, $user->avatar_filename, $user->id)); ?>" alt="user"
            class="img-circle avatar-xsmall">
        <?php echo e($user->first_name); ?> <?php echo e($user->last_name); ?>

        <?php if($user->id == 1): ?>
        <span class="sl-icon-star text-warning p-l-5" data-toggle="tooltip"
            title="<?php echo e(cleanLang(__('lang.primary_admin'))); ?>"></span>
        <?php endif; ?>
    </td>
    <!--email-->
    <td class="col_email">
        <?php echo e($user->email); ?>

    </td>
    <!--created-->
    <td class="col_created">
        <?php echo e(runtimeDate($user->created)); ?>

    </td>

    <!--actions-->
    <td class="col_action actions_column">

        <?php if(auth()->user()->primary_admin == 'yes'): ?>
        <!--action button-->
        <span class="list-table-action dropdown font-size-inherit">
            <!--delete-->
            <?php if($user->primary_admin == 'yes'): ?>
            <span class="btn btn-outline-default btn-circle btn-sm disabled <?php echo e(runtimePlaceholdeActionsButtons()); ?>"
                data-toggle="tooltip" title="<?php echo e(cleanLang(__('lang.actions_not_available'))); ?>"><i
                    class="sl-icon-trash"></i></span>
            <?php else: ?>
            <button type="button" title="<?php echo app('translator')->get('lang.delete'); ?>"
                class="data-toggle-action-tooltip btn btn-outline-danger btn-circle btn-sm confirm-action-danger"
                data-confirm-title="<?php echo app('translator')->get('lang.delete_user'); ?>" data-confirm-text="<?php echo app('translator')->get('lang.are_you_sure'); ?>"
                data-ajax-type="DELETE" data-url="<?php echo e(url('/app-admin/team/'.$user->id)); ?>">
                <i class="sl-icon-trash"></i>
            </button>
            <?php endif; ?>

            <!--edit-->
            <button type="button" title="<?php echo app('translator')->get('lang.edit'); ?>"
                class="data-toggle-action-tooltip btn btn-outline-success btn-circle btn-sm edit-add-modal-button js-ajax-ux-request reset-target-modal-form"
                data-toggle="modal" data-target="#commonModal"
                data-url="<?php echo e(urlResource('/app-admin/team/'.$user->id.'/edit')); ?>" data-loading-target="commonModalBody"
                data-modal-title="<?php echo app('translator')->get('lang.edit_user'); ?>"
                data-action-url="<?php echo e(urlResource('/app-admin/team/'.$user->id)); ?>" data-action-method="PUT"
                data-action-ajax-class="" data-action-ajax-loading-target="users-td-container">
                <i class="sl-icon-note"></i>
            </button>
        </span>
        <?php endif; ?>
        <!--action button-->
    </td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<!--each row--><?php /**PATH /Users/gbetus/Development/crm/grow/application/resources/views/landlord/team/table/ajax.blade.php ENDPATH**/ ?>