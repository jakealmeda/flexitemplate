(function($) {

    var ThisURL = flexi_temp_args.site_url, // SITE URL passed from WP (with forward slash at the end)
        AJAXurl, EventID, EventNum, iPage, PrevCounter, SetPrev, SetCurrent, SetMore,
        iTemplate, iTaxName, iTaxTerm, iPPP, iSet,
        TargetDIV, TargetDIVElement, TargetDIVpos, TargetDIVposLeft, FadeSpeed = '1000'; // FadeSpeed -> 1000 is 1 second

    $(document).ready(function( event ) {

        // insert values to all counter
        var i, x = $( '#social_types_count' ).val();
        // add via jQuery so we can increment or decrement the value
        for (i = 1; i <= parseInt( x ); i++) { 
            $( '#paged_' + i ).val( 1 );
        }
        
        LoadAdditionalUponInitialize( x );
        
    });


    // LISTEN TO ANCHOR CLICKS
    $( "a" ).click( function(event) {

        EventID = event.target.id;

        EventNum = EventID.split( "_" );

        iSet = EventNum[1]; // get the set number

        // get input values
        iTemplate = $( '#template_' + iSet ).val();
        iTaxName = $( '#tax_name_' + iSet ).val();
        iTaxTerm = $( '#tax_term_' + iSet ).val();
        iPPP = $( '#ppp_' + iSet ).val();
        iPage = $( '#paged_' + iSet ).val();
        

        // get targer container
        TargetDIV = $( '#term_set_' + iSet );
        TargetDIVpos = TargetDIV.position(); // get position

        if( EventNum[0] == 'prev' ) {

            /* --------------------------------------------
             * | PREVIOUS
             * ----------------------------------------- */

            // decrement
            PrevCounter = parseInt( iPage ) - 1 ;
            $( '#paged_' + iSet ).val( PrevCounter );

            // process the PREVIOUS link
            if( ( parseInt( iPage) - 1 ) == 1 ) {

                // hide dummy PREVIOUS link
                $( '#prev_0_' + iSet ).show();
                // show real PREVIOUS link
                $( '#prev_' + iSet ).hide();

            }

            // process the NEXT link
            if( parseInt( $( '#max_posts_' + iSet ).val() ) != parseInt( $( '#paged_' + iSet ).val() ) ) {

                // hide dummy NEXT link
                $( '#next_0_' + iSet ).hide();
                // show real NEXT link
                $( '#next_' + iSet ).removeAttr("style");

            }

        } else {
            
            /* --------------------------------------------
             * | NEXT
             * ----------------------------------------- */

            // increment
            PrevCounter = parseInt( iPage ) + 1 ;
            $( '#paged_' + iSet ).val( PrevCounter );

            // process the PREVIOUS link
            if( iPage == 1 ) {

                // hide dummy PREVIOUS link
                $( '#prev_0_' + iSet ).hide();
                // show real PREVIOUS link
                $( '#prev_' + iSet ).removeAttr("style");

            }

            // process the NEXT link
            if( parseInt( $( '#max_posts_' + iSet ).val() ) == parseInt( $( '#paged_' + iSet ).val() ) ) {

                // hide dummy NEXT link
                $( '#next_0_' + iSet ).removeAttr("style");
                // show real NEXT link
                $( '#next_' + iSet ).hide();

            }

        }
        //alert( '#term_set_cont_' + iSet + '_' + parseInt( iPage ) );
        TargetDIVElement = $( '#term_set_cont_' + iSet + '_' + parseInt( iPage ) );

        //alert( TargetDIV.attr('id') + ' | ' + TargetDIVElement.attr('id') + ' | ' + PrevCounter + ' | ' + iTemplate + ' | ' + iTaxName + ' | ' + iTaxTerm + ' | ' + iPPP );
        // execute animation
        LoadContents( TargetDIV, TargetDIVElement, iSet, PrevCounter, iTemplate, iTaxName, iTaxTerm, iPPP, EventNum[0] );

    });


    // load contents
    function LoadContents( TargetDIV, TargetDIVElement, iSet, iPage, iTemplate, iTaxName, iTaxTerm, iPPP, iButton ) {

        /*
            # PAGE: 1
            https://prototype-npr.basestructure.com/social-feed-dummy/?template=mediaobject-social.php&tax_name=social_type&tax_term=facebook&posts_per_page=3
            # PAGE: succeeding
            https://prototype-npr.basestructure.com/social-feed-dummy/page/2/?template=mediaobject-social.php&tax_name=social_type&tax_term=facebook&posts_per_page=3
        */
        
        SetPrev = parseInt( iPage ) - 1;

        SetCurrent = parseInt( iPage ); 

        SetMore = parseInt( iPage ) + 1;
        
        if( iPage == 1 ) {
            AJAXurl = ThisURL + '?template=' + iTemplate + '&tax_name=' + iTaxName + '&tax_term=' + iTaxTerm + '&posts_per_page=' + iPPP + '&iset=' + iSet;
        } else {
            AJAXurl = ThisURL + 'page/' + SetMore + '/?template=' + iTemplate + '&tax_name=' + iTaxName + '&tax_term=' + iTaxTerm + '&posts_per_page=' + iPPP + '&iset=' + iSet;
        }
        
        // PREVIOUS LINK CLICKED
        if( iButton == 'prev' ) {
            
            // hide current, show previous           
            $( '#term_set_cont_' + iSet + '_' + SetMore ).hide( "slide", { direction: "right" }, FadeSpeed, function() {
                $( '#term_set_cont_' + iSet + '_' + SetCurrent ).show( "slide", { direction: "left" }, FadeSpeed );
            });

        } else {

            // NEXT LINK CLICKED

            // hide current, show next
            $( '#term_set_cont_' + iSet + '_' + SetPrev ).hide( "slide", { direction: "left" }, FadeSpeed, function() {
                $( '#term_set_cont_' + iSet + '_' + SetCurrent ).show( "slide", { direction: "right" }, FadeSpeed );
            });

            // insert entries if not yet loaded
            //alert( $( '#term_set_cont_' + iSet + '_' + iPage ).html().length );
            if( $( '#term_set_cont_' + iSet + '_' + iPage ).length ) {
                SWP_AJAX( AJAXurl, iSet );
            }

        }

    }


    // load more upon page ready
    function LoadAdditionalUponInitialize( x ) {

        for ( var a = 1; a <= parseInt( x ); a++ ) { 
            
            // get input values
            iTemplate = $( '#template_' + a ).val();
            iTaxName = $( '#tax_name_' + a ).val();
            iTaxTerm = $( '#tax_term_' + a ).val();
            iPPP = $( '#ppp_' + a ).val();
            iPage = $( '#paged_' + a ).val();

            AJAXurl = ThisURL + 'page/2/?template=' + iTemplate + '&tax_name=' + iTaxName + '&tax_term=' + iTaxTerm + '&posts_per_page=' + iPPP + '&iset=' + a;

            SWP_AJAX( AJAXurl, a );

        }

    }


    // AJAX - JS don't want this function within a loop
    function SWP_AJAX( AJAXurl, a ) {

        $.ajax({
            url: AJAXurl,
            type:'_REQUEST',
            success: function(data){

                var w = $( data ).find( '#term_set_container' ).html();

                if (typeof w === 'undefined') {
                    
                } else {
                    $( '#term_set_' + a ).append( w );
                }
                
            }
        });

    }

})( jQuery );