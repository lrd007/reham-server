@include('website.static.navbar')

@auth()
    <!-- ⭐⭐⭐⭐⭐ layout  ⭐⭐⭐⭐⭐-->
    <div class="layout-main">
        <div class="container-fluid">
            <div class="d-flex layout-row">

                <div class="layout-main courses-main">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <div class="notifications__list">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="header d-flex aling-items-center justify-content-between">
                                                    <p class="heading">الاشعارات</p>
                                                    <button class="clear__btn">
                                                        مسح الكل
                                                    </button>
                                                </div>
                                            </div>
                                            @if($notifications->count()>0)
                                                @foreach($notifications as $notification)
                                            <div class="col-12">
                                                <!-- ⚠️⚠️⚠️⚠️⚠️⚠️⚠️⚠️⚠️
                                                    ==> data-index of toggle__btn and id of according__body must have the same value
                                                ⚠️⚠️⚠️⚠️⚠️⚠️⚠️⚠️⚠️ -->
                                                <div class="notification__item">
                                                    <p class="notification__time">
                                                        {!!$notification->created_at!!}
                                                    </p>
                                                    <!-- id and  -->
                                                    <div class="notification__according">
                                                        <div class="according__title">
                                                            <button class="toggle__btn d-flex align-items-center toggle__according" data-index="according-{{$notification->id}}">
                                                                <i class="fa-solid fa-plus"></i>
                                                                <p>
                                                                    {{$notification->title}}
                                                                </p>
                                                            </button>
                                                        </div>
                                                        <div class="according__body" id="according-{{$notification->id}}">
                                                            <p>
                                                                {!!$notification->message!!}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- 🚫🚫🚫🚫  layout 🚫🚫🚫🚫-->

@endauth


@include('website.static.footer')
