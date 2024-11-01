<div class="modal-header bg-light">
    <h4 class="modal-title" >{{ $program->{'name' . withLocalization()} }}</h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body p-4">    
        @if($program->courses->count())
            <ul >
                @foreach($program->courses as $course)
                    <li class="mb-2" style="list-style: decimal;">
                        <div class="mb-2">
                            <a href="{{ route('course.edit', $course->id) }}" target="_blank" class="navigation" style="font-size:19px; font-weight:600; color: #6e768e;">{{ $course->{'name' . withLocalization()} }}</a>
                        </div>
                        <ul>
                            @foreach($course->chapters as $chapter)
                                <li style="list-style: decimal;">
                                    <div class="my-2">
                                        <a href="{{ route('chapter.edit', $chapter->id) }}" target="_blank" class="navigation" style="font-size:19px; color: #6e768e;">{{ $chapter->{'name' . withLocalization()} }}</a>
                                    </div>
                                    <ul>
                                        @foreach($chapter->lessons as $lesson)
                                            <li style="list-style: decimal;">
                                                <div class="my-2" >
                                                    <a href="{{ route('lesson.edit', $lesson->id) }}" target="_blank" class="navigation" style="font-size:17px; color: #6e768e;">{{ $lesson->{'name' . withLocalization()} }}</a>
                                                    @if ($lesson->lessonCompletedForAdmin != NULL)
                                                        <button class="btn pull-right">Done</button>
                                                    @endif
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-center">{{ __('No course available in this program.') }}</p>
        @endif    
</div>