jQuery(document).ready(function ($) {
    $.ajaxSetup({

        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }

    });

    const layoutMenu = document.getElementById('layout-menu');
    const layoutMenuToggle = document.querySelector('.layout-menu-toggle');
    const layoutPage = document.querySelector('.layout-page');

    layoutMenuToggle.addEventListener('click', function() {
        layoutMenu.classList.toggle('open_menu_side');
        layoutPage.classList.toggle('opened_menu_background');
    });

    document.addEventListener('click', function(event) {
        if (!layoutMenu.contains(event.target) && !layoutMenuToggle.contains(event.target)) {
            layoutMenu.classList.remove('open_menu_side');
            layoutPage.classList.remove('opened_menu_background');
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


    let number_inputs = $('.number_format_input');

    number_inputs.each(function (key, item) {
        check_input_format(item);
    });

    jQuery(document).on('keyup', '.number_format_input', function (e) {
        check_input_format(this);
    });

    function check_input_format(item) {
        let x = item.value.replaceAll(/[^0-9]/g, '');
        if (x) {
            x = Intl.NumberFormat("en-US", {maximumFractionDigits: 6}).format(Number(x).toFixed(0));
        }
        item.value = x;
        item.dispatchEvent(new Event('input'))

    }

});


