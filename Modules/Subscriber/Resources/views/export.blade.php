<style>
    table {
       border-collapse: collapse;
    }
</style>
<table width="100%">
    <thead>
        <tr>
            <td colspan="8" style="background: #d9d9d9bf;">                
                <b>{{ __('Subscriber') }}</b>
            </td>
        </tr>
        <tr>
            <td style="background: #e1efff;"><b>{{ __('Id') }}</b></td>
            <td style="background: #e1efff;"><b>{{ __('Name') }}</b></td>
            <td style="background: #e1efff;"><b>{{ __('Email') }}</b></td>
            <td style="background: #e1efff;"><b>{{ __('Mobile No') }}</b></td>
            <td style="background: #e1efff;"><b>{{ __('Country') }}</b></td>
            <td style="background: #e1efff;"><b>{{ __('Is Premium') }}</b></td>
            <td style="background: #e1efff;"><b>{{ __('Created At') }}</b></td>
            <td style="background: #e1efff;"><b>{{ __('Status') }}</b></td>
        </tr>
    </thead>
    <tbody>
        @foreach($subscribers as $subscriber)
            <tr >
                <td>{{ @$subscriber->id }} </td>
                <td>{{ @$subscriber->user->name }} </td>
                <td>{{ @$subscriber->user->email }} </td>
                <td>{{ @$subscriber->mobile_no }}</td>
                <td>{{ @$subscriber->country->name }}</td>
                <td>{{ @$subscriber->is_premium ? __('Yes') : __('No') }}</td>
                <td>{{ showDate($subscriber->created_at) }}</td>
                <td>{{ isActive($subscriber->deleted_at, true) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>