
<?php $__env->startSection('settings_content'); ?>

<!--form-->
<div class="card">
    <div class="card-body" id="landlord-settings-form">

        <h5 class="m-b-20"><?php echo app('translator')->get('lang.system_information'); ?></h5>

        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td class="font-weight-400"><?php echo app('translator')->get('lang.crm_version'); ?></td>
                    <td>v<?php echo e($data['crm_version']); ?></td>
                </tr>
                <tr>
                    <td class="font-weight-400"><?php echo app('translator')->get('lang.info_php_version'); ?></td>
                    <td><?php echo e($data['php_version']); ?></td>
                </tr>
                <tr>
                    <td class="font-weight-400"><?php echo app('translator')->get('lang.info_memory_limit'); ?> <span class="align-middle text-info font-16"
                            data-toggle="tooltip" title="<?php echo app('translator')->get('lang.info_server_ini'); ?>" data-placement="top"><i
                                class="ti-info-alt"></i></span></td>
                    <td><?php echo e($data['memory_limit']); ?></td>
                </tr>
                <tr>
                    <td class="font-weight-400"><?php echo app('translator')->get('lang.info_max_upload_size'); ?> <span class="align-middle text-info font-16"
                        data-toggle="tooltip" title="<?php echo app('translator')->get('lang.info_server_ini'); ?>" data-placement="top"><i
                            class="ti-info-alt"></i></span></td>
                    <td><?php echo e($data['upload_size_limit']); ?></td>
                </tr>
                <tr>
                    <td class="font-weight-400"><?php echo app('translator')->get('lang.info_landlord_database'); ?></td>
                    <td><?php echo e($data['landlord_database']); ?></td>
                </tr>
                <tr>
                    <td class="font-weight-400"><?php echo app('translator')->get('lang.info_database_creation_method'); ?></td>
                    <td><?php echo e(db_creation_method($data['mysql_creation_type'])); ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('landlord.settings.wrapper', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/gilberto/Development/crm/grow/application/resources/views/landlord/settings/sections/info/page.blade.php ENDPATH**/ ?>