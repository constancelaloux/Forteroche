$(document).ready(function() {
    $('#image').change(function(){
        var file_data = $('#image').prop('files')[0];   
        var form_data = new FormData();                  
        form_data.append('file', file_data);
        $.ajax({
            url: "/uploadimage",
            type: "POST",
            data: form_data,
            contentType: false,
            cache: false,
            processData:false,
            success: function(data)
            {
                //$("#preview").html(data).fadeIn();
                $('#preview').html(data);
                //$("#form")[0].reset();
                //console.log("je passe la");
                //console.log(data);
            },
            error: function(xhr, ajaxOptions, thrownError) 
            {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    });
});


