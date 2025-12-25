/* Customizer Live Preview JavaScript */
(function($) {
    'use strict';

    // Primary Color
    wp.customize('primary_color', function(value) {
        value.bind(function(to) {
            $('head').find('#mediummate-primary-color').remove();
            $('head').append('<style id="mediummate-primary-color">a, .text-primary, .btn-primary, .badge-primary { color: ' + to + ' !important; } .btn-primary, .badge-primary { background-color: ' + to + ' !important; border-color: ' + to + ' !important; }</style>');
        });
    });

    // Header Background Color
    wp.customize('header_bg_color', function(value) {
        value.bind(function(to) {
            $('.navbar-light').css('background-color', to);
        });
    });

    // Recent Posts Title
    wp.customize('recent_posts_title', function(value) {
        value.bind(function(to) {
            $('.section-title h2 span').text(to);
        });
    });

    // Footer Copyright
    wp.customize('footer_copyright', function(value) {
        value.bind(function(to) {
            $('.footer-copyright').html(to);
        });
    });

    // Font Family Changes
    wp.customize('body_font_family', function(value) {
        value.bind(function(to) {
            if (to) {
                // Load Google Font
                var fontUrl = 'https://fonts.googleapis.com/css2?family=' + to.replace(' ', '+') + ':wght@300;400;500;700&display=swap';
                $('head').find('#mediummate-body-font').remove();
                $('head').append('<link id="mediummate-body-font" href="' + fontUrl + '" rel="stylesheet">');
                $('body').css('font-family', '"' + to + '", sans-serif');
            }
        });
    });

    wp.customize('heading_font_family', function(value) {
        value.bind(function(to) {
            if (to) {
                // Load Google Font
                var fontUrl = 'https://fonts.googleapis.com/css2?family=' + to.replace(' ', '+') + ':wght@400;500;700;900&display=swap';
                $('head').find('#mediummate-heading-font').remove();
                $('head').append('<link id="mediummate-heading-font" href="' + fontUrl + '" rel="stylesheet">');
                $('h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6').css('font-family', '"' + to + '", sans-serif');
            }
        });
    });

})(jQuery);