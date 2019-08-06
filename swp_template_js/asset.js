(function($) {

    var ThisURL = flexi_temp_args.site_url, // SITE URL passed from WP (with forward slash at the end)
        AJAXurl, EventID, EventNum, PrevCount, PrevCounter,
        iTemplate, iTaxName, iTaxTerm, iPPP, iSet,
        TargetDIV, TargetDIVElement, TargetDIVpos, TargetDIVposLeft, FadeSpeed = 'slow';

    $(document).ready(function( event ) {
        alert('rtrtrtr');
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

        iSet = EventNum[1]; // get the set number

        PrevCount = $( '#paged_' + iSet ).val();

        // get input values
        iTemplate = $( '#template_' + iSet ).val();
        iTaxName = $( '#tax_name_' + iSet ).val();
        iTaxTerm = $( '#tax_term_' + iSet ).val();
        iPPP = $( '#ppp_' + iSet ).val();
        

        // get targer container
        TargetDIV = $( '#term_set_' + iSet );
        TargetDIVpos = TargetDIV.position(); // get position

        if( EventNum[0] == 'prev' ) {

            /* --------------------------------------------
             * | PREVIOUS
             * ----------------------------------------- */

            // decrement
            PrevCounter = parseInt( PrevCount ) - 1 ;
            $( '#paged_' + iSet ).val( PrevCounter );

            // process the PREVIOUS link
            if( ( parseInt( PrevCount) - 1 ) == 1 ) {

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
            PrevCounter = parseInt( PrevCount ) + 1 ;
            $( '#paged_' + iSet ).val( PrevCounter );

            // process the PREVIOUS link
            if( PrevCount == 1 ) {

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
        //alert( '#term_set_cont_' + iSet + '_' + parseInt( PrevCount ) );
        TargetDIVElement = $( '#term_set_cont_' + iSet + '_' + parseInt( PrevCount ) );

        //alert( TargetDIV.attr('id') + ' | ' + TargetDIVElement.attr('id') + ' | ' + PrevCounter + ' | ' + iTemplate + ' | ' + iTaxName + ' | ' + iTaxTerm + ' | ' + iPPP );
        // execute animation
        LoadContents( TargetDIV, TargetDIVElement, iSet, PrevCounter, iTemplate, iTaxName, iTaxTerm, iPPP );

    });



    // load contents
    function LoadContents( TargetDIV, TargetDIVElement, iSet, PrevCount, iTemplate, iTaxName, iTaxTerm, iPPP ) {

    /*
        # PAGE: 1
        https://prototype-npr.basestructure.com/social-feed-dummy/?template=mediaobject-social.php&tax_name=social_type&tax_term=facebook&posts_per_page=3
        # PAGE: succeeding
        https://prototype-npr.basestructure.com/social-feed-dummy/page/2/?template=mediaobject-social.php&tax_name=social_type&tax_term=facebook&posts_per_page=3
    */

        if( PrevCount == 1 ) {
            AJAXurl = ThisURL + '?template=' + iTemplate + '&tax_name=' + iTaxName + '&tax_term=' + iTaxTerm + '&posts_per_page=' + iPPP + '&iset=' + iSet;
        } else {
            AJAXurl = ThisURL + 'page/' + PrevCount + '/?template=' + iTemplate + '&tax_name=' + iTaxName + '&tax_term=' + iTaxTerm + '&posts_per_page=' + iPPP + '&iset=' + iSet;
        }
        
        // check if element exists, show if true
        if( $( '#term_set_cont_' + iSet + '_' + PrevCount ).length ) {
            
            // show hidden contents

            // set current element
            var PrevSet = parseInt( PrevCount ) + 1;
            $( '#term_set_cont_' + iSet + '_' + PrevSet ).hide( "slide", { direction: "left" }, FadeSpeed );

            $( '#term_set_cont_' + iSet + '_' + PrevCount ).show( "slide", { direction: "left" }, FadeSpeed );
            /*$( '#term_set_cont_' + iSet + '_' + PrevCount ).hide( "slide", { direction: "right" }, FadeSpeed, function() {

                TargetDIVElement.show( "slide", { direction: "left" }, FadeSpeed, function() {
                    //$( this ).removeAttr( "style" );
                });

            });*/


        } else {

            // load contents from dummy

            $.ajax({
                url: AJAXurl,
                type:'_REQUEST',
                success: function(data){

                    TargetDIVElement.hide( "slide", { direction: "left" }, FadeSpeed, function() {

                        TargetDIV.append( $( data ).find( '#term_set_container' ).html() );

                        $( '#term_set_cont_' + iSet + '_' + PrevCount ).show( "slide", { direction: "right" }, FadeSpeed, function() {
                            $( this ).removeAttr( "style" );
                        });

                    });
                    
                }
            });

        }

    }

})( jQuery );