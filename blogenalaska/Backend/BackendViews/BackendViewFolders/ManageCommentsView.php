<?php  session_start(); ?>
<?php if (isset($_SESSION['username']))
    {
        $expireAfter = 30;

        //Check to see if our "last action" session
        //variable has been set.
        if(isset($_SESSION['last_action']))
            {

                //Figure out how many seconds have passed
                //since the user was last active.
                $secondsInactive = time() - $_SESSION['last_action'];

                //Convert our minutes into seconds.
                $expireAfterSeconds = $expireAfter * 60;

                //Check to see if they have been inactive for too long.
                if($secondsInactive >= $expireAfterSeconds)
                    {
                        //print_r("ma session est inactive");
                        //User has been inactive for too long.
                        //Kill their session.
                        session_unset();
                        session_destroy();

                        header('Location: /blogenalaska/index.php?action=getTheFormAdminConnexionBackend');
                    }
            }

        //Assign the current timestamp as the user's
        //latest activity
        $_SESSION['last_action'] = time();
    }
else 
    {
        header('Location: /blogenalaska/index.php?action=getTheFormAdminConnexionBackend');
    }
?>

<?php $title = 'ManageCommentsView'; ?>
<?php include('/Applications/MAMP/htdocs/Forteroche/blogenalaska/Backend/BackendViews/Header.php'); ?>
<?php ob_start(); ?>

<section class="comments">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div id="titlePageComments">
                    <h1>Page de gestion des commentaires</h1>
                </div>

                <!--Compter les commentaires existants en base-->
                <!--Compter les commentaires publiés-->
                <div class="numberOfComments">

                    <p>Tous<a href="#"><span class="numberGlobalOfComments"><?php echo $commentsCount ?></span></a></p>
                    <p>commentaires signalés<a href="#"><span class="frontendNumberGlobalOfComments"></span></a></p>
                </div>

                <!--Tableau-->
                <!--display-->
                <table id="displayComments" class="cell-border compact stripe" style="width:100%">
                    <thead>
                        <tr>
                            <th class="all">Numéro</th>
                            <th class="all">Id</th>
                            <th class="all">Date de création</th>
                            <th class="all">Contenu</th>
                            <th class="all">Supprimer</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</section>
<!--requéte ajax-->
    <script type="text/javascript">
        //J'insére les données
        $(document).ready( function () 
            {
                var table = $('#displayComments').DataTable
                    (
                        {   
                            processing: true,
                            //serverSide: true,
                            ajax:
                                {
                                    url :"/blogenalaska/index.php?action=getCommentsIntoDatatables", // json datasource
                                    type:"POST",
                                    dataType: 'json'
                                    //dataSrc: 'json_data'
                                    //data:"data.json",
                                },
                            "language": 
                                {
                                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
                                },
                            columnsDefs:
                                [{
                                    "className": 'dt-center',
                                    //"targets": [ 0 ]
                                    //"visible": false
                                }],
                            //"data": "data",
                            columns: 
                                [
                                    {data: null},
                                    {data: "0", visible: false},
                                    {data: "1"},
                                    {data: "2"},
                                    {
                                       // data: null,
                                        className: "center",
                                        defaultContent: '<button class="btn-delete" type="button">Supprimer</button></td><td></td>'
                                    }
                                ]
                        }
                    );
                                       // La liste des articles dans le tableau est numéroté
                    //  create index for table at columns zero
                    table.on('order.dt search.dt', function () 
                        {
                            table.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
                                cell.innerHTML = i + 1;
                            });
                        }).draw();
                    
                    //Supprimer des articles
                $('#displayComments').on( 'click', '.btn-delete', function () 
                    {
                        //var id = $(this).attr("id");
                        var datas = table.row( $(this).parents('tr') ).data();
                        var id = datas[ 0 ];
                        alert(datas[0] +"'le numero en : base est"+ datas[ 0 ] );
                        //console.log(id);
                        //Ici la variable"tr" référence un objet jQuery qui sélectionne toutes les balisesdiv du document.
                        //var $tr = $(this).closest('tr');//here we hold a reference to the clicked tr which will be later used to delete the row
                        if(confirm("Voulez vous supprimer ce commentaire?"))
                            {
                                $.ajax
                                    ({
                                        url:"/blogenalaska/index.php?action=removeComments",
                                        method:"POST",
                                        data:{id:id},
                                        dataType: 'html',
                                        success:function(data)
                                            {
                                                console.log('c cool');
                                                console.log(data);
                                                table.ajax.reload();
                                            },
                                        error:function(response)
                                            {
                                                console.log('ca ne fonctionne pas');
                                            }
                                    });
                             };            
                    } );
                    
                
            });
    </script>

<?php $content = ob_get_clean(); ?>

<?php require('/Applications/MAMP/htdocs/Forteroche/blogenalaska/Template.php');?>


