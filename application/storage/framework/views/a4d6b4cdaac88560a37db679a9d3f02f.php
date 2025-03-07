<div class="table-responsive">
    <?php if(@count($logs ?? []) > 0): ?>
    <table id="demo-updates-addrow" class="table m-t-0 m-b-0 table-hover no-wrap contact-list" data-page-size="10">
        <thead>
            <tr>
                <th class="updatess_col_date"><?php echo app('translator')->get('lang.date'); ?></th>
                <th class="updatess_col_customer_domain"><?php echo app('translator')->get('lang.customer'); ?></th>
                <th class="updatess_col_customer_database"><?php echo app('translator')->get('lang.customer_database'); ?></th>
                <th class="updatess_col_current_version"><?php echo app('translator')->get('lang.current_version'); ?></th>
                <th class="updatess_col_target_version"><?php echo app('translator')->get('lang.target_version'); ?></th>
                <th class="updatess_col_update_status"><?php echo app('translator')->get('lang.update_status'); ?></th>
                <th class="updatess_col_action"><?php echo app('translator')->get('lang.action'); ?></th>
            </tr>
        </thead>
        <tbody id="logs-td-container">
            <!--ajax content here-->
            <?php echo $__env->make('landlord.settings.sections.updateslog.ajax', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <!--ajax content here-->
        </tbody>
        <tfoot>
            <tr>
                <td colspan="20">
                    <!--load more button-->
                    <?php echo $__env->make('misc.load-more-button', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <!--load more button-->
                </td>
            </tr>
        </tfoot>
    </table>
    <?php endif; ?>
    <?php if(@count($logs ?? []) == 0): ?>
    <!--nothing found-->
    <?php echo $__env->make('notifications.no-results-found', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!--nothing found-->
    <?php endif; ?>
</div><?php /**PATH /Users/gilberto/Development/crm/grow/application/resources/views/landlord/settings/sections/updateslog/table.blade.php ENDPATH**/ ?>