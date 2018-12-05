<?php $title = 'backend main page'; ?>

<!--Include header-->
<?php include('/Applications/MAMP/htdocs/Forteroche/blogenalaska/Views/Header.php'); ?>

<!--Jquery-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>

<!--Tableau-->
    <table id="displayarticles" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Nom article</th>
                <th>Auteur</th>
                <th>Date de création</th>
                <th>Date de modification</th>
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
                            ajax: "",
                            columns: 
                                [
                                    {data: 'Nom article'},
                                    {data: 'Auteur'},
                                    {data: 'Date de création'},
                                    {data: 'Date de modification'}
                                ]  
                        }
                    );
            } );
    </script>
    
    
<!--Datatables-->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
  
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>

<!--Include Footer et template -->
<?php include("/Applications/MAMP/htdocs/Forteroche/blogenalaska/Views/Footer.php"); ?> 

<?php require('/Applications/MAMP/htdocs/Forteroche/blogenalaska/Views/Template.php');