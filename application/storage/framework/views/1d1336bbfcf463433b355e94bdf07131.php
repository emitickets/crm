<div class="card count-<?php echo e(@count($payments)); ?>" id="payments-table-wrapper">
    <div class="card-body">
        <div class="table-responsive list-table-wrapper">
            <?php if(@count($payments) > 0): ?>
            <table id="payments-list-table" class="table m-t-0 m-b-0 table-hover no-wrap payment-list"
                data-page-size="10">
                <thead>
                    <tr>
                        <!--payment_id-->
                        <th class="col_payment_id"><a class="js-ajax-ux-request js-list-sorting" id="sort_payment_id"
                                href="javascript:void(0)"
                                data-url="<?php echo e(urlResource('/payments?action=sort&orderby=payment_id&sortorder=asc')); ?>"><?php echo app('translator')->get('lang.id'); ?><span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>
                        <!--tenant_name-->
                        <?php if(config('visibility.col_tenant_name')): ?>
                        <th class="col_tenant_name"><a class="js-ajax-ux-request js-list-sorting" id="sort_tenant_name"
                                href="javascript:void(0)"
                                data-url="<?php echo e(urlResource('/payments?action=sort&orderby=tenant_name&sortorder=asc')); ?>"><?php echo app('translator')->get('lang.customer'); ?><span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>
                        <?php endif; ?>
                        <!--payment_created-->
                        <th class="col_payment_created"><a class="js-ajax-ux-request js-list-sorting"
                                id="sort_payment_created" href="javascript:void(0)"
                                data-url="<?php echo e(urlResource('/payments?action=sort&orderby=payment_created&sortorder=asc')); ?>"><?php echo app('translator')->get('lang.date'); ?><span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>
                        <!--payment_transaction_id-->
                        <th class="col_payment_transaction_id"><a class="js-ajax-ux-request js-list-sorting"
                                id="sort_payment_transaction_id" href="javascript:void(0)"
                                data-url="<?php echo e(urlResource('/payments?action=sort&orderby=payment_transaction_id&sortorder=asc')); ?>"><?php echo app('translator')->get('lang.transaction_id'); ?><span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>
                        <!--payment_amount-->
                        <th class="col_payment_amount"><a class="js-ajax-ux-request js-list-sorting"
                                id="sort_payment_amount" href="javascript:void(0)"
                                data-url="<?php echo e(urlResource('/payments?action=sort&orderby=payment_amount&sortorder=asc')); ?>"><?php echo app('translator')->get('lang.amount'); ?><span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>
                        <!--payment_gateway-->
                        <?php if(config('visibility.col_payment_gateway')): ?>
                        <th class="col_payment_gateway"><a class="js-ajax-ux-request js-list-sorting"
                                id="sort_payment_gateway" href="javascript:void(0)"
                                data-url="<?php echo e(urlResource('/payments?action=sort&orderby=payment_gateway&sortorder=asc')); ?>"><?php echo app('translator')->get('lang.gateway'); ?><span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>
                        <?php endif; ?>
                        <!--actions-->
                        <th class="col_action"><a href="javascript:void(0)"><?php echo app('translator')->get('lang.action'); ?></a></th>
                    </tr>
                </thead>
                <tbody id="payments-td-container">
                    <!--ajax content here-->
                    <?php echo $__env->make('landlord.payments.table.ajax', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <!--ajax content here-->

                    <!--bulk actions - change category-->
                    <input type="hidden" name="checkbox_actions_payments_category"
                        id="checkbox_actions_payments_category">
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
</div><?php /**PATH /Users/gilberto/Development/crm/grow/application/resources/views/landlord/payments/table/table.blade.php ENDPATH**/ ?>