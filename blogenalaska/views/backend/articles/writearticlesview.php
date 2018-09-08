<?php $title = 'my articles'; ?>
<?php ob_start(); ?>

    <h1>Heyhey you are arrived in the building articles page</h1>
    <textarea>Next, use our Get Started docs to setup Tiny!</textarea>

 
<?php $content = ob_get_clean(); ?>
<?php require('template.php');?>

