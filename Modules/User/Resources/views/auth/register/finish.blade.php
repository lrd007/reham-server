<div class="row">
    <div class="col-12">
        <div class="text-center">
            <h2 class="mt-0">
                <i class="mdi mdi-check-all"></i>
            </h2>
            @include('layouts.shared.notifications')
            <h3 class="mt-0">Thank you !</h3>
            <p class="w-75 mb-2 mx-auto">Your payment is successful, we will get back to you. Meanwhile you can track
                your application status through dashboard.</p>
        </div>
    </div>
    <!-- end col -->
</div>
<!-- end row -->
<ul class="list-inline wizard mb-0">
    <li class="next list-inline-item float-right">
        <a href="{{ route('user.login') }}" class="btn btn-secondary">Login to Parent Dashboard</a>
    </li>
</ul>
