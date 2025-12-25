/* Customizer Controls JavaScript */
(function($) {
    'use strict';

    // Toggle Control Handler
    $(document).on('change', '.customize-control-toggle input[type="checkbox"]', function() {
        var $this = $(this);
        var value = $this.is(':checked') ? 1 : 0;
        $this.val(value).trigger('change');
    });

    // Range Control Handler
    $(document).on('input', '.customize-control-range input[type="range"]', function() {
        var $this = $(this);
        var value = $this.val();
        $this.siblings('.range-value').text(value);
        $this.trigger('change');
    });

    // Multiple Select Control Handler
    $(document).on('change', '.customize-control-multiple_select select', function() {
        var $this = $(this);
        var selectedValues = [];
        $this.find('option:selected').each(function() {
            selectedValues.push($(this).val());
        });
        $this.val(selectedValues).trigger('change');
    });

    // Panel and Section Enhancements
    $(document).ready(function() {
        // Add icons to panel titles
        $('.customize-panel-mediummate_homepage_panel .panel-title').prepend('<i class="dashicons dashicons-admin-home"></i> ');
        $('.customize-panel-mediummate_styling_panel .panel-title').prepend('<i class="dashicons dashicons-admin-appearance"></i> ');
        
        // Add descriptions to sections if needed
        var sectionDescriptions = {
            'mediummate_slider_section': 'Configure the hero slider that appears at the top of your homepage.',
            'mediummate_categories_section': 'Choose which categories to feature prominently on your homepage.',
            'mediummate_recent_posts_section': 'Customize the recent posts section display options.',
            'mediummate_colors_section': 'Set your brand colors and theme styling.',
            'mediummate_typography_section': 'Choose fonts and typography settings.',
            'mediummate_social_section': 'Add your social media profile links.',
            'mediummate_footer_section': 'Configure footer content and options.'
        };

        $.each(sectionDescriptions, function(sectionId, description) {
            var $section = $('#customize-control-' + sectionId);
            if ($section.length && !$section.find('.section-description').length) {
                $section.prepend('<p class="section-description">' + description + '</p>');
            }
        });
    });

    // Dynamic control visibility based on settings
    wp.customize.bind('ready', function() {
        // Show/hide slider controls based on enable setting
        wp.customize('slider_enable', function(setting) {
            var setupControl = function(isEnabled) {
                var controls = ['slider_posts_count', 'slider_category'];
                $.each(controls, function(index, controlId) {
                    var control = wp.customize.control(controlId);
                    if (control) {
                        control.container.toggle(isEnabled);
                    }
                });
            };
            
            // Initial setup
            setupControl(setting.get());
            
            // Listen for changes
            setting.bind(setupControl);
        });

        // Show/hide featured categories controls
        wp.customize('featured_categories_enable', function(setting) {
            var setupControl = function(isEnabled) {
                var control = wp.customize.control('featured_categories_count');
                if (control) {
                    control.container.toggle(isEnabled);
                }
            };
            
            setupControl(setting.get());
            setting.bind(setupControl);
        });
    });

})(jQuery);