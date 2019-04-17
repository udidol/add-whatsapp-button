// console.log('PHP variables: ' + php_vars.hideButtonType);

jQuery(document).ready(function( $ ) {
    // Make the New Whatsapp Button Draggable with jQuery UI
    $( function() {
      $( "#newWhatsAppButton" ).draggable({ 
        axis: "y", 
        scroll: false, 
      });
    });

    // Change close button inner HTML according to "Hide Button" type
    $( function() {
		if (php_vars.hideButtonType === 'hide' && php_vars.button_type === 'wab-bottom-rectangle')
			$('#wab_close').html('<img class="wab-chevron" src="'+php_vars.plugins_url+'/add-whatsapp-button/img/chevron-down.svg" />');
			$('img.wab-chevron').addClass('wab-down');
			
        if (php_vars.hideButtonType === 'hide' && php_vars.button_location === 'left') {
			if (php_vars.button_type === 'wab-side-rectangle' || php_vars.button_type === 'wab-icon-plain')
				$('#wab_close').html('<');
        }

        if (php_vars.hideButtonType === 'hide' && php_vars.button_location === 'right') {
			if (php_vars.button_type === 'wab-side-rectangle' || php_vars.button_type === 'wab-icon-plain')
				$('#wab_close').html('>');
        }
            
    });

    // Attach hide action to wab_close button
    $( function() {
        $('#wab_close').click(function() {
            if (php_vars.hideButtonType === 'full')
                $('#wab_cont').hide();
            if (php_vars.hideButtonType === 'hide') {
                $('#wab_cont').toggleClass('wab-hidden');

				if (php_vars.button_type === 'wab-bottom-rectangle') {
					if ($('.wab-chevron').hasClass('wab-down')) {
						$('#wab_close img.wab-chevron').attr("src", php_vars.plugins_url+'/add-whatsapp-button/img/chevron-up.svg');
					}
					else if ($('.wab-chevron').hasClass('wab-up')) {
						$('#wab_close img.wab-chevron').attr("src", php_vars.plugins_url+'/add-whatsapp-button/img/chevron-down.svg');
					}
					
					$('.wab-chevron').toggleClass('wab-down wab-up');					
				}
				
                if ((php_vars.button_type === 'wab-side-rectangle' || php_vars.button_type === 'wab-icon-plain') && php_vars.button_location === 'left' && !$('#wab_cont').hasClass('wab-hidden')) {
                    $('#wab_close').html('<');
                }

                if ((php_vars.button_type === 'wab-side-rectangle' || php_vars.button_type === 'wab-icon-plain') && php_vars.button_location === 'left' && $('#wab_cont').hasClass('wab-hidden')) {
                    $('#wab_close').html('>');
                }

                if ((php_vars.button_type === 'wab-side-rectangle' || php_vars.button_type === 'wab-icon-plain') && php_vars.button_location === 'right' && !$('#wab_cont').hasClass('wab-hidden')) {
                    $('#wab_close').html('>');
                }

                if ((php_vars.button_type === 'wab-side-rectangle' || php_vars.button_type === 'wab-icon-plain') && php_vars.button_location === 'right' && $('#wab_cont').hasClass('wab-hidden')) {
                    $('#wab_close').html('<');
                }
            }

        });
    });
});

// Limit Button Display to certain hours
(function(){
    document.addEventListener( "DOMContentLoaded", function(){
        var currentSystemTime, currentSystemHour;

        currentSystemTime = new Date();
        currentSystemHour = currentSystemTime.getHours();

        var isLimited = php_vars.limitHours;
        var displayTimes = {
            'startHour': php_vars.startHour,
            'endHour': php_vars.endHour
        }

        if (isLimited == true && (currentSystemHour < displayTimes.startHour === false && currentSystemHour > displayTimes.endHour === false) === false) {
            document.getElementById('whatsAppButton').style.display = 'none';
        }
    });
})();