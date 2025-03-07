<!--first_name-->
<div class="form-group row">
    <label class="col-sm-12 text-left control-label col-form-label required"><?php echo app('translator')->get('lang.first_name'); ?></label>
    <div class="col-sm-12">
        <input type="text" class="form-control form-control-sm" id="first_name" name="first_name"
            value="<?php echo e($user->first_name ?? ''); ?>">
    </div>
</div>

<!--last_name-->
<div class="form-group row">
    <label class="col-sm-12 text-left control-label col-form-label required"><?php echo app('translator')->get('lang.last_name'); ?></label>
    <div class="col-sm-12">
        <input type="text" class="form-control form-control-sm" id="last_name" name="last_name"
            value="<?php echo e($user->last_name ?? ''); ?>">
    </div>
</div>


<!--email-->
<div class="form-group row">
    <label class="col-sm-12 text-left control-label col-form-label required"><?php echo app('translator')->get('lang.last_name'); ?></label>
    <div class="col-sm-12">
        <input type="text" class="form-control form-control-sm" id="email" name="email"
            value="<?php echo e($user->email ?? ''); ?>">
    </div>
</div>

<div class="line"></div>

<!--password-->
<div class="form-group row">
    <label class="col-sm-12 text-left control-label col-form-label required"><?php echo app('translator')->get('lang.password'); ?> (<?php echo app('translator')->get('lang.optional'); ?>)</label>
    <div class="col-sm-12">
        <input type="password" class="form-control form-control-sm" id="password" name="password"
            value="">
    </div>
</div><?php /**PATH /Users/gilberto/Development/crm/grow/application/resources/views/landlord/profile/edit.blade.php ENDPATH**/ ?>