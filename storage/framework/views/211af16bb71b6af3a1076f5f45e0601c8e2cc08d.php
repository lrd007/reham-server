<div class="table-responsive">

    <!-- <input type="text" class="form-control pull-right " id="data_table_custom_search" name="data_table_custom_search" placeholder="Search here" style="width: 200px;position: absolute;right: 15px;height: 30px;"/> -->

    <!-- table table-centered table-nowrap table-hover mb-0 -->
    <table class="table dt-responsive nowrap w-100 mb-0 data-table" style="width:100%;" id="<?php echo e($table['id']); ?>" data-table-source="<?php echo e($table['source']); ?>" data-table-storage="" <?php echo array_key_exists('form',$table) ? 'data-form="' .$table['form'].'"' : ''; ?> <?php echo array_key_exists('disable-sorting', $table) ? 'data-disable-sorting="' . $table['disable-sorting'] . '"' : ''; ?> <?php if(isset( $table['sorting'] )): ?> <?php $__currentLoopData = $table['sorting']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php echo e(sprintf('%s=%s', $key, $value)); ?>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
        <?php if(isset($table['no-sort'])): ?>
        <?php echo e(sprintf('%s=%s', "sort-disable-columns", json_encode($table['no-sort']))); ?>

        <?php endif; ?>
        >
        <thead>
            <tr>
                <?php $__currentLoopData = $table['data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $col_head): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($col_head == __('Id') || $col_head == __('Created At') || $col_head == __('Action')): ?>
                <th style="min-width:100px;"><?php echo $col_head; ?></th>
                <?php else: ?>
                <th><?php echo $col_head; ?></th>
                <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tr>
    </table>
    <script>
        function copyToClipboard(url) {
            var TempText = document.createElement("input");
            TempText.value = url;
            document.body.appendChild(TempText);
            TempText.select();
            document.execCommand("copy");
            document.body.removeChild(TempText);
        }
    </script>
</div>

<?php /**PATH D:\Work Space\Reham\server\resources\views/layouts/shared/data-table.blade.php ENDPATH**/ ?>