/**
 * (c) Greg Priday, freely distributable under the terms of the GPL 2.0 license.
 */

jQuery( function ( $ ) {
    // We use the geocoder 
    var geocoder = new google.maps.Geocoder();
    $( '.google-map-canvas' ).each( function () {
        var $$ = $( this );
        geocoder.geocode( { 'address':$$.attr( 'data-address' )}, function ( results, status ) {
            if ( status == google.maps.GeocoderStatus.OK ) {
                var zoom = Number( $$.attr( 'data-zoom' ) );
                if ( zoom == undefined ) zoom = 14;

                map = new google.maps.Map( $$.get( 0 ), {
                    zoom:     zoom,
                    center:   results[0].geometry.location,
                    mapTypeId:google.maps.MapTypeId.ROADMAP
                } );

                var marker = new google.maps.Marker( {
                    position:results[0].geometry.location,
                    map:     map,
                    title:   ''
                } );
            }
            else if (status == google.maps.GeocoderStatus.ZERO_RESULTS) {
                // TODO let the user know that there are no results
            }
        } );
    } );
} );