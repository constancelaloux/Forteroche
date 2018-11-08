<?php ob_start(); ?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title><?= $title ?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="views/Envision.css" type="text/css" />
        <!--<link href="public/css/style.css" rel="stylesheet" />-->

            <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    </head>
    <body
     
        <?= $content ?>
        <!--Jquery-->
        <script src="http://code.jquery.com/jquery-2.2.1.min.js"></script>
            <!--Datatables-->
        <script type="text/javascript" src='DataTables/media/js/jquery.js'></script>

        <script type="text/javascript" src="DataTables/media/js/jquery.dataTables.min.js"></script>
        
        <link rel="stylesheet" type="text/css" href="DataTables/media/css/jquery.dataTables.min.css">
        
        <!--tableau-->
        <script type="text/javascript" src="tableau.js"></script>     
    
    </body>
</html>
<?php $content = ob_get_clean(); ?>

