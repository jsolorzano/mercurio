<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Perfiles</h2>
        <ol class="breadcrumb">
            <li>
                <a href="index.html">Inicio</a>
            </li>
            <li>
                <a>Usuarios</a>
            </li>
            <li class="active">
                <strong>Editar Perfiles</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
        <div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Editar Perfil <small></small></h5>
					
				</div>
				<div class="ibox-content">
					<form id="form_perfil" method="post" accept-charset="utf-8" class="form-horizontal">
						<div class="form-group">
							<label class="col-sm-2 control-label" >Nombre</label>
							<div class="col-sm-10">
								<input type="text" class="form-control"  placeholder="Introduzca nombre" name="name" id="name" value="<?php echo $editar[0]->name ?>">
							</div>
						</div>
						<div class="form-group"><label class="col-sm-2 control-label" >modulos</label>
							<div class="col-sm-10">
								<select id="modules_ids" class="form-control" multiple="multiple">
									<?php
									// Primero creamos un arreglo con la lista de ids de modulos proveniente del controlador
									$ids_modules = explode(",",$ids_modules);
									foreach ($modulos as $accion) {
										// Si el id de la módulo está en el arreglo lo marcamos, si no, se imprime normalmente
										if(in_array($accion->id, $ids_modules)){
										?>
										<option selected="selected" value="<?php echo $accion->id; ?>"><?php echo $accion->name; ?></option>
										<?php
										}else{
										?>
										<option value="<?php echo $accion->id; ?>"><?php echo $accion->name; ?></option>
										<?php
										}
									}
									?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" ></label>
							<div class="col-sm-10">
								<!--Tab de servicios-->
								<div class="tabs-container">
									<ul class="nav nav-tabs">
										<li class="active"><a data-toggle="tab" href="#tab-1">Asignar permisos</a></li>
										<!--<li class=""><a data-toggle="tab" href="#tab-2">Productos</a></li>-->
									</ul>
									<div class="tab-content">
										<div id="tab-1" class="tab-pane active">
											<div class="panel-body">
											  <!--<button  class="btn btn-w-m btn-primary" id="i_new_line"><i class="fa fa-plus"></i>&nbsp;Agregar módulo</button>-->
												 <div class="table-responsive">
													<table style="width: 100%" class="table dataTable table-striped table-bordered dt-responsive jambo_table bulk_action" id="tab_modulos">
														<thead>
														<tr>
															<th>Item</th>
															<th>Módulo</th>
															<th>Crear</th>
															<th>Editar</th>
															<th>Eliminar</th>
														</tr>
														</thead>
														<tbody>
															<?php 
															foreach ($profile_modulos as $profile_modulo) {
																foreach ($modulos as $accion) { 
																	// Imprimimos sólo los módulos asociados
																	if($accion->id == $profile_modulo->module_id){ 
																		$parameter1 = $profile_modulo->parameter_permit[0];
																		$parameter2 = $profile_modulo->parameter_permit[1];
																		$parameter3 = $profile_modulo->parameter_permit[2];
																		?>
																		<tr id="<?php echo $id;?>">
																			<td><?php echo $accion->id; ?></td>
																			<td><?php echo $accion->name; ?></td>
																			<?php if($parameter1 == '0'){?>
																				<td><input type="checkbox" id=""></td>
																			<?php }else{ ?>
																				<td><input type="checkbox" id="" checked="checked"></td>
																			<?php } ?>
																			<?php if($parameter2 == '0'){?>
																				<td><input type="checkbox" id=""></td>
																			<?php }else{ ?>
																				<td><input type="checkbox" id="" checked="checked"></td>
																			<?php } ?><?php if($parameter3 == '0'){?>
																				<td><input type="checkbox" id=""></td>
																			<?php }else{ ?>
																				<td><input type="checkbox" id="" checked="checked"></td>
																			<?php } ?>
																		</tr>
																<?php }
																}
															} ?>
														</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>
								<!--Tab de servicios-->
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-4 col-sm-offset-2">
								<input class="form-control"  type='hidden' id="id" name="id" value="<?php echo $id ?>"/>
								<button class="btn btn-white" id="volver" type="button">Volver</button>
								<button class="btn btn-primary" id="edit" type="submit">Actualizar</button>
							</div>
						</div>
					</form>
				</div>
			</div>
        </div>
    </div>
</div>
<script>
$(document).ready(function(){

	$('select').on({
		change: function () {
			$(this).parent('div').removeClass('has-error');
		}
	});
    $('input').on({
        keypress: function () {
            $(this).parent('div').removeClass('has-error');
        }
    });
    
    $('#tab_modulos').DataTable({
		"bLengthChange": false,
		  "iDisplayLength": 10,
		  "iDisplayStart": 0,
		  destroy: true,
		  paging: false,
		  searching: false,
		  "order": [[0, "asc"]],
		  "pagingType": "full_numbers",
		  "language": {"url": "<?= assets_url() ?>js/es.txt"},
		  "aoColumns": [
			  {"sWidth": "1%"},
			  {"sWidth": "10%"},
			  {"sWidth": "4%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false},
			  {"sWidth": "4%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false},
			  {"sWidth": "4%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false}
		  ]
	});

    $('#volver').click(function () {
        url = '<?php echo base_url() ?>profile/';
        window.location = url;
    });
	
	// Función para la interacción del combo select2 y la lista datatable
	$("#modules_ids").on('change', function () {
		
		var ids_modules = $(this).val();
		var data_actions = $(this).select2('data');
		
		// Comparamos los módulos del select con los de la lista y agregamos los que falten
		$.each(data_actions, function (index, value){
			// alert(index + ": " + value.id);
			var contador = 0;  // Para verificar si la módulo ya está en la tabla
			$("#tab_modulos tbody tr").each(function (index){
				var id_module = $(this).find('td').eq(0).text();
			
				if(value.id == id_module){
					contador += 1;
				}
			})
			// Si el módulo no está en la tabla, la añadimos
			if(contador == 0){
				var table = $('#tab_modulos').DataTable();
				var id_new_action = value.id;
				var name_new_action = value.text;
				var permission_new_action = '<input type="checkbox" id="">';
				var i = table.row.add( [ id_new_action, name_new_action, permission_new_action, permission_new_action, permission_new_action ] ).draw();
				table.rows(i).nodes().to$().attr("id", $("#id").val());
			}
		});
		
		// Comparamos los módulos de la lista con los del combo select y eliminamos los que sobren
		$("#tab_modulos tbody tr").each(function (index){
			var id_module = $(this).find('td').eq(0).text();
			var contador2 = 0  // Para verificar si la módulo está en la tabla
			
			// Recorremos la lista de ids capturados del combo select2
			$.each(ids_modules, function (index, value){
				if(id_module == value) {
					contador2 += 1;
				}
			})
			// Si el contador es igual a cero, significa que el módulo ha sido borrado del combo select, por tanto lo quitamos también de la lista
			if(contador2 == 0) {
				// Borramos la línea correspondiente (línea actual)
				var table = $('#tab_modulos').DataTable();
				table.row($(this)).remove().draw();
			}
			
		});

    });
    

    $("#edit").click(function (e) {

        e.preventDefault();  // Para evitar que se envíe por defecto

        if ($('#name').val().trim() === "") {

			swal("Disculpe,", "para continuar debe ingresar nombre");
			$('#name').parent('div').addClass('has-error');
			
        } else if ($('#modules_ids').val() == "") {
          
			swal("Disculpe,", "para continuar debe seleccionar los permisos");
			$('#modules_ids').parent('div').addClass('has-error');
			
        } else {
			//~ alert(String($('#modules_ids').val()));
			
			// Construimos la data de permisología leyendo las filas de la tabla
			var campos= "";
			var data = [];
			$("#tab_modulos tbody tr").each(function () {
				var campo0, campo1, campo2, campo3, campo4, campo5;
				//~ campo0 = $(this).attr('id');  // Id del perfil
				campo1 = $(this).find('td').eq(0).text();
				campo2 = $(this).find('td').eq(1).text();
				if($(this).find('input').eq(0).is(':checked')){
					campo3 = '7';
				}else{
					campo3 = '0';
				}
				if($(this).find('input').eq(1).is(':checked')){
					campo4 = '7';
				}else{
					campo4 = '0';
				}
				if($(this).find('input').eq(2).is(':checked')){
					campo5 = '7';
				}else{
					campo5 = '0';
				}
				
				campos = { "id" : campo1, "accion" : campo2, "crear" : campo3, "editar" : campo4, "eliminar" : campo5 },
				data.push(campos);
			});
			
            $.post('<?php echo base_url(); ?>CPerfil/update', $('#form_perfil').serialize()+'&'+$.param({'modules_ids':$('#modules_ids').val(), 'data':data}), function (response) {
				//~ alert(response);
				if (response[0] == 'e') {
                    swal("Disculpe,", "este nombre de perfil se encuentra registrado");
                    $('#name').parent('div').addClass('has-error');
                }else{
					swal({
						title: "Actualizar",
						 text: "Registro actualizado con exito",
						  type: "success" 
						},
					function(){
						window.location.href = '<?php echo base_url(); ?>profile';
					});
				}
            });
        }
    });
});

</script>
