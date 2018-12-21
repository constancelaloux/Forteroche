<?php  session_start(); ?>

<?php $title = 'ManageCommentsView'; ?>
<?php include('/Applications/MAMP/htdocs/Forteroche/blogenalaska/Views/Backend/Header.php'); ?>
<?php ob_start(); ?>

<h1>Page de gestion des commentaires</h1>

<?php $content = ob_get_clean(); ?>

<?php require('/Applications/MAMP/htdocs/Forteroche/blogenalaska/Views/Template.php');?>


