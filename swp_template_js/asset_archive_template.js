(function($) {

	var ThisURL = flexi_temp_args.site_url, // SITE URL passed from WP (with forward slash at the end)
		iPostType = $( '#iposttype' ).val(),
		iTemplate = $( '#itemplate' ).val(),
		iTaxName = $( '#itaxname' ).val(),
		iTaxTerm = $( '#itaxterm' ).val(),
		iPPP = $( '#ippp' ).val(),
		iShowEntries = $( '#ishowentries' ).val(),
        iSkip = $( '#iskip' ).val(),
        iDisplay = $( '#idisplay' ).val(),
        iMaxPages = $( '#imaxnumpages' ).val(),
		iPage, TaxURL,
		SetMore, w, AJAXurl;

	// load the page value in #pager (textbox)
	$(document).ready(function( event ) {
		// we do not set the value within the actual text field so jQuery can control the value
		$( '#ipage' ).val( 1 );
	});

    // LISTEN TO ANCHOR CLICKS
    $( "a" ).click( function(event) {

    	// retrieve value here
    	iPage = $( '#ipage' ).val();

        // increment
    	SetMore = parseInt( iPage ) + 1;

        // update textbox value
        $( '#ipage' ).val( SetMore );

    	// validate taxonomy
    	if( iTaxName ) {
    		TaxURL = '&tax_name=' + iTaxName + '&tax_term=' + iTaxTerm;
    	} else {
    		TaxURL = '';
    	}

    	AJAXurl = ThisURL + 'page/' + SetMore +
                    '/?posttype=' + iPostType +
                    '&template=' + iTemplate +
                    TaxURL +
                    '&posts_per_page=' + iPPP +
                    '&showentries=' + iShowEntries +
                    '&skip=' + iSkip +
                    '&display=' + iDisplay;

    	SWP_AJAX( AJAXurl );

        // last page - hide more link
        if( iPage == iMaxPages ) {
            //alert( iPage + ' | ' + ' | ' + SetMore + ' | ' + iMaxPages );
            $( '#more' ).fadeOut( 1000, function(){
                $( '#more_shown' ).fadeIn( 1000 );
            });
        }

    });


    // AJAX - JS don't want this function within a loop
    function SWP_AJAX( AJAXurl ) {

        $.ajax({
            url: AJAXurl,
            type:'_REQUEST',
            success: function(data){

                w = $( data, { css: { 'display': 'none' }} ).find( '#grid-container' ).html();

                if (typeof w === 'undefined') {
                    
                } else {

                    $( '#grid-container' )
                        .append( w )
                        .children()
                        .fadeIn( 1000 ); // children are already hidden by the iTemplate
                    
                }
                
            }
        });

    }

})( jQuery );