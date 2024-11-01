<style>
    table {
       border-collapse: collapse;
    }
</style>
<table width="100%">
    <thead>
    <tr>
        <th style="background: #e1e1e1">{{ __('Name') }}</th>
        <th style="background: #e1e1e1">{{ __('Chapter') }}</th>
        <th style="background: #e1e1e1">{{ __('Lesson') }}</th>
        <th style="background: #e1e1e1">{{ __('Schedule On') }}</th>
        <th style="background: #e1e1e1">{{ __('Status') }}</th>
        <th style="background: #e1e1e1">{{ __('Created At') }}</th>
    </tr>
    </thead>
    <tbody>
        @foreach($quizzes as $quiz)
            <tr >
                <td>{{ $quiz->{'name' . withLocalization()} }}</td>
                <td>{{ $quiz->chapter->{'name' . withLocalization()} }}</td>
                <td>{{ $quiz->lesson->{'name' . withLocalization()} }}</td>
                <td>{{ showDateTime($quiz->schedule) }}</td>
                <td>{{ isActive($quiz->deleted_at, true) }}</td>
                <td>{{ showDateTime($quiz->created_at) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>