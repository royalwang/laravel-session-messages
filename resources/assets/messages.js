(function($)
{
    $(document).ready(function()
    {
        $('#messages .msg-box a.close').click(function(Event)
        {
            Event.preventDefault();
            var alertBox = $(this).parent();
            alertBox.fadeOut(700, function() {
                $(this).remove();
            });
        });
        
        $('#messages .msg-box.removable a.close').click(function()
        {
            var $id = $(this).parent().data('messageIndex');
            
            $.ajax({
                url: "/session_message/remove/" + $id,
                type: "GET"
            });
        });
    });
})(jQuery);