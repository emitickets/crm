<div class="card count-<?php echo e(@count($users)); ?>" id="users-table-wrapper">
    <div class="card-body">
        <div class="table-responsive list-table-wrapper">
            <?php if(@count($users) > 0): ?>
            <table id="users-list-table" class="table m-t-0 m-b-0 table-hover no-wrap foo-list" data-page-size="10">
                <thead>
                    <tr>
                        <!--name-->
                        <th class="col_name"><a href="javascript:void(0)"><?php echo app('translator')->get('lang.name'); ?></a></th>
                        <!--email-->
                        <th class="col_email"><a href="javascript:void(0)"><?php echo app('translator')->get('lang.email'); ?></a></th>
                        <!--created-->
                        <th class="col_created"><a href="javascript:void(0)"><?php echo app('translator')->get('lang.date_created'); ?></a></th>
                        <!--actions-->
                        <th class="col_action"><a href="javascript:void(0)"><?php echo app('translator')->get('lang.action'); ?></a></th>
                    </tr>
                </thead>
                <tbody id="users-td-container">
                    <!--ajax content here-->
                    <?php echo $__env->make('landlord.team.table.ajax', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <!--ajax content here-->
                    <!--bulk actions - change category-->
                    <input type="hidden" name="checkbox_actions_users_category" id="checkbox_actions_users_category">
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
            <?php endif; ?> <?php if(@count($users) == 0): ?>
            <!--nothing found-->
            <?php echo $__env->make('notifications.no-results-found', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <!--nothing found-->
            <?php endif; ?>
        </div>
    </div>
</div><?php /**PATH /Users/gilberto/Development/crm/grow/application/resources/views/landlord/team/table/table.blade.php ENDPATH**/ ?>