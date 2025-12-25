/**
 * mediummate Clapping Feature
 * Single click per user per post - like appreciation/like button
 *
 * @package mediummate
 */

(function($) {
    'use strict';

    // Track if user has already clapped
    var hasClapped = false;
    var isProcessing = false;

    /**
     * Initialize clapping feature
     */
    function init() {
        // Check if already clapped (from cookie)
        var clappedCookie = getCookie('mm_clapped_' + mmClapping.post_id);
        if (clappedCookie === '1') {
            hasClapped = true;
            markAsClapped();
        }

        // Check if server-side says already clapped (via class added in PHP)
        if ($('.mm-claps-applause').hasClass('has_clapped')) {
            hasClapped = true;
        }

        // Bind click event
        $(document).on('click', '.claps-button', handleClap);
        
        // Add hover effects
        $(document).on('mouseenter', '.mm-claps-applause:not(.has_clapped)', function() {
            $(this).addClass('hover');
        }).on('mouseleave', '.mm-claps-applause', function() {
            $(this).removeClass('hover');
        });
    }

    /**
     * Handle clap click - ONE TIME ONLY
     */
    function handleClap(e) {
        e.preventDefault();

        // If already clapped, do nothing
        if (hasClapped) {
            return;
        }

        // Prevent double-click during processing
        if (isProcessing) {
            return;
        }

        var $button = $(this);
        var $container = $button.closest('.mm-claps-applause');
        var $count = $('.claps-count');

        // Mark as clapped immediately for responsive UI
        hasClapped = true;
        isProcessing = true;
        markAsClapped();

        // Update display count
        var currentCount = parseInt($count.text(), 10) || 0;
        $count.text(currentCount + 1);

        // Show +1 animation
        showPlusOne($container);

        // Save to cookie (permanent - 1 year)
        setCookie('mm_clapped_' + mmClapping.post_id, '1', 365);

        // Send to server
        sendClap($container);
    }

    /**
     * Send clap to server
     */
    function sendClap($container) {
        $.ajax({
            url: mmClapping.ajaxurl,
            type: 'POST',
            data: {
                action: 'mm_clap',
                post_id: mmClapping.post_id,
                nonce: mmClapping.nonce,
                count: 1
            },
            success: function(response) {
                if (response.success) {
                    // Update count from server
                    $('.claps-count').text(response.data.claps);
                }
            },
            error: function() {
                console.log('Clap request failed');
            },
            complete: function() {
                isProcessing = false;
            }
        });
    }

    /**
     * Show +1 animation
     */
    function showPlusOne($container) {
        var $plusOne = $('<span class="mm-plus-one">+1</span>');
        $container.append($plusOne);
        
        setTimeout(function() {
            $plusOne.remove();
        }, 600);
    }

    /**
     * Mark button as already clapped (permanent)
     */
    function markAsClapped() {
        $('.mm-claps-applause').addClass('has_clapped');
    }

    /**
     * Cookie helpers
     */
    function setCookie(name, value, days) {
        var expires = '';
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = '; expires=' + date.toUTCString();
        }
        document.cookie = name + '=' + (value || '') + expires + '; path=/';
    }

    function getCookie(name) {
        var nameEQ = name + '=';
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) === ' ') c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
        }
        return null;
    }

    // Initialize on document ready
    $(document).ready(init);

})(jQuery);
