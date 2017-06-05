<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Franquicias</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url() ?>home">Inicio</a>
            </li>
            
            <li class="active">
                <strong>Lista de Franquicias</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <a href="<?php echo base_url() ?>franchises/register">
            <button class="btn btn-outline btn-primary dim" type="button"><i class="fa fa-plus"></i> Agregar</button></a>
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Listado de Franquicias </h5>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table id="tab_franchises" class="table table-striped table-bordered dt-responsive table-hover dataTables-example" >
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Franquicia</th>
                                    <th>Servicios</th>
                                    <th>Editar</th>
                                    <th>Eliminar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($listar as $franchise) { ?>
                                    <tr style="text-align: center">
                                        <td>
                                            <?php echo $i; ?>
                                        </td>
                                        <td>
                                            <?php echo $franchise->name; ?>
                                        </td>
                                        <td>
											<br>
                                            <?php
                                            // Armamos un arreglo de ids de servicios correspondientes a la franquicia
                                            $services_ids = array();
                                            foreach($list_assignment as $assignment){
												if($assignment->franchise_id == $franchise->id){
													$services_ids[] = $assignment->service_id;
												}
											}
											// Comparamos e imprimimos los nombre de los servicios asociados
                                            foreach ($list_serv as $serv) {
                                                if (in_array($serv->id, $services_ids)){
                                                    echo $serv->name."<br>";
                                                }
                                            }
                                            ?>
                                        </td>
                                        <td style='text-align: center'>
                                            <a href="<?php echo base_url() ?>franchises/edit/<?= $franchise->id; ?>" title="Editar" style='color: #1ab394'><i class="fa fa-edit fa-2x"></i></a>
                                        </td>
                                        <td style='text-align: center'>
                                            
                                            <a class='borrar' id='<?php echo $franchise->id; ?>' style='color: #1ab394' title='Eliminar'><i class="fa fa-trash-o fa-2x"></i></a>
                                        </td>
                                    </tr>
                                    <?php $i++ ?>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


 <!-- Page-Level Scripts -->
<script>
$(document).ready(function(){
    $('#tab_franchises').DataTable({
       "paging": true,
       "lengthChange": false,
       "autoWidth": false,
       "searching": true,
       "ordering": true,
       "info": true,
       dom: '<"html5buttons"B>lTfgitp',
       buttons: [
           { extend: 'copy'},
           {extend: 'csv'},
           {extend: 'excel', title: 'ExampleFile'},
           {extend: 'pdf', title: 'ExampleFile'},

           {extend: 'print',
            customize: function (win){
                   $(win.document.body).addClass('white-bg');
                   $(win.document.body).css('font-size', '10px');

                   $(win.document.body).find('table')
                           .addClass('compact')
                           .css('font-size', 'inherit');
           }
           }
       ],
       "iDisplayLength": 5,
       "iDisplayStart": 0,
       "sPaginationType": "full_numbers",
       "aLengthMenu": [5, 10, 15],
       "oLanguage": {"sUrl": "<?= assets_url() ?>js/es.txt"},
       "aoColumns": [
           {"sClass": "registro center", "sWidth": "5%"},
           {"sClass": "registro center", "sWidth": "20%"},
           {"sClass": "none", "sWidth": "10%"},
           {"sWidth": "3%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false},
           {"sWidth": "3%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false}
       ]
   });
    
    // Validacion para borrar
    $("table#tab_franchises").on('click', 'a.borrar', function (e) {
    e.preventDefault();
    var id = this.getAttribute('id');
    
        swal({
           title: "Borrar registro",
           text: "¿Está seguro de borrar el registro?",
           type: "warning",
           showCancelButton: true,
           confirmButtonColor: "#DD6B55",
           confirmButtonText: "Eliminar",
           cancelButtonText: "Cancelar",
           closeOnConfirm: false,
           closeOnCancel: true
         },
        function(isConfirm){
          if (isConfirm) {
           
               $.post('<?php echo base_url(); ?>franchises/delete/' + id + '', function (response) {
          
                  if (response[0] == "e") {
                     
                       swal({ 
                         title: "Disculpe,",
                          text: "No se puede eliminar se encuentra asociado a un usuario",
                           type: "warning" 
                         },
                         function(){
                           
                       });
                  }else{
                       swal({ 
                         title: "Eliminar",
                          text: "Registro eliminado con exito",
                           type: "success" 
                         },
                         function(){
                           window.location.href = '<?php echo base_url(); ?>franchises';
                       });
                  }
              });
           } 
       });
    }); 
});
        
    </script>
