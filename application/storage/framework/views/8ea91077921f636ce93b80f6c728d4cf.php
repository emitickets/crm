<div class="card count-<?php echo e(@count($payments)); ?>" id="payments-table-wrapper">
    <div class="card-body">
        <div class="table-responsive list-table-wrapper">
            <?php if(@count($payments) > 0): ?>
            <table id="payments-list-table" class="table m-t-0 m-b-0 table-hover no-wrap payment-list"
                data-page-size="10">
                <thead>
                    <tr>
                        <!--proof_date-->
                        <th class="col_proof_date"><a class="js-ajax-ux-request js-list-sorting" id="sort_proof_date"
                                href="javascript:void(0)"
                                data-url="<?php echo e(urlResource('/app-admin/offline-payments?action=sort&orderby=proof_date&sortorder=asc')); ?>"><?php echo app('translator')->get('lang.date'); ?><span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>

                        <!--tenant_name-->
                        <th class="col_tenant_name"><a class="js-ajax-ux-request js-list-sorting" id="sort_tenant_name"
                                href="javascript:void(0)"
                                data-url="<?php echo e(urlResource('/app-admin/offline-payments?action=sort&orderby=tenant_name&sortorder=asc')); ?>"><?php echo app('translator')->get('lang.customer'); ?><span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>

                        <!--tenant_domain-->
                        <th class="col_tenant_domain"><a href="javascript:void(0)"><?php echo app('translator')->get('lang.account'); ?></a></th>

                        <!--proof_amount-->
                        <th class="col_proof_amount"><a class="js-ajax-ux-request js-list-sorting"
                                id="sort_proof_amount" href="javascript:void(0)"
                                data-url="<?php echo e(urlResource('/app-admin/offline-payments?action=sort&orderby=proof_amount&sortorder=asc')); ?>"><?php echo app('translator')->get('lang.amount'); ?><span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>
                        <!--proof_filename-->
                        <th class="col_proof_filename"><a href="javascript:void(0)"><?php echo app('translator')->get('lang.attachment'); ?></a></th>

                        <!--actions-->
                        <th class="col_action"><a href="javascript:void(0)"><?php echo app('translator')->get('lang.action'); ?></a></th>
                    </tr>
                </thead>
                <tbody id="payments-td-container">
                    <!--ajax content here-->
                    <?php echo $__env->make('landlord.offlinepayments.table.ajax', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <!--ajax content here-->
                </tbody>
                <tpaymentt>
                    <tr>
                        <td colspan="20">
                            <!--load more button-->
                            <?php echo $__env->make('misc.load-more-button', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <!--load more button-->
                        </td>
                    </tr>
                </tpaymentt>
            </table>
            <?php endif; ?> <?php if(@count($payments) == 0): ?>
            <!--nothing found-->
            <?php echo $__env->make('notifications.no-results-found', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <!--nothing found-->
            <?php endif; ?>
        </div>
    </div>
</div><?php /**PATH /Users/gbetus/Development/crm/grow/application/resources/views/landlord/offlinepayments/table/table.blade.php ENDPATH**/ ?>