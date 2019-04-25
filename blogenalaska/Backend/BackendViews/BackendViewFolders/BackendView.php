<?php  session_start(); 
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
<?php $title = 'backend main page'; ?>
<?php ob_start(); ?>
<?php include('/Applications/MAMP/htdocs/Forteroche/blogenalaska/Backend/BackendViews/Header.php'); ?>

<div class="articles">
    <div id="titlePageArticles">
        <h1>Articles</h1> 
    </div>

    <!--Compter les articles existants en base-->
    <!--Compter les articles publiés-->
        <div class="numberOfArticles">

            <p>Tous<a href="#"><span class="numberGlobalOfArticles"><?php echo $articlesCount ?></span></a></p>
            <p>Publiés<a href="#"><span class="frontendNumberGlobalOfArticles"></span></a></p>
        </div>

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
                    <th class="all">Supprimer/Modifier</th>
                </tr>
            </thead>
        </table>
</div>
<!--requéte ajax-->
    <script type="text/javascript">
        //J'insére les données
        $(document).ready( function () 
            {
                var table = $('#displayarticles').DataTable
                    (
                        {
                            
                            processing: true,
                            //serverSide: true,
                            ajax:
                                {
                                    url :"/blogenalaska/index.php?action=getArticlesIntoDatatables", // json datasource
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
                                    //data: null,
                                    //"targets" : '_all',
                                    "className": 'dt-center',
                                    "targets": [ 0 ],
                                    "visible": false
                                    //"targets": [ 0 ]
                                    //defaultContent : "<button>Edit</button>"
                                }],
                            //"data": "data",
                            columns: 
                                [
                            {data: null},
                                    {data: "0", visible: false},
                                    {data: "1"},
                                    {data: "2"},
                                    {data: "3"},
                                    {
                                        data: null,
                                        className: "center",
                                        defaultContent: '<button class="btn-delete" type="button">Supprimer</button></td><td><button  class="btn-update" type="button">Modifier</button></td>'
                                    }
                                ]
                               
                           /* $(document).on('click','.btn-delete', function (e) 
                            {
                                console.log('test');
                            });*/
                        }
                    );
                    // La liste des articles dans le tableau est numéroté
                    //  create index for table at columns zero
                    table.on('order.dt search.dt', function () {
                        table.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
                            cell.innerHTML = i + 1;
                        });
                    }).draw();
                
                //Supprimer des articles
                $('#displayarticles').on( 'click', '.btn-delete', function () 
                    {
                        //var id = $(this).attr("id");
                        var datas = table.row( $(this).parents('tr') ).data();
                        var id = datas[ 0 ];
                        alert(datas[0] +"'s salary is: "+ datas[ 0 ] );
                        //console.log(id);
                        //Ici la variable"tr" référence un objet jQuery qui sélectionne toutes les balisesdiv du document.
                        //var $tr = $(this).closest('tr');//here we hold a reference to the clicked tr which will be later used to delete the row
                        if(confirm("Are you sure you want to remove this?"))
                            {
                                //table
                                //    .row( $(this).parents('tr') )
                                //    .remove()
                                //    .draw();
                                $.ajax
                                ({
                                    url:"/blogenalaska/index.php?action=removeArticles",
                                    method:"POST",
                                    data:{id:id},
                                    dataType: 'html',
                                    success:function(data)
                                        {
                                            console.log('c cool');
                                            console.log(data);
                                            table.ajax.reload();
                                            /*$tr.find('td').fadeOut(1000,function()
                                                { 
                                                    $tr.remove();
                                                });*/
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
                        //var id = $(this).attr("id");
                        var datas = table.row( $(this).parents('tr') ).data();
                        var id = datas[ 0 ];
                        alert(datas[0] +"'s salary is: "+ datas[ 0 ] );
                        //console.log(id);
                        //Ici la variable"tr" référence un objet jQuery qui sélectionne toutes les balisesdiv du document.
                        var $tr = $(this).closest('tr');//here we hold a reference to the clicked tr which will be later used to delete the row
                        if(confirm("Are you sure you want to update this?"))
                            {
                                console.log('test');
                        //var NestId = $(this).data('id');
                        var url = "/blogenalaska/index.php?action=updateArticles&id="+id; 
                        window.location.href = url;
                                //table
                                //    .row( $(this).parents('tr') )
                                //    .remove()
                                //    .draw();*/
                                /*$.ajax
                                ({
                                    processing: true,
                                    serverSide: true,
                                    url:"/blogenalaska/index.php?action=updateArticles",
                                    method:"POST",
                                    data:{id:id},
                                    dataType: 'html',
                                    success:function(data)*/
                                    /*    {
                                            console.log('datatables');
                                            //data = JSON.parse(data);
                                            //if(data['login_status']) {
                                            //location.replace("index.php")
                                            //}
                                            //table.ajax.reload();
                                            //window.location.href = "/blogenalaska/Backend/BackendViews/BackendViewFolders/ModifyArticlesView.php";
                                            //console.log('c cool je vais modifier les données');
                                        },
                                    error:function(data)
                                        {
                                            console.log('ca ne fonctionne pas');
                                        }
                                });*/
                                
                             };            
                    } );
            });
                // Button Edit record
                /*$('#displayarticles').on('click', 'a.editor_update', function (e) {
                    e.preventDefault();

                    editor.update( $(this).closest('tr'), {
                        title: 'Edit record',
                        buttons: 'Modifier'
                    } );
                } );*/
            

                  //table.destroy();  
            //$('#displayarticles').DataTable().clear();
        //Je supprime les données
        //$(document).ready( function ()
            //{       

                       
           // });
          /*  var table = $('#displayarticles').DataTable;
            $('#displayarticles').on('click', 'tr', function (e) 
                {
                    //console.log("test");
                    
                    var data = table.row($(this).parents('tr'));
                    //console.log(table.row( this ).parents('tr'));
                });



            // Button Delete a record
            $(document).on('click','.btn-delete', function (e) 
                {
                    //var id = $(this).attr("Id");
                    e.preventDefault();
                    console.log("test");
                    //console.log(id);

                    $('#displayarticles').DataTable({
                        ajax:
                            {
                                url :"Location: http://localhost:8888/index.php?action=removeArticles",
                                type:"POST",
                                dataType: 'json', //This says I'm expecting a response that is json encoded.
                                data: 
                                    {  //Set up your post data as an array of key value pairs.
                                        'data' : 0

                                    },
                                success: function(data)
                                    { //data is an json encoded array.

                                        console.log('Data: ' + data); //Going to display whats in data so you can see whats going on.

                                        if(data['success'])
                                            {  //You are checking for true/false not yes or no.
                                                console.log('You successfully deleted the row.');
                                            }
                                        else
                                            {
                                                console.log('The row was not deleted.');
                                            }

                                    }  
                            }    
                    });
                });*/

    </script>

<?php $content = ob_get_clean(); ?>

<?php require('/Applications/MAMP/htdocs/Forteroche/blogenalaska/Template.php');?>