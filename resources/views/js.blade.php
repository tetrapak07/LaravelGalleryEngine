<!-- Scripts -->
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>

<script type="text/javascript" src="/js/jquery.fancybox.pack.js"></script>

<script type="text/javascript" src="/js/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>


<script type="text/javascript">

    $(document).ready(function () {


        $(".various").fancybox({
            fitToView: false,
            autoSize: false,
            closeClick: false,
            openEffect: 'none',
            closeEffect: 'none',
            cyclic: false
        });

        $('[data-toggle="tooltip"]').tooltip();

        $(document).on("click", "#search", function () {

            var q = $('#this-search').val();
            console.log('q: ' + q);
            var page = $('#page').val();
            console.log('page: ' + page);
            var actionOld = $('#serch-form').attr('action');
            if (page >= 2) {
                var actionNew = actionOld + '/' + q + '/' + page;
            }
            else {
                var actionNew = actionOld + '/' + q;
            }

            $('#serch-form').attr('action', actionNew);
        });


        if (($(window).height() + 100) < $(document).height()) {
            $('#top-link-block').removeClass('hidden').affix({
                // how far to scroll down before link "slides" into view
                offset: {top: 100}
            });
        }

        var lastScrollTop = 0;
        $(window).scroll(function (event) {
            var st = $(this).scrollTop();
            if (st > lastScrollTop) {
                // downscroll code
                console.log('down');
                $('#top-link-block').show();
            }
            lastScrollTop = st;
        });

    });
</script>

