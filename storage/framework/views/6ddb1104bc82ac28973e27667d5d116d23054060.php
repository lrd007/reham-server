<?php if(auth()->guard()->check()): ?>
    </div>
</div>
</div>
<!-- 🚫🚫🚫🚫  layout 🚫🚫🚫🚫-->




</div>
        </div>
    </div>
</div>
<!-- 🚫🚫🚫🚫  layout 🚫🚫🚫🚫-->
<?php endif; ?>

<!-- ⭐⭐⭐⭐⭐ footer ⭐⭐⭐⭐⭐-->
<footer class="footer__main">
    <div class="container">
        <div class="row">
            <div class="col-md-6 footer-right d-flex align-items-center">
                <div class="footer__logo">
                    <img src="<?php echo e(asset('assets/dexter/src/images/reham-logo-arabic-white.png')); ?>" class="img-fluid" alt="logo">
                </div>
                <p class="copy-right">
                    جميع الحقوق محفوظة
                    Reham © <?php echo e(date('Y')); ?> &nbsp;
                    <script>
                        document.write(new Date().getFullYear());
                    </script> &copy; Powered By <a class="text-decoration-none text-white" href="https://reham.com">Reham House</a>>
                </p>
            </div>
            <div class="col-md-6 footer-left d-flex justify-content-end">
                <ul class="list-unstyled footer__items cen-row">
                    <li class="footer__item">
                        <a href="<?php echo e(route('legal_faq')); ?>" class="footer__link">
                            سياسية الخصوصية
                        </a>
                    </li>
                    <li class="footer__item">
                        <a href="<?php echo e(route('faq')); ?>" class="footer__link">
                            الشروط والاحكام
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>
<!-- 🚫🚫🚫🚫 footer 🚫🚫🚫🚫-->

<!-- sidebar main -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="<?php echo e(asset('assets/dexter/javascript/components/sidebar-main.js')); ?>"></script>
<script src="<?php echo e(asset('assets/dexter/javascript/bootstrap.bundle.js')); ?>" ></script>
<script src="<?php echo e(asset('assets/dexter/javascript/bootstrap.js')); ?>" ></script>
<script src="<?php echo e(asset('assets/dexter/javascript/according.js')); ?>"  ></script>
</body>
</html>
<?php /**PATH D:\Work Space\Reham\server\resources\views/website/static/footer.blade.php ENDPATH**/ ?>