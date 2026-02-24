/*
 * Password Strength Meter using zxcvbn
 * https://github.com/dropbox/zxcvbn
 */

(function($) {
    'use strict';

    // Password strength configuration
    var strengthLevels = [
        { score: 0, label: 'Very Weak', class: 'progress-danger', width: '10%' },
        { score: 1, label: 'Weak', class: 'progress-danger', width: '25%' },
        { score: 2, label: 'Fair', class: 'progress-warning', width: '50%' },
        { score: 3, label: 'Good', class: 'progress-info', width: '75%' },
        { score: 4, label: 'Strong', class: 'progress-success', width: '100%' }
    ];

    // Function to get strength info based on score
    function getStrengthInfo(score) {
        return strengthLevels[score] || strengthLevels[0];
    }

    // Function to create strength meter HTML
    function createStrengthMeter(targetInput) {
        var meterId = targetInput.id + '_strength_meter';
        var textId = targetInput.id + '_strength_text';
        
        // Check if meter already exists
        if ($('#' + meterId).length > 0) {
            return { meter: $('#' + meterId), text: $('#' + textId) };
        }

        // Create strength meter container
        var $container = $('<div class="password-strength-container" style="margin-top: 5px;"></div>');
        
        // Create progress bar
        var $progress = $(
            '<div id="' + meterId + '" class="progress progress-danger" style="margin-bottom: 5px;">' +
            '<div class="bar" style="width: 0%"></div>' +
            '</div>'
        );
        
        // Create text label
        var $text = $('<div id="' + textId + '" class="password-strength-text muted" style="font-size: 11px;">Enter a password</div>');
        
        $container.append($progress).append($text);
        
        // Insert after the input field
        $(targetInput).after($container);
        
        return { meter: $progress, text: $text };
    }

    // Function to update strength meter
    function updateStrengthMeter(targetInput) {
        var password = targetInput.value;
        var elements = createStrengthMeter(targetInput);
        
        if (!password) {
            elements.meter.find('.bar').css('width', '0%');
            elements.meter.removeClass('progress-danger progress-warning progress-info progress-success');
            elements.text.text('Enter a password').addClass('muted').removeClass('text-error text-warning text-info text-success');
            return;
        }

        // Get strength from zxcvbn
        var result = zxcvbn(password);
        var info = getStrengthInfo(result.score);

        // Update progress bar
        elements.meter.removeClass('progress-danger progress-warning progress-info progress-success')
                      .addClass(info.class);
        elements.meter.find('.bar').css('width', info.width);

        // Update text
        var crackTime = result.crack_times_display.offline_slow_hashing_1e4_per_second;
        elements.text.removeClass('muted text-error text-warning text-info text-success')
                     .addClass(info.class.replace('progress-', 'text-'))
                     .text(info.label + ' - Would take ' + crackTime + ' to crack');

        // Add feedback if available
        if (result.feedback.warning) {
            elements.text.append('<br><small>' + result.feedback.warning + '</small>');
        }
    }

    // Initialize password strength meters
    function initPasswordStrength() {
        // Look for password input fields
        // Only target password change forms, not login forms
        var passwordSelectors = [
            'input[type="password"][name*="new_password"]',
            'input[type="password"][name*="password"][id*="new"]',
            'input[type="password"]#new_password'
        ];

        $(passwordSelectors.join(', ')).each(function() {
            var $input = $(this);
            
            // Skip if already initialized
            if ($input.data('strength-initialized')) {
                return;
            }
            
            $input.data('strength-initialized', true);
            
            // Bind to input events
            $input.on('input keyup', function() {
                updateStrengthMeter(this);
            });
            
            // Initial check if field has value
            if (this.value) {
                updateStrengthMeter(this);
            }
        });
    }

    // Initialize on document ready
    $(document).ready(function() {
        initPasswordStrength();
    });

    // Re-initialize after AJAX content loads (for dynamically added forms)
    $(document).ajaxComplete(function() {
        initPasswordStrength();
    });

})(jQuery);
