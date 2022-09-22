require(['jquery'],function($){
    $(document).ready(function(){
/**--------------------------- */
     //  alert('ha');
        $('input[type="file"]').change(function() {
            if ($('#image_noti').val()) {
               
                var filename = $('#image_noti').val();
                
                var nameDesktop = filename.substr(12,filename.length - 12);
                console.log(nameDesktop);
                if($('#desk-div').length){
                    $('#desk-div').remove();
                    
                }
                $("#image_noti").after("<div id='desk-div' class='check-desktop' >"+nameDesktop+'</div>');
            }
           
        });
        var origin   = window.location.origin;
        if( $('#nameDesktop').length){
            $("#image_noti").before("<div style = 'margin-top:3px;' id ='desk-div'><img id='showdesk' src = 'abc.xz' width='100' height='50'></div>");
            $('#showdesk').attr('src',origin + '/pub/media/wiki_notification/images/' + $('#nameDesktop').val() );
        }
        
        // $('#save').click(function() {
        //     // if ($('#desk-div').length ===0 ) {
        //     //     alert( "Please choose file upload for notification." );
        //     //     return ;
        //     // }
        //     // if(!$('#image_noti').val() ){
        //     //     alert( "Please choose file upload for notification." );
        //     //     return false;
        //     // }
        //     alert('haha');
        //     return false;
        // });
        

          
          

 /**------------------------- */         
    });
});


// require(['jquery'],function($){
//     $(document).ready(function(){
// /**--------------------------- */
//        //alert('ha');
//         $('input[type="file"]').change(function() {
//             if ($('#image_desktop').val()) {
//                 var filename = $('#image_desktop').val();
//                 var nameDesktop = filename.substr(12,filename.length - 12);
//                 if($('#desk-div').length){
//                     $('#desk-div').remove();
                    
//                 }
//                 $("#image_desktop").after("<div id='desk-div' class='check-desktop' >"+nameDesktop+'</div>');
//             }
//             if ($('#image_mobile').val()) {
//                 var filename = $('#image_mobile').val();
//                 var namemobile = filename.substr(12,filename.length - 12);
//                 if($('#mobile-div').length){
//                     $('#mobile-div').remove();
//                 }
//                 $("#image_mobile").after("<div id='mobile-div' class='check-mobile' >"+namemobile+'</div>');
//             }
//         });
//         var origin   = window.location.origin;
//         if( $('#nameDesktop').length){
//             $("#image_desktop").before("<div style = 'margin-top:3px;' id ='desk-div'><img id='showdesk' src = 'abc.xz' width='100' height='50'></div>");
//             $('#showdesk').attr('src',origin + '/pub/media/mirasvit_blog/images/' + $('#nameDesktop').val() );
//         }
//         if( $('#nameMobile').length){
//             $("#image_mobile").before("<div style = 'margin-top:3px;' class='mt-1' id ='mobile-div'><img id='showmobile' src = 'abc.xz' width='100' height='50'></div>");
//             $('#showmobile').attr('src',origin + '/pub/media/mirasvit_blog/images/' + $('#nameMobile').val() );
//         }
       
        
//         $('#save-split-button-button').click(function() {
//             if ($('#desk-div').length ===0 || $('#mobile-div').length === 0) {
//                 alert( "Please choose file upload for mobile and desktop." ); return false;
//             }
//         });
        

          
          

//  /**------------------------- */         
//     });
// });