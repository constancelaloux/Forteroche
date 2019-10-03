<?php  if(!isset($_SESSION))
        {
            session_start();
        }
        
if (isset($_SESSION['username']))
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

                    <p>Commentaires publiés<a href="#"><span class="numberGlobalOfComments"><?php echo htmlspecialchars($globalCommentsCount)?></span></a></p>
                    <p>commentaires signalés<a href="#"><span class="unwantedComments"><?php echo htmlspecialchars($unwantedCommentsCount)?></span></a></p>
                </div>

                <!--Tableau-->
                <!--display-->
                <table id="displayComments" class="cell-border compact stripe" style="width:100%">
                    <thead>
                        <tr>
                            <th class="all">Numéro</th>
                            <th class="all">Id</th>
                            <th class="all">Date de création</th>
                            <th class="all">Date de modification</th>
                            <th class="all">Nom du Chapitre</th>
                            <th class="all">Contenu</th>
                            <th class="all">Nombre de clicks</th>
                            <th class="all">Supprimer/Valider</th>
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
                            "order": [[ 6, "desc" ]],
                            processing: true,
                            ajax:
                                {
                                    url :"/blogenalaska/index.php?action=getCommentsIntoDatatables", // json datasource
                                    type:"POST",
                                    dataType: 'json'
                                },
                            "language": 
                                {
                                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
                                },
                            columnsDefs:
                                [{
                                    "className": 'dt-center'
                                }],
                            columns: 
                                [
                                    {data: null},
                                    {data: "0", visible: false},
                                    {data: "1"},
                                    {data: "2"},
                                    {data: "3"},
                                    {data: "4"},
                                    {data: "5"},
                                    {
                                        className: "center",
                                        defaultContent: '<td><button class="btn-delete" type="button">Supprimer</button></td><td><button class="btn-validate" type="button">Valider le commentaire</button></td>'
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
                        var datas = table.row( $(this).parents('tr') ).data();
                        var id = datas[ 0 ];
                        alert(datas[0] +"'le numero en : base est"+ datas[ 0 ] );
                        
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
                                                table.ajax.reload();
                                                var url = '/blogenalaska/index.php?action=getCommentsViewDatatables';
                                                window.location.href = url;
                                            },
                                        error:function(response)
                                            {
                                                console.log('ca ne fonctionne pas');
                                            }
                                    });
                             };            
                    } );
                    
                    
                //Valider un article
                $('#displayComments').on( 'click', '.btn-validate', function () 
                    {
                        var datas = table.row( $(this).parents('tr') ).data();
                        var id = datas[ 0 ];
                        alert(datas[0] +"'s salary is: "+ datas[ 0 ] );

                        if(confirm("Are you sure you want to validate this?"))
                            {
                                $.ajax
                                ({
                                    url:"/blogenalaska/index.php?action=validateArticles",
                                    method:"POST",
                                    data:{id:id},
                                    dataType: 'html',
                                    success:function(data)
                                        {
                                            table.ajax.reload();
                                                var url = '/blogenalaska/index.php?action=getCommentsViewDatatables';
                                                window.location.href = url;
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


