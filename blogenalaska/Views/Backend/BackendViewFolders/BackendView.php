<?php $title = 'backend main page'; ?>

<!--Include header-->
<?php include('/Applications/MAMP/htdocs/Forteroche/blogenalaska/Views/Header.php'); ?>

<!--Jquery-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>

<!--Tableau-->
<!--display-->
    <table id="displayarticles" class="cell-border compact stripe" style="width:100%">
        <thead>
            <tr>
                <th class="all">Sujet</th>
                <th class="all">Article</th>
                <th class="all">Date de création</th>
                <th class="all">Date de modification</th>
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
                            serverSide: true,
                            ajax:
                                {
                                    url :"/blogenalaska/index.php?action=datatablesArticles", // json datasource
                                    type:"POST",
                                    dataType: 'json',
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
                                    {data: "data"},
                                    {data: "content"}
                                    //{data: 'Auteur'},
                                    //{data: 'Date de création'},
                                    //{data: 'Date de modification'}
                                ]
                        //    "success" : function(data)
                        //        {
                        //            console.log('form has been posted successfully');
                        //        },
                        //    "error" : function(data)
                        //        {
                        //            console.log('form has not been posted successfully');
                                    //console.log();
			//	}
                        }
                    );
            });
    </script>
        
    
<!--Datatables-->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
  
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>

<!--Include Footer et template -->
<?php include("/Applications/MAMP/htdocs/Forteroche/blogenalaska/Views/Footer.php"); ?> 

<?php require('/Applications/MAMP/htdocs/Forteroche/blogenalaska/Views/Template.php');