<?php $__env->startSection('css'); ?>
    <!-- Plugins css -->
    <link href="<?php echo e(asset('assets/libs/flatpickr/flatpickr.min.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('assets/libs/selectize/selectize.min.css')); ?>" rel="stylesheet" type="text/css" />
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script>

        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = false;

        var pusher = new Pusher('de6b58b8671fceb32c44', {
            cluster: 'ap2'
        });

        var privateChannel = pusher.subscribe("my-channel");
        privateChannel.bind('my-event', function(data) {
            alert(JSON.stringify(data));
        });
  </script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <!-- Start Content-->
    <div class="container-fluid">
    
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title"><?php echo e(__('Dashboard')); ?></h4>
                </div>
            </div>
        </div>     
        <!-- end page title --> 
        <input type="hidden" id="token" value="<?php echo e(csrf_token()); ?>">

        <div class="row">
            <div class="col-md-3">
                <div class="widget-rounded-circle card-box">
                    <div class="row">
                        <div class="col-5">
                            <!-- <div class="avatar-lg rounded-circle bg-soft-warning border-warning border">
                                <i class="mdi mdi-account-tie font-22 avatar-title text-warning"></i>
                            </div> -->
                            <img class="img-fluid" src="<?php echo e(asset('assets/images/reham-favicon.png')); ?>" width="60px" height="60px"/>
                        </div>
                        <div class="col-7">
                            <div class="text-right">
                                <h3 class="mt-1"><span><?php echo e(__('Admin')); ?></span></h3>
                                <a href="<?php echo e(route('admin-user.index')); ?>" class="text-muted mb-1 text-truncate"><?php echo e(__('View All')); ?></a>
                            </div>
                        </div>
                    </div> <!-- end row-->
                </div> <!-- end widget-rounded-circle-->
            </div> <!-- end col-->

            <div class="col-md-3">
                <div class="widget-rounded-circle card-box">
                    <div class="row">
                        <div class="col-5">
                            <!-- <div class="avatar-lg rounded-circle bg-soft-primary border-primary border">
                                <i class="mdi mdi-account-tie font-22 avatar-title text-primary"></i>
                            </div> -->
                            <img class="img-fluid" src="<?php echo e(asset('assets/images/reham-favicon.png')); ?>" width="60px" height="60px"/>
                        </div>
                        <div class="col-7">
                            <div class="text-right">
                                <h3 class="text-dark mt-1"><span><?php echo e(__('Subscribers')); ?></span></h3>
                                <a href="<?php echo e(route('subscriber.index')); ?>" class="text-muted mb-1 text-truncate"><?php echo e(__('View All')); ?></a>
                            </div>
                        </div>
                    </div> <!-- end row-->
                </div> <!-- end widget-rounded-circle-->
            </div> <!-- end col-->
        </div>
        <!-- end row-->
        
    </div> <!-- container -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <!-- Plugins js-->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.vertical', ['title' => __('Dashboard')], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Work Space\Reham\server\Modules/Admin\Resources/views/dashboard.blade.php ENDPATH**/ ?>