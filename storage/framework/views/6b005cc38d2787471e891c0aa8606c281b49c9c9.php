<div class="modal-header bg-light">
    <h4 class="modal-title" ><?php echo e($program->{'name' . withLocalization()}); ?></h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body p-4">    
        <?php if($program->courses->count()): ?>
            <ul >
                <?php $__currentLoopData = $program->courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="mb-2" style="list-style: decimal;">
                        <div class="mb-2">
                            <a href="<?php echo e(route('course.edit', $course->id)); ?>" target="_blank" class="navigation" style="font-size:19px; font-weight:600; color: #6e768e;"><?php echo e($course->{'name' . withLocalization()}); ?></a>
                        </div>
                        <ul>
                            <?php $__currentLoopData = $course->chapters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chapter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li style="list-style: decimal;">
                                    <div class="my-2">
                                        <a href="<?php echo e(route('chapter.edit', $chapter->id)); ?>" target="_blank" class="navigation" style="font-size:19px; color: #6e768e;"><?php echo e($chapter->{'name' . withLocalization()}); ?></a>
                                    </div>
                                    <ul>
                                        <?php $__currentLoopData = $chapter->lessons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lesson): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li style="list-style: decimal;">
                                                <div class="my-2" >
                                                    <a href="<?php echo e(route('lesson.edit', $lesson->id)); ?>" target="_blank" class="navigation" style="font-size:17px; color: #6e768e;"><?php echo e($lesson->{'name' . withLocalization()}); ?></a>
                                                    <?php if($lesson->lessonCompletedForAdmin != NULL): ?>
                                                        <button class="btn pull-right">Done</button>
                                                    <?php endif; ?>
                                                </div>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        <?php else: ?>
            <p class="text-center"><?php echo e(__('No course available in this program.')); ?></p>
        <?php endif; ?>    
</div><?php /**PATH D:\Work Space\Reham\server\Modules/Program\Resources/views/hierarchy.blade.php ENDPATH**/ ?>