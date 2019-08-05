(function($) {

	var ThisURL = flexi_temp_args.site_url, // SITE URL passed from WP (with forward slash at the end)
		AJAXurl, EventID, EventNum, PrevCount, PrevCounter,
		iTemplate, iTaxName, iTaxTerm, iPPP,
		TargetDIV, TargetDIVElement, TargetDIVpos, TargetDIVposLeft, FadeSpeed = 'slow';

    $(document).ready(function( event ) {
    	
    	// insert values to all counter
    	var i, x = $( '#social_types_count' ).val();
    	// add via jQuery so we can increment or decrement the value
		for (i = 1; i <= parseInt( x ); i++) { 
			$( '#paged_' + i ).val( 1 );
		}
        
    });


    // LISTEN TO ANCHOR CLICKS
	$( "a" ).click( function(event) {

        EventID = event.target.id;

        EventNum = EventID.split( "_" );

        PrevCount = $( '#paged_' + EventNum[1] ).val();

        // get input values
        iTemplate = $( '#template_' + EventNum[1] ).val();
        iTaxName = $( '#tax_name_' + EventNum[1] ).val();
        iTaxTerm = $( '#tax_term_' + EventNum[1] ).val();
        iPPP = $( '#ppp_' + EventNum[1] ).val();

        // get targer container
        TargetDIV = $( '#term_set_' + EventNum[1] );
        TargetDIVpos = TargetDIV.position(); // get position

        TargetDIVElement = $( '#term_set_cont_' + EventNum[1] );

        if( EventNum[0] == 'prev' ) {

        	/* --------------------------------------------
        	 * | PREVIOUS
        	 * ----------------------------------------- */

        	// decrement
        	PrevCounter = parseInt( PrevCount ) - 1 ;
        	$( '#paged_' + EventNum[1] ).val( PrevCounter );

			// process the PREVIOUS link
        	if( ( parseInt( PrevCount) - 1 ) == 1 ) {

        		// hide dummy PREVIOUS link
        		$( '#prev_0_' + EventNum[1] ).show();
        		// show real PREVIOUS link
        		$( '#prev_' + EventNum[1] ).hide();

        	}

        	// process the NEXT link
        	if( parseInt( $( '#max_posts_' + EventNum[1] ).val() ) != parseInt( $( '#paged_' + EventNum[1] ).val() ) ) {

        		// hide dummy NEXT link
        		$( '#next_0_' + EventNum[1] ).hide();
        		// show real NEXT link
        		$( '#next_' + EventNum[1] ).removeAttr("style");

        	}

        } else {
        	
        	/* --------------------------------------------
        	 * | NEXT
        	 * ----------------------------------------- */

        	// increment
        	PrevCounter = parseInt( PrevCount ) + 1 ;
        	$( '#paged_' + EventNum[1] ).val( PrevCounter );

        	// process the PREVIOUS link
        	if( PrevCount == 1 ) {

        		// hide dummy PREVIOUS link
        		$( '#prev_0_' + EventNum[1] ).hide();
        		// show real PREVIOUS link
        		$( '#prev_' + EventNum[1] ).removeAttr("style");

        	}

        	// process the NEXT link
        	if( parseInt( $( '#max_posts_' + EventNum[1] ).val() ) == parseInt( $( '#paged_' + EventNum[1] ).val() ) ) {

        		// hide dummy NEXT link
        		$( '#next_0_' + EventNum[1] ).removeAttr("style");
        		// show real NEXT link
        		$( '#next_' + EventNum[1] ).hide();

        	}

        }
        alert('zzzzz');
        // execute animation
        LoadContents( TargetDIV, TargetDIVElement, PrevCounter, iTemplate, iTaxName, iTaxTerm, iPPP );

    });



    // load contents
	function LoadContents( TargetDIV, TargetDIVElement, PrevCount, iTemplate, iTaxName, iTaxTerm, iPPP,  callback ) {

	/*
		# PAGE: 1
		https://prototype-npr.basestructure.com/social-feed-dummy/?template=mediaobject-social.php&tax_name=social_type&tax_term=facebook&posts_per_page=3
		# PAGE: succeeding
		https://prototype-npr.basestructure.com/social-feed-dummy/page/2/?template=mediaobject-social.php&tax_name=social_type&tax_term=facebook&posts_per_page=3
	*/

		if( PrevCount == 1 ) {
			AJAXurl = ThisURL + '?template=' + iTemplate + '&tax_name=' + iTaxName + '&tax_term=' + iTaxTerm + '&posts_per_page=' + iPPP;
		} else {
			AJAXurl = ThisURL + 'page/' + PrevCount + '/?template=' + iTemplate + '&tax_name=' + iTaxName + '&tax_term=' + iTaxTerm + '&posts_per_page=' + iPPP;
		}
		
/*
		jQuery( '#week_'+CurrentWeek ).fadeOut( FadeSpeed, function() {
			jQuery( '#week_'+NextWeek ).fadeIn( FadeSpeed, function() {
				// hide loading gif
				jQuery( '#img_loader' ).fadeOut( FadeSpeed );
			});
		});
*/		

	    $.ajax({
		    url: AJAXurl,
	        type:'_REQUEST',
	        success: function(data){
	        	/*TargetDIVElement.fadeOut( FadeSpeed, function() {
					TargetDIV.fadeIn( FadeSpeed, function() {
						// hide loading gif
						TargetDIV.html( $( data ).find( '#term_set_container' ).html() );
					});
				});*/
	        	TargetDIVElement.slideUp( 'moderate' ).hide();
	        	TargetDIV.hide().html( $( data ).find( '#term_set_container' ).html() )
	        	TargetDIV.show().slideUp( 'moderate' );
	        }
		});

	    callback();

	}

})( jQuery );