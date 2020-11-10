/**
 * (c) Greg Priday, freely distributable under the terms of the GPL 2.0 license.
 */

jQuery( function ( $ ) {
    $( 'body' ).on( 'submit', '#commentform', function () {
        var $$ = $(this);

        // Don't run this if it's in a WooCommerce form.
        if( $$.closest('.pp_woocommerce').length ) {
            return true;
        }

        // Send the comment form via AJAX
        var submitData = {};
        $( '#commentform :input' ).each( function () {
            submitData[ this.name ] = $( this ).val();
        } );
        submitData['is_ajax'] = true;

        $.ajax( $( "#commentform" ).attr( 'action' ), {
            'data':    submitData,
            'success': function ( data ) {
                if ( data.status == undefined ) {
                    return false;
                }
                else if ( data.status === 'error' ) {
                    // Display the error
                    var error = $( '<div class="commentform-error"></div>' )
                        .html( data.error )
                        .insertBefore( '#commentform' )
                        .hide()
                        .slideDown()
                        .delay( 2000 )
                        .slideUp( function () {
                            $( this ).remove();
                        } );
                }
                else if ( data.status === 'success' ) {
                    $( '#cancel-comment-reply-link' ).click();
                    $( '#single-comments-wrapper' ).html( data.html );
                }
            },
            'type':    'POST',
            'dataType':'json'
        } );

        return false;
    } );
} );