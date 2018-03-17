/**
 * By FadyMichel
 */
$(function() {

    function initialize() {
        var options = {
            type: ['geocode','airport'],
            componentRestrictions: {country: 'fr'}
        };
        var acInputs = $('[data-google="autocomplete"]');
        for (var i = 0; i < acInputs.length; i++) {

            var autocomplete = new google.maps.places.Autocomplete(acInputs[i], options);
            autocomplete.inputId = acInputs[i].id;

            google.maps.event.addListener(autocomplete, 'place_changed', function () {
                var place = autocomplete.getPlace();
            });
        }
    }
    initialize();

});