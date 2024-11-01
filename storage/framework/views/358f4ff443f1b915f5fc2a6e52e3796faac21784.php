<li class="side__item   <?php if(request()->routeIs('all_programs')): ?> heading --heading-active <?php endif; ?>">
    <a href="<?php echo e(route('all_programs')); ?>#programs">
        البرامج
    </a>
</li>
<li class="side__item according__list">
    <?php if(auth()->guard()->check()): ?>
        <?php
            $user = auth()->user();
             $ids = [];
        ?>
    <?php endif; ?>
    <div class="accordion accordion-flush" id="programes">
        <div class="accordion-item">
            <?php if(isset($user->subscriber)): ?>
                <?php $__currentLoopData = $user->subscriber->subscribePrograms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $program_data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(!in_array($program_data->program_id,$ids)): ?>
                        <?php
                            $program_id = $program_data->program_id;
                            array_push($ids, $program_id);
                            $program = Modules\Program\Entities\Program::find($program_id);

                            $program_name = $program ? $program->name_en : NULL;
                            if(Config::get('app.locale')=='ar'){
                                $program_name = $program ? $program->name_ar : NULL;
                            }
                        ?>

                        <?php if($program_name != NULL): ?>
                            <?php $__currentLoopData = $program->courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="flush-headingOne">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#programes-<?php echo e($course->id); ?>" aria-expanded="false"
                                                aria-controls="programes-<?php echo e($course->id); ?>">
                                            <?php echo e($program_name); ?>
                                        </button>
                                    </h2>
                                    <?php $__currentLoopData = $program->courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div id="programes-<?php echo e($course->id); ?>" class="accordion-collapse collapse"
                                            aria-labelledby="flush-headingOne"
                                            data-bs-parent="#programes">
                                            <div class="accordion-body">
                                                <div class="accordion accordion-flush" id="programe-<?php echo e($course->id); ?>">
                                                    <div class="accordion-item">
                                                        <?php
                                                            $course_name = $course->name_ar;
                                                        ?>
                                                        <h2 class="accordion-header" id="flush-headingOne">
                                                            <button class="accordion-button collapsed" type="button"
                                                                    data-bs-toggle="collapse"
                                                                    data-bs-target="#programeOnePartOne"
                                                                    aria-expanded="false"
                                                                    aria-controls="programeOnePartOne">
                                                                <?php echo e($course_name); ?>
                                                            </button>
                                                        </h2>

                                                        <div id="programeOnePartOne" class="accordion-collapse collapse"
                                                            aria-labelledby="flush-headingOne"
                                                            data-bs-parent="#programe-<?php echo e($course->id); ?>">
                                                            <div class="accordion-body">
                                                                <div class="accordion accordion-flush"
                                                                    id="programeOnePartOneLessones">
                                                                    <?php $__currentLoopData = $course->chapters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chapter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <?php
                                                                            $chapter_name = $chapter->name_en;
                                                                            if(Config::get('app.locale')=='ar'){
                                                                                $chapter_name = $chapter->name_ar;
                                                                            }
                                                                        ?>
                                                                        <div class="accordion-item lesson">
                                                                            <h2 class="accordion-header"
                                                                                id="flush-headingOne">
                                                                                <a href="<?php echo e(route('lesson-details',['program_id' => $program_id , 'course_id' => $course->id , 'chapter_id' => $chapter->id ])); ?>">
                                                                                <button class="accordion-button collapsed"
                                                                                        type="button"
                                                                                        data-bs-toggle="collapse"
                                                                                        data-bs-target="#flush-collapseOne"
                                                                                        aria-expanded="false"
                                                                                        aria-controls="flush-collapseOne">

                                                                                    <?php echo e($chapter_name); ?>

                                                                                </button>
                                                                                </a>
                                                                            </h2>
                                                                        </div>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </div>
    </div>
</li>
<?php /**PATH D:\Work Space\Reham\server\resources\views/website/static/programs_menu.blade.php ENDPATH**/ ?>