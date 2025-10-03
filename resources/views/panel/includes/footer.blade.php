<!--Footer area end-->
    <!-- === jqyery === -->
    <script src="{{ asset('js/panel/jquery.min.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- === bootsrap-min === -->
    <script src="{{ asset('js/panel/bootstrap.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- === Scroll up min js === -->
    <script src="{{ asset('js/panel/jquery.scrollUp.min.js') }}"></script> 
    <!-- === Price slider js === -->
    <script src="{{ asset('js/panel/jquery-price-slider.js') }}"></script>
    <!-- === Counter up js === -->
    <script src="{{ asset('js/panel/jquery.counterup.min.js') }}"></script>
    <!-- === Waypoint js === -->
    <script src="{{ asset('js/panel/jquery.waypoints.js') }}"></script>
    <!-- === Venobox js === -->
    <script src="{{ asset('js/panel/venobox.min.js') }}"></script>
    <!-- === ZOOM  js === -->
    <script src="{{ asset('js/panel/jquery.elevatezoom.js') }}"></script>
    <!-- === filterizr filter  js === -->
    <script src="{{ asset('js/panel/jquery.filterizr.min.js') }}"></script>
    <!-- === Owl Carousel js === -->
    <script src="{{ asset('js/panel/owl.carousel.min.js') }}"></script>
    <!-- === WOW js === -->
    <script src="{{ asset('js/panel/wow.js') }}"></script>
    <!-- === Coundown js === -->
    <script src="{{ asset('js/panel/jquery.countdown.min.js') }}"></script>
    <!-- === Image loaded js === -->
    <script src="{{ asset('js/panel/imageloaded.pkgd.min.js') }}"></script>
    <!-- === Mailchimp integration js === -->
    <script src="{{ asset('js/panel/mailchimp.js') }}"></script>
    <!-- === Mobile menu  js === -->
    <script src="{{ asset('js/panel/mobile-menu.js') }}"></script>
    <!-- === Main  js === -->
    <script src="{{ asset('js/panel/main.js') }}"></script>

<script>
        $(document).ready(function() {
            $('#gallery').imagesLoaded(function() {
                var filterizd = $('.filtr-container').filterizr({});
                $('.filters .filtr').click(function() {
                    $('.filters .filtr').removeClass('filtr-active');
                    $(this).addClass('filtr-active');
                });
            });
        });    
</script>