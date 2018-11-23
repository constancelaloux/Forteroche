<?php $title = 'mon blog'; ?>
 <?php include('/Applications/MAMP/htdocs/Forteroche/blogenalaska/views/backend/Header.php'); ?>



<table id="displayarticles" class="display" style="width:100%">
    <thead>
        <tr>
            <th>Nom de l'article</th>
            <th>Auteur</th>
            <th>Date de création</th>
            <th>Date de modification</th>
        </tr>
    </thead>
</table>

<body>

</body>

</html>

<script type="text/javascript">
$(document).ready( function () {
    $('#displayarticles').DataTable();
} );
</script>

<?php include("/Applications/MAMP/htdocs/Forteroche/blogenalaska/views/backend/Footer.php"); ?> 
<?php $content = ob_get_clean(); ?>
<?php require('/Applications/MAMP/htdocs/Forteroche/blogenalaska/views/template.php');