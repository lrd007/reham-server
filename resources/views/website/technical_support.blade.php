@include('website.static.navbar')

@auth()
    <div class="layout-main home-user-main">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <main>
                        <!-- ⭐⭐⭐⭐⭐ extra programes - 1 ⭐⭐⭐⭐⭐-->
                        <div class="extra-programes-1">
                            <div class="row">
                                <div class="col-12">
                                    <div class="programes-header">
                                        <div class="section-heading text-center">
                                            <h3 class="heading">
                                                الدعم الفني
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <!--Technical support Body-->
                                    <section class="Profile py-4" id="Profile">
                                        <div class="container px-2 px-md-auto ">
                                            <div class="row w-100  d-flex justify-content-center">
                                                <div class="col-12 w-100 ProfileForm  d-flex flex-column justify-content-center">
                                                    <form method="post" action="{{route('technical_support_post')}}">
                                                        @csrf
                                                        <div class="row mt-3">
                                                            <div class="col-12 px-3 mb-4">
                                                                <label for="Subject" class="form-label" style="color: #939597; font-size: 20px;"><b>
                                                                        العنوان</b></label>
                                                                <input type="text" class="form-control BTNDex2" id="Subject" aria-describedby="Subject" name="" required>
                                                            </div>
                                                            <div class="col-12 px-3 mb-4">
                                                                <label for="NewPassword" class="form-label" style="color: #939597;font-size: 20px;"><b>المحتوى</b></label>

                                                                <textarea name="message" id="Message" class="form-control BTNDex2" cols="30" rows="10" required></textarea>
                                                            </div>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary float-end BTNDex"><b>ارسال </b> </button>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                    <!--End Technical support Body-->
                                </div>
                            </div>
                        </div>
                        <!-- 🚫🚫🚫🚫 extra programes - 1 🚫🚫🚫🚫-->
                    </main>
                </div>
            </div>
        </div>
    </div>

@endauth


@include('website.static.footer')

