@include('website.static.navbar')

@auth
    @if (count($cart_item) > 0)

        <!-- ❗⚠️⚠️⚠️⚠️⚠️⚠️⚠️❗❗❗❗ cart empty -->
        <!-- ❕❕❕❕❕❕cart❕❕❕❕❕❕ -->
        <!--⚠️❗⚠️❗ if cart empty toggle calss 'd-none'⚠️❗⚠️❗ -->
        <div class="cart__list ">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="cart__header d-flex align-items-center">
                            <i class="fa-solid fa-cart-shopping"></i>
                            <div class="heading">
                                <h4>
                                    العربة
                                </h4>
                                <p class="pro__number">
                                    {{ count($cart_item) }} عناصر الطلب
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">

                        <div class="cart__items">
                            <div class="row">

                                @php
                                    $discount = $total_without_discount =0;
                                @endphp
                                @foreach ($cart_item as $key => $item)
                                @php
                                    $amount = 0;
                                    $amount += $item->courseFees()->pluck('sale_fee')->first();
                                    $discount += $item->courseFees()->pluck('fee')->first();
                                    $course_name = $item->name_ar;
                                    $description = $item->description_ar;

                                @endphp

                                <div class="col-md-6">
                                    <div class="cart__item d-flex flex-column">
                                        <a href="{{ route('remove_cart', ['program_id' => $item->id]) }}" disabled="disabled">
                                            <i class="fa-solid fa-trash-can-arrow-up"></i>
                                        </a>
                                        <div class="item__bottom">
                                            <div class="item__header d-flex align-items-center ">
                                                <p class="item__title">
                                                    {{ $course_name }}
                                                </p>
                                                <div class="star__icons d-flex align-items-center">
                                                    <i class="fa-solid fa-star"></i>
                                                    <i class="fa-solid fa-star"></i>
                                                    <i class="fa-solid fa-star"></i>
                                                    <i class="fa-solid fa-star"></i>
                                                    <i class="fa-solid fa-star"></i>
                                                </div>
                                            </div>
                                            {{--<div class="item__description">
                                                <p>أمسية قانون الانعكاس</p>
                                            </div>--}}
                                            <div class="item__price  d-flex align-items-center">
                                                <p class="dashed">{{$item->courseFees()->pluck('fee')->first()}} دينار كويتي</p>
                                                <p class="now"> {{$amount}}   دينار كويتي </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach

                            </div>

                        </div>
                    </div>
                    <div class="col-12">
                        <div class="order__summary d-flex flex-column">
                            <h4 class="order__header">
                                ملخص الطلب
                            </h4>
                            <div class="sub__heading d-flex align-items-center justify-content-between">
                                <p>العدد</p>
                                <p>{{ count($cart_item) }}</p>
                            </div>
                            <hr />
                            <form class="order__form d-flex flex-column"  action="{{route('check-payment-method')}}" method="post">
                                @csrf
                                @php
                                    $total_amount = 0;
                                @endphp
                                @foreach ($cart_item as $key => $item)
                                    @php
                                        $amount = 0;
                                        $amount += $item->courseFees()->pluck('sale_fee')->first();
                                        $total_amount += $amount;
                                    @endphp
                                    <input type="hidden" name="program_id[{{$key}}]" value="{{$item->programs_id}}">
                                    <input type="hidden" name="courses[]" value="{{ $item->id }}">
                                @endforeach

                               <div class="input__top d-flex align-items-center justify-content-between">
                                    <input type="text" class="input__code" disabled placeholder="رمز الخصم">
                                    <input type="submit" disabled value="تفعيل" class="input__submit">
                                </div>
                                <div class="order__detail d-flex align-items-center justify-content-between">
                                    <p>المجموع</p>
                                    <p>{{$total_amount}} دينار كويتي </p>
                                </div>
                                <div class="order__detail d-flex align-items-center justify-content-between">
                                    <p>مبلغ الخصم</p>
                                    <p>{{$discount}}دينار كويتي </p>
                                </div>
                                <hr />
                                <div class="order__detail d-flex align-items-center justify-content-between">
                                    <p>المجموع الكلي</p>
                                    <p>{{$total_amount}} دينار كويتي </p>
                                </div>
                                <div class="input__container d-flex align-items-center">
                                    <input type="radio" name="payment_type" id="1" value="myfatoorah">
                                    <label for="1">كي-نت</label>
                                </div>
                                <div class="input__container d-flex align-items-center">
                                    <input type="radio" name="payment_type" id="2" value="myfatoorah">
                                    <label for="2">
                                        بطاقة الائتمان
                                    </label>
                                </div>
                                <div class="input__container d-flex align-items-center">
                                    <input type="radio" name="payment_type" id="3" value="paypal" checked>
                                    <label for="3">
                                        باي بال - Paypal
                                        ({{ round(($total_amount / 3.27047619047619),2) }} USD)
                                    </label>
                                </div>
                                <div class="input__container ">
                                    <input type="submit" value="الدفع">
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ❗❗❗❗❗❗cart❗❗❗❗❗❗ -->

    @else

        <!--⚠️❗⚠️❗ if cart have items toggle calss 'd-none'⚠️❗⚠️❗ -->
        <!-- ❗⚠️⚠️⚠️⚠️⚠️⚠️⚠️❗❗❗❗ cart empty -->
        <div class="cart__empty d-none ">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-10 d-flex flex-column align-items-center justify-content-center">
                        <div class="cart__card d-flex flex-column align-items-center justify-content-center">
                            <i class="fa-solid fa-cart-shopping"></i>
                            <p>{{ __('words.Your cart is empty') }}</p>
                            <a class="" href="{{ route('index') }}">{{ __('words.Shop Now') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endif

@endauth

@include('website.static.footer')
