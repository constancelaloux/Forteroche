<?php  if(!isset($_SESSION))
        {
            session_start();
        }
        
if (isset($_SESSION))
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
        header('Location: /public/index.php?action=getTheFormAdminConnexionBackend');
    }
    
?>
<?php $title = 'backend main page'; ?>
<?php ob_start(); ?>
<?php include('/Applications/MAMP/htdocs/Forteroche/blogenalaska/views/Header.php'); ?>

<section class="articles">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div id="titlePageArticles">
                    <h1>Articles</h1> 
                </div>

                <!--Compter les articles existants en base-->
                <!--Compter les articles publiés-->
                <div class="numberOfArticles">
                    <p>Tous<a href="#">
                        <span class="numberGlobalOfArticles">
                            <!--J'affiche le nombre d'articles présents en base de données!-->
                            <?php echo htmlspecialchars($articlesCount)?>        
                            <!--message d'erreur si l'article n'a pas été complété-->
                            <?php

                                if (!empty($session))
                                    {
                                        $session->flash(); 
                                    }
                            ?>
                        </span>
                    </a></p>
                    <p>Publiés<a href="#"><span class="frontendNumberGlobalOfArticles">
                        <!--J'affiche le nombre d'articles publiés sur le blog-->
                        <?php echo htmlspecialchars($numberOfArticlesPublished)?>
                    </span></a></p>
                </div>

                <button id="hideSaveDatas">Liste des articles publiés</button>
                <button id="hidePublishedDatas">Liste des articles sauvegardés</button>
                <button id="reset">Liste compléte</button>
                <!--Tableau-->
                <!--display-->
                <table id="displayarticles" class="cell-border compact stripe" style="width:100%">
                    <thead>
                        <tr>
                            <th class="all">Numéro</th>
                            <th class="all">Id</th>
                            <th class="all">Sujet</th>
                            <th class="all">Date de création</th>
                            <th class="all">Date de modification</th>
                            <th class="all">Status</th>
                            <th class="all">Supprimer/Modifier</th>
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
                var table = $('#displayarticles').DataTable
                    (
                        {
                            "order": [[ 1, "desc" ]],   
                            processing: true,
                            ajax:
                                {
                                    url :"/public/index.php?action=getArticlesIntoDatatables", // json datasource
                                    type:"POST",
                                    dataType: 'json'
                                },
                            "language": 
                                {
                                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
                                },
                            columnsDefs:
                                [{
                                    "className": 'dt-center',
                                    "targets": [ 0 ],
                                    "visible": false
                                }],
                            columns: 
                                [
                                    {data: null},
                                    {data: "0", visible: false},
                                    {data: "1"},
                                    {data: "2"},
                                    {data: "3"},
                                    {data: "4", visible: false},
                                    {
                                        data: null,
                                        className: "center",
                                        defaultContent: '<button class="btn-delete" type="button">Supprimer</button></td><td><button  class="btn-update" type="button">Modifier</button></td>'
                                    }
                                ]
                        }
                    );
                    // La liste des articles dans le tableau est numéroté
                    //  create index for table at columns zero
                    table.on('order.dt search.dt', function () {
                        table.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
                            cell.innerHTML = i + 1;
                        });
                    }).draw();
                
                    //Boutons
                    if($("#hideSaveDatas").click(function()
                        {
                            $.fn.dataTable.ext.search.push(
                                function(settings, data, dataIndex) 
                                    {
                                        return data[5] !== "Sauvegarder";
                                    }
                            );
                            table.draw();
                            $.fn.dataTable.ext.search.pop();
                        }));

                        
                    if($("#reset").click(function() 
                        {
                            $.fn.dataTable.ext.search.pop();
                            table.draw();
                        }));
                    
                    if($("#hidePublishedDatas").click(function() 
                        {
                            $.fn.dataTable.ext.search.push(
                                function(settings, data, dataIndex) 
                                    {
                                        return data[5] !== "Valider";
                                    }
                            );
                            table.draw();
                            $.fn.dataTable.ext.search.pop();
                        }));
                        
                //Supprimer des articles
                $('#displayarticles').on( 'click', '.btn-delete', function () 
                    {
                        //var id = $(this).attr("id");
                        var datas = table.row( $(this).parents('tr') ).data();
                        var id = datas[ 0 ];
                        //alert(datas[0] +"'s salary is: "+ datas[ 0 ] );

                        if(confirm("Voulez vous supprimer cet article?"))
                            {
                                $.ajax
                                    ({
                                        url:"/public/index.php?action=removeArticles",
                                        method:"POST",
                                        data:{id:id},
                                        dataType: 'html',
                                        success:function(data)
                                            {
                                                table.ajax.reload();
                                                //var url = "/blogenalaska/index.php?action=updateArticles&id="+id;
                                                var url = '/public/index.php?action=mainBackendPage';
                                                window.location.href = url;
                                            },
                                        error:function(response)
                                            {
                                                console.log('ca ne fonctionne pas');
                                            }
                                    });
                            };            
                    } );
                
                //Modifier des articles
                $('#displayarticles').on( 'click', '.btn-update', function (e) 
                    {
                        //e.preventDefault();
                        var datas = table.row( $(this).parents('tr') ).data();
                        var id = datas[ 0 ];
                        //alert(datas[0] +"'s salary is: "+ datas[ 0 ] );

                        //Ici la variable"tr" référence un objet jQuery qui sélectionne toutes les balisesdiv du document.
                        var $tr = $(this).closest('tr');//here we hold a reference to the clicked tr which will be later used to delete the row
                        if(confirm("Voulez vous modifier cet article?"))
                            {
                                var url = "/public/index.php?action=updateArticles&id="+id; 
                                window.location.href = url;                              
                            };            
                    });
            });
    </script>

<?php $content = ob_get_clean(); ?>

<?php require('/Applications/MAMP/htdocs/Forteroche/blogenalaska/views/Template.php');?>