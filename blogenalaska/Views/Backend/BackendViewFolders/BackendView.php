<?php  session_start(); ?>
<?php print_r($_SESSION['username']);?>

<?php $title = 'backend main page'; ?>
<?php ob_start(); ?>


<!--Tableau-->
<!--display-->
    <table id="displayarticles" class="cell-border compact stripe" style="width:100%">
        <thead>
            <tr>
                <th class="all">Id</th>
                <th class="all">Sujet</th>
                <th class="all">Article</th>
                <th class="all">Date de création</th>
                <th class="all">Date de modification</th>
                <!--<th class="all">Modifier / Supprimer</th>-->
                <th class="all">Supprimer/Modifier</th>
            </tr>
        </thead>
    </table>

<!--requéte ajax-->
    <script type="text/javascript">
        //J'insére les données
        $(document).ready( function () 
            {
                var table = $('#displayarticles').DataTable
                    (
                        {
                            
                            processing: true,
                            //serverSide: true,
                            ajax:
                                {
                                    url :"/blogenalaska/index.php?action=datatablesArticles", // json datasource
                                    type:"POST",
                                    dataType: 'json'
                                    //dataSrc: 'json_data'
                                    //data:"data.json",
                                },
                            columnsDefs:
                                [{
                                    //data: null,
                                    "targets" : '_all'
                                    //"targets": [ 0 ]
                                    //defaultContent : "<button>Edit</button>"
                                }],
                            //"data": "data",
                            columns: 
                                [
                                    {data: "0"},
                                    {data: "1"},
                                    {data: "2"},
                                    {data: "3"},
                                    {data: "4"},
                                    {
                                        data: null,
                                        className: "center",
                                        defaultContent: '<button class="btn-delete" type="button">Supprimer</button></td><td><button type="button">Modifier</button></td>'
                                    }
                                ]
                           /* $(document).on('click','.btn-delete', function (e) 
                            {
                                console.log('test');
                            });*/
                        }
                    );
                    
                $('#displayarticles').on( 'click', '.btn-delete', function () 
                    {
                        //var id = $(this).attr("id");
                        var datas = table.row( $(this).parents('tr') ).data();
                        var id = datas[ 0 ];
                        alert(datas[0] +"'s salary is: "+ datas[ 0 ] );
                        //console.log(id);
 
                        if(confirm("Are you sure you want to remove this?"))
                            {
                                table
                                    .row( $(this).parents('tr') )
                                    .remove()
                                    .draw();
                                $.ajax
                                ({
                                    url:"/blogenalaska/index.php?action=removeArticles?id=id",
                                    method:"GET",
                                    data:{id:id},
                                    dataType: 'html',
                                    success:function(callback)
                                        {
                                            //$('#alert_message').html('<div class="alert alert-success">'+data+'</div>');
              
                                            //fetch_data();
                                            if(callback['success'])
                                            {  //You are checking for true/false not yes or no.
                                                console.log(id);
                                                //table.row( $(this).parents('tr') ).remove().draw();
                                                //$('#displayarticles').DataTable().destroy();
                                                console.log('You successfully deleted the row.');
                                            }
                                        else
                                            {
                                                console.log(id);
                                                console.log(datas);
                                                console.log('The row was not deleted.');
                                                //$('#displayarticles').DataTable().clear();
                                                //$('#displayarticles').DataTable().draw();
                                                //draw();
                                            }
                                        }
                                });
                             };            
                    } );
            });
                // Button Edit record
                /*$('#displayarticles').on('click', 'a.editor_update', function (e) {
                    e.preventDefault();

                    editor.update( $(this).closest('tr'), {
                        title: 'Edit record',
                        buttons: 'Modifier'
                    } );
                } );*/
            

                  //table.destroy();  
            //$('#displayarticles').DataTable().clear();
        //Je supprime les données
        //$(document).ready( function ()
            //{       

                       
           // });
          /*  var table = $('#displayarticles').DataTable;
            $('#displayarticles').on('click', 'tr', function (e) 
                {
                    //console.log("test");
                    
                    var data = table.row($(this).parents('tr'));
                    //console.log(table.row( this ).parents('tr'));
                });



            // Button Delete a record
            $(document).on('click','.btn-delete', function (e) 
                {
                    //var id = $(this).attr("Id");
                    e.preventDefault();
                    console.log("test");
                    //console.log(id);

                    $('#displayarticles').DataTable({
                        ajax:
                            {
                                url :"Location: http://localhost:8888/index.php?action=removeArticles",
                                type:"POST",
                                dataType: 'json', //This says I'm expecting a response that is json encoded.
                                data: 
                                    {  //Set up your post data as an array of key value pairs.
                                        'data' : 0

                                    },
                                success: function(data)
                                    { //data is an json encoded array.

                                        console.log('Data: ' + data); //Going to display whats in data so you can see whats going on.

                                        if(data['success'])
                                            {  //You are checking for true/false not yes or no.
                                                console.log('You successfully deleted the row.');
                                            }
                                        else
                                            {
                                                console.log('The row was not deleted.');
                                            }

                                    }  
                            }    
                    });
                });*/

    </script>

<?php $backend = ob_get_clean(); ?>
<?php require('/Applications/MAMP/htdocs/Forteroche/blogenalaska/Views/Template.php');?>