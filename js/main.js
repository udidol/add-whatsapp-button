//console.log('PHP variables: ' + php_vars.startHour);

// Make the New Whatsapp Button Draggable with jQuery UI
jQuery(document).ready(function( $ ) {
    $( function() {
      $( "#newWhatsAppButton" ).draggable({ 
        axis: "y", 
        scroll: false, 
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