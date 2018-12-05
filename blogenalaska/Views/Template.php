<?php ob_start(); ?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title><?= $title ?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link href="public/css/style.css" rel="stylesheet" />

    </head>
    
    <body>

        <?= $content ?>
        
    </body>

</html>

<?php $content = ob_get_clean(); ?>

