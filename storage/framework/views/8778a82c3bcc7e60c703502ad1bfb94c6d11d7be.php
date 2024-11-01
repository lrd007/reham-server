<?php $__env->startSection('content'); ?>
    <!-- Start Content-->
    <div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title"><?php echo e(__('My Profile')); ?></h4>
            </div>
        </div>
    </div>

    <div class="row d-flex justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div id="registerWizard">
                        <ul class="nav nav-pills bg-light nav-justified form-wizard-header mb-3">
                            <li class="nav-item" data-target-form="#accountForm">
                                <a href="#first" data-toggle="tab" class="nav-link rounded-0 pt-2 pb-2">
                                    <span class="d-none d-sm-inline"><?php echo e(__('Profile')); ?></span>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content mb-0 b-0 pt-0">
                            <div class="tab-pane active" id="first">
                                <form action="<?php echo e($action); ?>" method="post">
                                    <?php echo e(csrf_field()); ?>

                                    <?php echo e(method_field('PUT')); ?>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="form-label"><?php echo e(__('Name')); ?></label><span class="text-danger">*</span>
                                                <input type="text" name="name" class="form-control" placeholder="<?php echo e(__('Name')); ?>" value="<?php echo e(@$admin->name); ?>" required />
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="form-label"><?php echo e(__('Email')); ?></label><span class="text-danger">*</span>
                                                <input type="text" name="email" class="form-control" placeholder="<?php echo e(__('Email')); ?>" value="<?php echo e(@$admin->email); ?>" required />
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <ul class="nav nav-pills bg-light nav-justified form-wizard-header mb-3 mt-3">
                                        <li class="nav-item" data-target-form="#accountForm">
                                            <a href="#first" data-toggle="tab" class="nav-link rounded-0 pt-2 pb-2">
                                                <span class="d-none d-sm-inline"><?php echo e(__('Update Password')); ?></span>
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="form-label"><?php echo e(__('Current Password')); ?></label>
                                                <input type="password" name="current_password" class="form-control" placeholder="<?php echo e(__('Current Password')); ?>" required />
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="form-label"><?php echo e(__('New Password')); ?></label>
                                                <input type="password" name="password" class="form-control" placeholder="<?php echo e(__('New Password')); ?>" required />
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="text-right">
                                        <button type="button" class="global-save btn btn-primary waves-effect waves-light"><?php echo e(__('Save')); ?></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
    
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.vertical', ['title' => __('My Profile')], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Work Space\Reham\server\Modules/Admin\Resources/views/profile.blade.php ENDPATH**/ ?>