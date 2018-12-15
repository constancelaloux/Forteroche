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
                $('#displayarticles').DataTable
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
                                    //{data: 'createdate'},
                                    //{"subject": "subject"},
                                    {data: "0"},
                                    {data: "1"},
                                    {data: "2"},
                                    {data: "3"},
                                    {data: "4"},
                                    {
                                        data: null,
                                        className: "center",
                                        defaultContent: '<button class="btn-delete" type="button" id="button">Supprimer</button><button type="button" id="buttonmodify">Modifier</button>'
                                    }
                                ]
                        }
                    );
                // Button Edit record
                /*$('#displayarticles').on('click', 'a.editor_update', function (e) {
                    e.preventDefault();

                    editor.update( $(this).closest('tr'), {
                        title: 'Edit record',
                        buttons: 'Modifier'
                    } );
                } );*/

            });
                  //table.destroy();  
            //$('#displayarticles').DataTable().clear();
        //Je supprime les données
        $(document).ready( function ()
            {
                // Button Delete a record
                var table = $('#displayarticles').DataTable();

                $('#displayarticles').on('click', 'tr', function (e) 
                    {
                        table.row( [1]).data([1]);
                        console.log(table.row( this ).data());
                    });

                $(document).on('click','.btn-delete', function (e) 
                    {
                        e.preventDefault();
                        console.log("test");
                        
                        $('#displayarticles').DataTable
                            ({
                                ajax:
                                    {
                                        url :"Location: http://localhost:8888/index.php?action=removeArticles",
                                        type:"POST",
                                        dataType: 'json', //This says I'm expecting a response that is json encoded.
                                        data: 
                                            {  //Set up your post data as an array of key value pairs.
                                                'data' : 0

                                            },
                                        success: function(data){ //data is an json encoded array.

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
                    });
            });
            

    </script>

<?php $backend = ob_get_clean(); ?>
<?php require('/Applications/MAMP/htdocs/Forteroche/blogenalaska/Views/Template.php');?>