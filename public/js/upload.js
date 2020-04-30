
function fileSelected(input)
  {
      var file_data = $('#file').prop('files')[0];
      var form_data = new FormData();
      console.log("je passe dans le modal");
      form_data.append('file', file_data);
      $.ajax(
          {
              url         : '/uploadImage',     // point to server-side PHP script 
              dataType    : 'text',           // what to expect back from the PHP script, if anything
              cache       : false,
              contentType : false,
              processData : false,
              data        : form_data,                         
              type        : 'post',
              success     : function(output)
                  {
                      var message;
                      message = $("#newFile").attr("value",output);
                  },
              error: function(xhr, ajaxOptions, thrownError) 
                  {
                      alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                  }
          });
  }

$('#upload').on('click', function(e)
    {
        e.preventDefault();

        var form_data = $("#newFile").val();
        $.ajax(
            {
                url         : '/iGetImageIntoFormFromUploadPath&data='+form_data,     // point to server-side PHP script 
                method      :"GET",
                dataType: 'html',
                data        : form_data,
                success     : function(response)
                    {
                        $('.preview').html(response);
                        $('.valueHidden').attr("value",response);
                    },
                error: function(xhr, ajaxOptions, thrownError) 
                    {
                        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    }      
            });
    });    
