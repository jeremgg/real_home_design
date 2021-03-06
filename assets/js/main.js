// Bootstrap specific functions and styling
jQuery(document).ready(function(){

    // here for each comment reply link of WordPress
    // jQuery('.comment-reply-link').addClass('btn btn-sm btn-default');

    // here for the submit button of the comment reply form
    jQuery('html input[type=button], input[type=reset]').addClass('btn btn-default');
    jQuery('#submit, button[type=submit], input[type=submit]').addClass('btn btn-primary');

    // Now we'll add some classes for the WordPress default widgets - let's go
    jQuery('.widget_rss ul').addClass('media-list');

    // Add Bootstrap style for drop-downs
    jQuery('.postform').addClass('form-control');

    // Add Bootstrap styling for tables
    jQuery('table#wp-calendar').addClass('table table-striped');

    jQuery('#submit, .tagcloud, button[type=submit], .comment-reply-link, .widget_rss ul, .postform, table#wp-calendar').show("fast");
});

// jQuery powered scroll to top
jQuery(document).ready(function(){

    //Check to see if the window is top if not then display button
    jQuery(window).scroll(function(){
        if(jQuery(this).scrollTop()>100){
            jQuery(".scroll-to-top").fadeIn()
        }else{
            jQuery(".scroll-to-top").fadeOut()
        }
    });

    //Click event to scroll to top
    jQuery(".scroll-to-top").click(function(){
        jQuery("html, body").animate({scrollTop:0},800);
        return false;
    });
});

// JQuery Sticy Header
jQuery(document).ready(function($){

    $this = $(".navbar-fixed-top");
    $adminbar = $("#wpadminbar");

    if($this.length != 0){
        height = ($adminbar.length != 0) ? Math.abs($this.height() - $adminbar.height()) : $this.height();
        $this.parent("header").css("margin-bottom",height);
    }
});






//
// jQuery(document).ready(function($){
//     $(window).load(function() {
//         jQuery('.element:nth-child(-n+2)').addClass('col-sm-6').removeClass('col-sm-3');
//         jQuery('.element:nth-child(3), .element:nth-child(4), .element:nth-child(5)').addClass('col-sm-4').removeClass('col-sm-3');
//     });
// });
