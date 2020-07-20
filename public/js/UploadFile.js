$(document).ready(function() {
    $('#slugimage').change(function(){
        var file_data = $('#slugimage').prop('files')[0];   
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
                //$('#preview').html(data);
                $('#preview img').attr('src',data);
                $('.image').attr("value",data);
            },
            error: function(xhr, ajaxOptions, thrownError) 
            {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    });
});


