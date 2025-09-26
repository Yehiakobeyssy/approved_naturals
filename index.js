$(document).ready(function(){
    $('#contactForm').submit(function(e){
        e.preventDefault();
        var form = $(this);
        $.ajax({
            type: 'POST',
            url: 'common/contact_process.php',
            data: form.serialize(),
            success: function(response){
                alert(response);
                form[0].reset();
            },
            error: function(){
                alert('Error sending message.');
            }
        });
    });
});
