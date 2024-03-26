jQuery(document).ready(function ($) {
    $.ajaxSetup({

        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }

    });

    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))


    $('body').mousemove(function (event) {
        let x = event.pageX;
        let y = event.pageY;

        let x_move = 20 - x * 40 / $(window).width();
        let y_move = 10 - y * 20 / $(window).height();

        let style_text = 'translate3d(' + x_move + 'px, ' + y_move + 'px, 0)';

        $('.background_full').css('transform', style_text)


    });

    let $fixed_header_dark = $('#fixed-header-dark');
    let $sticky_content = $('.sticky-content');
    let $sticky_sidebar = $('.sticky-sidebar');

    $sticky_content.theiaStickySidebar({
        additionalMarginTop: 30
    });
    $sticky_sidebar.theiaStickySidebar({
        additionalMarginTop: 30
    });

    $('.menu-toggle').click(function (e) {
        // Find top parent element
        $(this).siblings('ul').toggle('down');
        if ($(this).parent().hasClass('open')) {
            $(this).parent().removeClass('open');
        } else {
            $(this).parent().addClass('open');
        }
    });
});


