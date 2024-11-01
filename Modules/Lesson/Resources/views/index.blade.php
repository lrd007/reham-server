
@extends('layouts.vertical', ['title' => __('Lesson')])
@section('css')
    <link href="{{asset('assets/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">{{ __('Lesson') }}</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    @can('lesson.create')
                        <div class="row d-flex flex-row-reverse mb-2">
                            <div class="col-auto">
                                <button class="btn btn-secondary modal-button" type="button" data-url="{{ route('lesson.list.filter') }}" data-toggle="modal">{{ __('Filter') }}</button>
                                <a class="btn btn-primary waves-effect waves-light text-right" href="{{ route('lesson.create') }}" >{{ __('Add New') }}</a>
                            </div>
                        </div>
                        <hr>
                    @endcan
                    @include('layouts.shared/data-table')
                </div>
            </div>
        </div>
        
    </div>
@endsection
@section('script')
    <script src="{{asset('assets/libs/select2/select2.min.js')}}"></script>
    <script>

        $(document).on("change", "#program", function () {
            $id = $(this).val();
            $("#course").prop("disabled", true);
            $.ajax({
                type: "GET",
                url: $baseUrl + "/course-by-program-ids?program_ids=" + $id,
                dataType: "json",
                success: function (response) {
                    $row = '<option value=""></option>';
                    $teachers = "";
                    if ((response.status = "success")) {
                        if (response.courses) {
                            $.each(response.courses, function (index, course) {
                                $row +=
                                    '<option value="' +
                                    course.id +
                                    '">' +
                                    course.name +
                                    "</option >";
                            });
                        }

                        $("#course").html($row), $("#course").prop("disabled", false);
                    }
                },
                error: function (error) {
                    errorHandler(error);
                },
            });
        });

        $(document).on("change", "#course", function () {
            $id = $(this).val();
            $("#chapter").prop("disabled", true);
            $.ajax({
                type: "GET",
                url: $baseUrl + "/chapter-by-course-ids?course_ids=" + $id,
                dataType: "json",
                success: function (response) {
                    $row = '<option value=""></option>';
                    $teachers = "";
                    if ((response.status = "success")) {
                        if (response.chapters) {
                            $.each(response.chapters, function (index, chapter) {
                                $row +=
                                    '<option value="' +
                                    chapter.id +
                                    '">' +
                                    chapter.name +
                                    "</option >";
                            });
                        }

                        $("#chapter").html($row), $("#chapter").prop("disabled", false);
                    }
                },
                error: function (error) {
                    errorHandler(error);
                },
            });
        });
    </script>
@endsection