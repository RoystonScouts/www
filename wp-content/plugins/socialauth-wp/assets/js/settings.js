jQuery.noConflict();
(function($) {
    $(function() {
        $(".SocialAuth_WP_adaptor_status").click(function(){ 
            var parentTd = $(this).parents('td')[0];
            if($(parentTd).find("ul").length >= 1)
            {
                if($(this).val() == "1") {
                    $(parentTd).find("ul").show();
                } else {
                    $(parentTd).find("ul").hide();
                }
            }
        });
        
        $(".SocialAuth_WP_adaptor_status").each(function() {
             if($(this).attr("checked") == 'checked') {
                 $(this).click();
             }
        });
    });
})(jQuery);
