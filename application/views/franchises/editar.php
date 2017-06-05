<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Franquicias </h2>
        <ol class="breadcrumb">
            <li>
                <a href="index.html">Inicio</a>
            </li>
            <li>
                <a>Franquicias</a>
            </li>
            <li class="active">
                <strong>Editar Franquicias</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
        <div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Editar Franquicias <small></small></h5>
				</div>
				<div class="ibox-content">
					<form id="form_franchises" method="post" accept-charset="utf-8" class="form-horizontal">
						<div class="form-group">
							<label class="col-sm-2 control-label" >Nombre *</label>
							<div class="col-sm-10">
								<input type="text" class="form-control"   name="name" id="name" value="<?php echo $editar[0]->name ?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" >Dirección *</label>
							<div class="col-sm-10">
								<input type="text" class="form-control"  name="address" id="address" value="<?php echo $editar[0]->address ?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" >Estatus *</label>
							<div class="col-sm-10">
								<select class="form-control m-b" name="status" id="status">
									<option value="1" selected="">Activo</option>
									<option value="0">Inactivo</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" >Servicio *</label>
							<div class="col-sm-10">
								<select class="form-control m-b" id="services_ids" multiple="multiple">									
									<?php
									// Primero creamos un arreglo con la lista de ids de servicios proveniente del controlador
									$ids_services = explode(",",$ids_services);
									foreach ($list_serv as $serv) {
										// Si el id del servicio está en el arreglo, lo marcamos, si no, se imprime normalmente
										if(in_array($serv->id, $ids_services)){
										?>
										<option selected="selected" value="<?php echo $serv->id; ?>"><?php echo $serv->name; ?></option>
										<?php
										}else{
										?>
										<option value="<?php echo $serv->id; ?>"><?php echo $serv->name; ?></option>
										<?php
										}
									}
									?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-4 col-sm-offset-2">
								 <input id="id_status" type="hidden" value="<?php echo $editar[0]->status ?>"/>
								 <input class="form-control"  type='hidden' id="id" name="id" value="<?php echo $id ?>"/>
								<button class="btn btn-white" id="volver" type="button">Volver</button>
								<button class="btn btn-primary" id="edit" type="submit">Guardar</button>
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

    $('input').on({
        keypress: function () {
            $(this).parent('div').removeClass('has-error');
        }
    });

    $('#volver').click(function () {
        url = '<?php echo base_url() ?>franchises/';
        window.location = url;
    });
	
	$("#status").val($("#id_status").val());

    $("#edit").click(function (e) {

        e.preventDefault();  // Para evitar que se envíe por defecto

        if ($('#name').val().trim() === "") {

          
			swal("Disculpe,", "para continuar debe ingresar nombre");
			$('#name').parent('div').addClass('has-error');
			
        } else if ($('#address').val().trim() === "") {

          
			swal("Disculpe,", "para continuar debe ingresar la direccion");
			$('#address').parent('div').addClass('has-error');
			
        }  else {

            $.post('<?php echo base_url(); ?>CFranchises/update', $('#form_franchises').serialize()+'&'+$.param({'services_ids':$('#services_ids').val()}), function (response) {

				if (response == 'existe') {
                    swal("Disculpe,", "este nombre se encuentra registrado");
                }else{
					swal({ 
						title: "Actualizar",
						 text: "Guardado con exito",
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

</script>
