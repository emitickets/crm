<div class="row">
    <div class="col-lg-12">


        <!--customer-->
        <?php if(config('visibility.customer_dropdown')): ?>
        <div class="form-group row">
            <label
                class="col-sm-12 col-lg-3 text-left control-label col-form-label required"><?php echo app('translator')->get('lang.customer'); ?>*</label>
            <div class="col-sm-12 col-lg-9">
                <!--select2 basic search-->
                <select name="payment_tenant_id" id="payment_tenant_id"
                    class="form-control form-control-sm js-select2-basic-search select2-hidden-accessible"
                    data-ajax--url="<?php echo e(url('app-admin/feed/customers')); ?>"></select>
            </div>
        </div>
        <?php endif; ?>

        <!--customer id-->
        <?php if(config('visibility.customer_hidden_id')): ?>
        <input type="hidden" name="payment_tenant_id" value="<?php echo e(request('payment_tenant_id')); ?>">
        <?php endif; ?>

        <!--payment_amount-->
        <div class="form-group row">
            <label
                class="col-sm-12 col-lg-3 text-left control-label col-form-label required"><?php echo app('translator')->get('lang.amount'); ?>*</label>
            <div class="col-sm-12 col-lg-9">
                <input type="number" class="form-control form-control-sm" id="payment_amount" name="payment_amount"
                    value="<?php echo e($payment->payment_amount ?? ''); ?>">
            </div>
        </div>

        <!--date-->
        <div class="form-group row">
            <label
                class="col-sm-12 col-lg-3 text-left control-label col-form-label required"><?php echo app('translator')->get('lang.date'); ?>*</label>
            <div class="col-sm-12 col-lg-9">
                <input type="text" class="form-control form-control-sm pickadate" autocomplete="off" name="payment_date"
                    value="<?php echo e(runtimeDatepickerDate($payment->payment_date ?? '')); ?>">
                <input class="mysql-date" type="hidden" name="payment_date" id="payment_date"
                    value="<?php echo e($payment->payment_date ?? ''); ?>">
            </div>
        </div>


        <!--payment_gateway-->
        <div class="form-group row">
            <label
                class="col-sm-12 col-lg-3 text-left control-label col-form-label required"><?php echo app('translator')->get('lang.payment_method'); ?>*</label>
            <div class="col-sm-12 col-lg-9">
                <select class="select2-basic form-control form-control-sm select2-preselected" id="payment_gateway"
                    name="payment_gateway" data-preselected="<?php echo e($payment->payment_gateway ?? ''); ?>">
                    <option></option>
                    <option value="bank"><?php echo app('translator')->get('lang.bank'); ?></option>
                    <option value="stripe">Stripe</option>
                    <option value="paypal">Paypal</option>
                    <option value="paystack">Paystack</option>
                </select>
            </div>
        </div>


        <!--payment_transaction_id-->
        <div class="form-group row">
            <label
                class="col-sm-12 col-lg-3 text-left control-label col-form-label"><?php echo app('translator')->get('lang.transaction_id'); ?></label>
            <div class="col-sm-12 col-lg-9">
                <input type="text" class="form-control form-control-sm" id="payment_transaction_id"
                    name="payment_transaction_id" value="<?php echo e($payment->payment_transaction_id ?? ''); ?>">
            </div>
        </div>

        <div class="line"></div>

        <!--item-->
        <div class="form-group form-group-checkbox row">
            <label class="col-10 col-form-label text-left"><?php echo app('translator')->get('lang.update_subscription_status_due_dates'); ?></label>
            <div class="col-2 text-right p-t-5">
                <input type="checkbox" id="subscription_renewal_options" name="subscription_renewal_options" class="filled-in chk-col-light-blue">
                <label class="p-l-30" for="subscription_renewal_options"></label>
            </div>
        </div>

        <div class="modal-selector m-t-25 hidden" id="renewal_options_container">
            <!--subscription_status-->
            <div class="form-group row">
                <label
                    class="col-sm-12 col-lg-5 text-left control-label col-form-label"><?php echo app('translator')->get('lang.subscription_status'); ?></label>
                <div class="col-sm-12 col-lg-7">
                    <select class="select2-basic form-control form-control-sm select2-preselected" id="subscription_status"
                        name="subscription_status" data-preselected="active">
                        <option></option>
                        <option value="active" selected><?php echo app('translator')->get('lang.active'); ?></option>
                        <option value="awaiting-payment"><?php echo app('translator')->get('lang.awaiting_payment'); ?></option>
                        <option value="cancelled"><?php echo app('translator')->get('lang.cancelled'); ?></option>
                        <option value="failed"><?php echo app('translator')->get('lang.failed'); ?></option>
                        <option value="unchanged"><?php echo app('translator')->get('lang.unchanged'); ?></option>
                    </select>
                </div>
            </div>
            

            <!--next_billing_date-->
            <div class="form-group row">
                <label
                    class="col-sm-12 col-lg-5 text-left control-label col-form-label"><?php echo app('translator')->get('lang.next_renewal_date'); ?></label>
                <div class="col-sm-12 col-lg-7">
                    <select class="select2-basic form-control form-control-sm select2-preselected" id="subscription_renewal_period"
                        name="subscription_renewal_period"
                        data-preselected="<?php echo e($renewal_cycle); ?>"
                        data-date-week-mysql="<?php echo e($datepicker['one_week_from_today_mysql']); ?>"
                        data-date-week-picker="<?php echo e($datepicker['one_week_from_today_picker']); ?>"
                        data-date-month-mysql="<?php echo e($datepicker['one_month_from_today_mysql']); ?>"
                        data-date-month-picker="<?php echo e($datepicker['one_month_from_today_picker']); ?>"
                        data-date-year-mysql="<?php echo e($datepicker['one_year_from_today_mysql']); ?>"
                        data-date-year-picker="<?php echo e($datepicker['one_year_from_today_picker']); ?>">
                        <option></option>
                        <option value="one_week_from_today"><?php echo app('translator')->get('lang.one_week_from_today'); ?></option>
                        <option value="one_month_from_today"><?php echo app('translator')->get('lang.one_month_from_today'); ?></option>
                        <option value="one_year_from_today"><?php echo app('translator')->get('lang.one_year_from_today'); ?></option>
                        <option value="custom_date"><?php echo app('translator')->get('lang.custom_date'); ?></option>
                        <option value="unchanged"><?php echo app('translator')->get('lang.unchanged'); ?></option>
                    </select>
                </div>
            </div>

            <!--date-->
            <div class="form-group row">
                <label
                    class="col-sm-12 col-lg-5 text-left control-label col-form-label required"><?php echo app('translator')->get('lang.next_billing_date'); ?>*</label>
                <div class="col-sm-12 col-lg-7">
                    <input type="text" class="form-control form-control-sm pickadate" autocomplete="off"
                        name="subscription_renewal_date" id="subscription_renewal_pickadate" value="<?php echo e(runtimeDatepickerDate($renewal_date)); ?>">
                    <input class="mysql-date" type="hidden" name="subscription_renewal_date" id="subscription_renewal_date"
                        value="">
                </div>
            </div>
        </div>

        <!--notes-->
        <div class="row">
            <div class="col-12">
                <div><small><strong>* <?php echo e(cleanLang(__('lang.required'))); ?></strong></small></div>
            </div>
        </div>
    </div>
</div><?php /**PATH /Users/gilberto/Development/crm/grow/application/resources/views/landlord/payments/modals/add-edit-inc.blade.php ENDPATH**/ ?>