jQuery.noConflict();
(function($) {
    $(function() {
        $("#providerlist").sortable({opacity: 0.6, cursor: 'move', 
            update: function(event, ui){
                $(this).find('li').each(
                    function(index){
                        var IconClass = $(this).attr('class');
                        $('input.' + IconClass).val(index);
                    }
                );
            }
        });
    });
})(jQuery);
