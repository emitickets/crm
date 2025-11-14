<div class="card count-<?php echo e(@count($subscriptions)); ?>" id="subscriptions-table-wrapper">
    <div class="card-body">
        <div class="table-responsive list-table-wrapper">
            <?php if(@count($subscriptions) > 0): ?>
            <table id="subscriptions-list-table" class="table m-t-0 m-b-0 table-hover no-wrap subscription-list"
                data-page-size="10">
                <thead>
                    <tr>
                        <!--subscription_gateway_id-->
                        <th class="col_subscription_gateway_id"><a class="js-ajax-ux-request js-list-sorting"
                                id="sort_subscription_gateway_id" href="javascript:void(0)"
                                data-url="<?php echo e(urlResource('/subscriptions?action=sort&orderby=subscription_gateway_id&sortorder=asc')); ?>"><?php echo app('translator')->get('lang.id'); ?><span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>
                        <!--tenant_name-->
                        <th class="col_tenant_name"><a class="js-ajax-ux-request js-list-sorting" id="sort_tenant_name"
                                href="javascript:void(0)"
                                data-url="<?php echo e(urlResource('/subscriptions?action=sort&orderby=tenant_name&sortorder=asc')); ?>"><?php echo app('translator')->get('lang.customer'); ?><span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>

                        <!--subscription_amount-->
                        <th class="col_subscription_created"><a class="js-ajax-ux-request js-list-sorting"
                            id="sort_subscription_created" href="javascript:void(0)"
                            data-url="<?php echo e(urlResource('/subscriptions?action=sort&orderby=subscription_created&sortorder=asc')); ?>"><?php echo app('translator')->get('lang.created'); ?><span
                                class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>

                        <!--subscription_amount-->
                        <th class="col_subscription_amount"><a class="js-ajax-ux-request js-list-sorting"
                                id="sort_subscription_amount" href="javascript:void(0)"
                                data-url="<?php echo e(urlResource('/subscriptions?action=sort&orderby=subscription_amount&sortorder=asc')); ?>"><?php echo app('translator')->get('lang.amount'); ?><span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>

                        <!--subscription_date_renewed-->
                        <th class="col_subscription_date_renewed"><a class="js-ajax-ux-request js-list-sorting"
                                id="sort_subscription_date_renewed" href="javascript:void(0)"
                                data-url="<?php echo e(urlResource('/subscriptions?action=sort&orderby=subscription_date_renewed&sortorder=asc')); ?>"><?php echo app('translator')->get('lang.renewed'); ?><span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>
                        <!--subscription_gateway_billing_cycle-->
                        <th class="col_subscription_gateway_billing_cycle"><a class="js-ajax-ux-request js-list-sorting"
                                id="sort_subscription_gateway_billing_cycle" href="javascript:void(0)"
                                data-url="<?php echo e(urlResource('/subscriptions?action=sort&orderby=subscription_gateway_billing_cycle&sortorder=asc')); ?>"><?php echo app('translator')->get('lang.cycle'); ?><span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>
                        <!--subscription_status-->
                        <th class="col_subscription_status"><a class="js-ajax-ux-request js-list-sorting"
                                id="sort_subscription_status" href="javascript:void(0)"
                                data-url="<?php echo e(urlResource('/subscriptions?action=sort&orderby=subscription_status&sortorder=asc')); ?>"><?php echo app('translator')->get('lang.status'); ?><span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>
                        <!--subscription_gateway_name-->
                        <th class="col_subscription_gateway_name"><a class="js-ajax-ux-request js-list-sorting"
                                id="sort_subscription_gateway_name" href="javascript:void(0)"
                                data-url="<?php echo e(urlResource('/subscriptions?action=sort&orderby=subscription_gateway_name&sortorder=asc')); ?>"><?php echo app('translator')->get('lang.gateway'); ?><span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>
                        <!--actions-->
                        <th class="col_action"><a href="javascript:void(0)"><?php echo app('translator')->get('lang.action'); ?></a></th>
                    </tr>
                </thead>
                <tbody id="subscriptions-td-container">
                    <!--ajax content here-->
                    <?php echo $__env->make('landlord.subscriptions.table.ajax', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <!--ajax content here-->

                    <!--bulk actions - change category-->
                    <input type="hidden" name="checkbox_actions_subscriptions_category"
                        id="checkbox_actions_subscriptions_category">
                </tbody>
                <tsubscriptiont>
                    <tr>
                        <td colspan="20">
                            <!--load more button-->
                            <?php echo $__env->make('misc.load-more-button', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <!--load more button-->
                        </td>
                    </tr>
                </tsubscriptiont>
            </table>
            <?php endif; ?> <?php if(@count($subscriptions) == 0): ?>
            <!--nothing found-->
            <?php echo $__env->make('notifications.no-results-found', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <!--nothing found-->
            <?php endif; ?>
        </div>
    </div>
</div><?php /**PATH /Users/gbetus/Development/crm/grow/application/resources/views/landlord/subscriptions/table/table.blade.php ENDPATH**/ ?>