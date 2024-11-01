<div class="table-responsive">

    <!-- <input type="text" class="form-control pull-right " id="data_table_custom_search" name="data_table_custom_search" placeholder="Search here" style="width: 200px;position: absolute;right: 15px;height: 30px;"/> -->

    <!-- table table-centered table-nowrap table-hover mb-0 -->
    <table class="table dt-responsive nowrap w-100 mb-0 data-table" style="width:100%;" id="{{ $table['id'] }}" data-table-source="{{ $table['source'] }}" data-table-storage="" {!! array_key_exists('form',$table) ? 'data-form="' .$table['form'].'"' : '' !!} {!! array_key_exists('disable-sorting', $table) ? 'data-disable-sorting="' . $table['disable-sorting'] . '"' : '' !!} @if(isset( $table['sorting'] )) @foreach($table['sorting'] as $key=> $value)
        {{ sprintf('%s=%s', $key, $value) }}
        @endforeach
        @endif
        @if(isset($table['no-sort']))
        {{ sprintf('%s=%s', "sort-disable-columns", json_encode($table['no-sort']))}}
        @endif
        >
        <thead>
            <tr>
                @foreach($table['data'] as $col_head)
                @if($col_head == __('Id') || $col_head == __('Created At') || $col_head == __('Action'))
                <th style="min-width:100px;">{!! $col_head !!}</th>
                @else
                <th>{!! $col_head !!}</th>
                @endif
                @endforeach
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

