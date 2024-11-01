@extends('layouts.vertical', ['title' => __('Subscriber')])

@section('css')
    <!-- Plugins css -->
    <link href="{{asset('assets/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">{{ __('Subscriber View') }}</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    @if($data && $data->subscribePrograms)
                        @foreach ($data->subscribePrograms as $subscribePrograms)
                            <li>{{$subscribePrograms->program->name_en}}</li>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
