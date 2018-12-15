<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title><?= $title ?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <!--CSS-->
        <!--<link href="public/css/style.css" rel="stylesheet" />-->
        
        <!--Jquery-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
        
        <!--Datatables-->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
        
        <!--Tinymce-->
        <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
        <!--<script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=your_API_key"></script> -->
    </head>
    
    <body>
        <!--Menu-->
        <?php if (isset($_SESSION['username'])) 
            { 
                //Session
                print_r("im authentificated");
                //Header
                include('/Applications/MAMP/htdocs/Forteroche/blogenalaska/Views/Backend/Header.php'); 
        ?>        
                <!--On affiche le contenu-->
                <?= $backend ?>
        <?php 
                //Footer
                include('/Applications/MAMP/htdocs/Forteroche/blogenalaska/Views/Backend/Footer.php');
            }
        else 
            {
        ?> 
                <!--On affiche le contenu-->
                <?= $content ?>
        <?php
            }
        ?>


    </body>

</html>

