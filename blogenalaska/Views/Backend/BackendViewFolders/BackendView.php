<?php  session_start(); ?>
<?php print_r($_SESSION['username']);?>
  <?php // exit("je sors"); //include('/Applications/MAMP/htdocs/Forteroche/blogenalaska/Views/Backend/Header.php'); ?>
<?php $title = 'backend main page'; ?>
<?php ob_start(); ?>
<!--Include header-->


<!--Jquery-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>

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
                <th class="all">Modifier / Supprimer</th>
            </tr>
        </thead>
    </table>

<!--requéte ajax-->
    <script type="text/javascript">
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
                                        defaultContent: '<a href="" class="editor_update">Modifier</a> / <a href="" class="editor_remove">Supprimer</a>'
                                    }
                                ]
                        }
                    );
                // Button Edit record
                $('#displayarticles').on('click', 'a.editor_update', function (e) {
                    e.preventDefault();

                    editor.update( $(this).closest('tr'), {
                        title: 'Edit record',
                        buttons: 'Modifier'
                    } );
                } );

                // Button Delete a record
                $('#displayarticles').on('click', 'a.editor_remove', function (e) {
                    e.preventDefault();

                    editor.remove( $(this).closest('tr'), {
                        title: 'Delete record',
                        message: 'Are you sure you wish to remove this record?',
                        buttons: 'Supprimer'
                    } );
                    
                    $.ajax
                        ({
                            url :"/blogenalaska/index.php?action=removeDatatablesArticles"
                        });
                });
            });
    </script>
        
    
<!--Datatables-->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
  
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>

<!--Include Footer et template -->
<?php //include("/Applications/MAMP/htdocs/Forteroche/blogenalaska/Views/Backend/Footer.php"); ?> 


<?php $backend = ob_get_clean(); ?>
<?php require('/Applications/MAMP/htdocs/Forteroche/blogenalaska/Views/Template.php');?>