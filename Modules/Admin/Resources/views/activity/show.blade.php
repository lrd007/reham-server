<style>
    td{
        word-break: break-all;
    }
</style>
<div class="modal-header bg-light">
    <h4 class="modal-title" >Audit Log</h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body p-4">
    <label class="m-0">{{ $userActivity->activity }}</label>
    <hr>
    <div class="row">
        <div class="col-sm-8">
            <label >{{ __('Activity By') }}</label>
            <p><span class="font-weight-bold text-success">{{ @$userActivity->user->name }}</span>
        </div>
        <div class="col-sm-4">
            <label >{{ __('Activity Time') }}</label>
            <p class="font-weight-bold text-primary">{{ showDateTime($userActivity->created_at) }}</p>
        </div>
    </div>    
    @if($input)
        <hr class="mt-1">
        <label>Input</label>
        <table class="table table-hover table-bordered table-sm">
            <tr>
                <th>Field</th>
                <th>Value</th>
            </tr>
            @foreach($input as $key => $value)
                <tr>
                    <td>{{ ucfirst(str_replace('_', ' ', $key)) }}</td>
                    <td>{{ is_array($value) ? implode(", ",$value) : $value }}</td>
                </tr>
            @endforeach
        </table>
    @endif
</div>