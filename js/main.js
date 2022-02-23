    $('#server-ip').keypress(function( e ) {
    if(e.which === 32) 
        return false;
});
    //Post APi Server
    $(".server-check").on('click', function() {
        var button_check = $(".server-check");
        button_check.html("Checking...");
        $(".result").html('<center><div class="server-spinner"></div></center>');
        $.ajax({
          url: '/check/function.php',
          type: 'POST',
          data: {
            server: $("#server-ip").val(),
            access: 1
        },
        success: function(s) {
            $(".result").html(s);
            button_check.html("Check");
            window.location.href="#server-result";
        }
    });
    });