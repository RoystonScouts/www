jQuery.noConflict();
(function($) {
    $(function() {
        var connect_window;
        var _do_connect = function(provider, uri) {
            var width  = 700;
            var height = 450;
            var left   = (screen.width  - width)/2;
            var top    = (screen.height - height)/2;
            var params = 'width='+width+', height='+height;
            params += ', top='+top+', left='+left;
            params += ', directories=no';
            params += ', location=no';
            params += ', menubar=no';
            params += ', resizable=no';
            params += ', scrollbars=1';
            params += ', status=no';
            params += ', toolbar=no';
            
            var connect_window =  window.open(
                uri,
                "SocialAuth_WordPress",
                params
            );
            if (window.focus) {
                connect_window.focus()
            }
            return false;
        };

        function close_me() {
            connect_window.close();
        }

        $(".SocialAuth_WP_login").click(function(e) {
            e.preventDefault();
            var provider= $(this).attr('title');
            var uri = $(this).attr('href');
            _do_connect(provider, uri);
        });
        
    });
})(jQuery);
