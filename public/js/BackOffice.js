        $(document).ready( function () 
            {
                var table = $('#displayarticles').DataTable
                    (
                        {
                            "order": [[ 1, "desc" ]],   
                            processing: true,
                            ajax:
                                {
                                    url :"/getListOfArticles", // json datasource
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
                                        url:"/removeArticles",
                                        method:"POST",
                                        data:{id:id},
                                        dataType: 'html',
                                        success:function(data)
                                            {
                                                table.ajax.reload();
                                                //var url = "/blogenalaska/index.php?action=updateArticles&id="+id;
                                                var url = '/blogenalaska/index.php?action=mainBackendPage';
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
                                var url = "updateArticles&id="+id; 
                                window.location.href = url;                              
                            };            
                    });
            });


