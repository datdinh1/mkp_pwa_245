//Search
var modal = document.getElementById("myModal");
require([ 'jquery', 'jquery/ui'], function($){ 
    $( ".myBtnSearch" ).click(function(e) {
        var modal = document.getElementById("myModalSearch");
        modal.style.display = "block";
        $( ".close" ).click(function(e) {
            modal.style.display = "none";
        });
        $(window).click(function(e) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        });
    }); 
},
);
//Acount
require([ 'jquery', 'jquery/ui'], function($){ 
    $( ".myBtnAccount" ).click(function(e) {
        var modal = document.getElementById("myModalAccount");
        // Get the button that opens the modal
        var btn = document.getElementById("myBtnAccount");
        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];
        modal.style.display = "block";
        $( ".close" ).click(function(e) {
            modal.style.display = "none";
        });
        $(window).click(function(e) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        });
    }); 
},
);

//Sign In
require([ 'jquery', 'jquery/ui'], function($){
    $( ".myBtnSignIn" ).click(function(e) {
        $(this).toggleClass('on');
        $('.slide-content').toggleClass('menu-active');
        $('.slide-menu').toggleClass('menu-active');
        var modalSignIn = document.getElementById("myModalSignIn");
    }); 
    $( ".myBtnBack" ).click(function(e) {
        $(this).toggleClass('on');
        $('.slide-content').toggleClass('menu-active');
        $('.slide-menu').toggleClass('menu-active');
        var modalSignIn = document.getElementById("myModalSignIn");
        // modalSignIn.style.display = "none";
    }); 
},
);


//Quick View
require([ 'jquery', 'jquery/ui'], function($){ 
    $( ".myBtnQuickView" ).click(function(e) {
        var modal = document.getElementById("myModalQuickView");
        $(".tab-menu").css('display','none');
        $(".progress-inner-wrapper").css('display','none');
        modal.style.display = "block";
        var span = document.getElementsByClassName("close")[0];
        $( ".close" ).click(function(e) {
            modal.style.display = "none";
            $(".tab-menu").css('display','block');
        });
        $(window).click(function(e) {
            if (event.target == modal) {
                modal.style.display = "none";
                $(".tab-menu").css('display','block');
            }
        }); 
    }); 
    $( ".dropdown-toggle" ).click(function(e) {
        var clicks = $(this).data('clicks');
        if (clicks) {
            $(".dropdown-toggle .caret").css('border-top','8px solid black');
            $(".dropdown-toggle .caret").css('border-bottom','0');
            $(".dropdown-menu").css('display','none');
            $(".dropdown-toggle").css('border','1px solid #888');
            $(".dropdown-toggle").css('border-bottom','1px solid #888');
        } else {
            $(".dropdown-toggle .caret").css('border-top','0px');
            $(".dropdown-toggle .caret").css('border-bottom','8px solid black');
            $(".dropdown-menu").css('display','block');
            $(".dropdown-toggle").css('border','2px solid black');
            $(".dropdown-toggle").css('border-bottom','0px');
        }
        $(this).data("clicks", !clicks);
        $( ".dropdown-menu li" ).click(function(e) {
            $(".dropdown-menu").css('display','none');
            $(".dropdown-toggle").css('border','1px solid #888');
            $(".dropdown-toggle").css('padding','10px 36px 10px 16px');
            $(".dropdown-toggle").css('border-bottom','1px solid #888');
            $(".dropdown-text").text($(this).attr("value"));
            $(".dropdown-text").css('color','black');
            $(".dropdown-label").css('display','block');
            $(".btn-add-to-bag").removeClass('disabled');
            $(".btn-add-to-bag").css('background','black');
            $(".nsa-product-availability form").css('display','flex');
            $(".btn-select-size").css('display','none');
        }); 
        $( ".font-locate" ).click(function(e) {
            $(".qa-error-help-block").css('display','block');
        }); 
    });
    
    $('.btn-number').click(function(e){
        e.preventDefault();
        fieldName = $(this).attr('data-field');
        type      = $(this).attr('data-type');
        var input = $("input[name='"+fieldName+"']");
        var currentVal = parseInt(input.val());
        if (!isNaN(currentVal)) {
            if(type == 'minus') {
                
                if(currentVal > input.attr('min')) {
                    input.val(currentVal - 1).change();
                } 
                if(parseInt(input.val()) == input.attr('min')) {
                    $(this).attr('disabled', true);
                }
    
            } else if(type == 'plus') {
    
                if(currentVal < input.attr('max')) {
                    input.val(currentVal + 1).change();
                }
                if(parseInt(input.val()) == input.attr('max')) {
                    $(this).attr('disabled', true);
                }
    
            }
        } else {
            input.val(0);
        }
    });
    $('.input-number').focusin(function(){
       $(this).data('oldValue', $(this).val());
    });
    $('.input-number').change(function() {
        
        minValue =  parseInt($(this).attr('min'));
        maxValue =  parseInt($(this).attr('max'));
        valueCurrent = parseInt($(this).val());
        
        name = $(this).attr('name');
        if(valueCurrent >= minValue) {
            $(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')
        } else {
            alert('Sorry, the minimum value was reached');
            $(this).val($(this).data('oldValue'));
        }
        if(valueCurrent <= maxValue) {
            $(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
        } else {
            alert('Sorry, the maximum value was reached');
            $(this).val($(this).data('oldValue'));
        }
        
        
    });
    $(".input-number").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
                // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) || 
                // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
                    // let it happen, don't do anything
                    return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    }); 
},
);

//dropdown-mobile-max-width-1024-footer
require([ 'jquery', 'jquery/ui'], function($){ 
    $( ".mb-footer-group" ).click(function(e) {
        var clicks = $(this).data('clicks');
        if (clicks) {
            $(this).find(".dropdown-heading").css('background','transparent');
            $(this).find(".dropdown-title").css('color','black');
            $(this).find(".list-unstyled").css('visibility','hidden');
            $(this).find(".list-unstyled").css('height','0px');
        } else {
            $(this).find(".list-unstyled").show();
            $(this).find(".dropdown-heading").css('background','black');
            $(this).find(".dropdown-title").css('color','white');
            $(this).find(".list-unstyled").css('visibility','initial');
            $(this).find(".list-unstyled").css('height','unset');
        }
        $(this).data("clicks", !clicks);
    }); 
},
);

require([ 'jquery', 'jquery/ui'], function($){ 
    $(".qa-utilities-megamenu-content").hide();
    $(window).scroll(function() {
        if ($(window).scrollTop() > 100) {
            $(".tab-menu").css('position','fixed');
            $(".qa-utilities-megamenu-content").fadeIn("slow");
        }
        else {
            $(".tab-menu").css('position','inherit');
            $(".qa-utilities-megamenu-content").fadeOut("fast");
        }
    });
},
);



  