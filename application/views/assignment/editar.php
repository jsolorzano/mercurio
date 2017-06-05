<div class="row wrapper border-bottom white-bg page-heading">
     <div class="col-lg-10">
        <h2>Franquicias </h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url() ?>home">Inicio</a>
            </li>
            
            <li>
                <a href="<?php echo base_url() ?>assignment">Asignación de Servicios</a>
            </li>
            
            <li class="active">
                <strong>Asignar Servicio</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
        <div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Asignar Servicios <small></small></h5>
				</div>
				<div class="ibox-content">
					<form id="form_assignment" method="post" accept-charset="utf-8" class="form-horizontal">
						<div class="form-group">
							<label class="col-sm-2 control-label" >Franquicia *</label>
							<div class="col-sm-10">
								<select class="form-control m-b" name="franchise_id" id="franchises">
									<?php foreach ($list_franq as $franq) { ?>
										<?php if ($franq->id == $id) { ?>
										<option selected="selected" value="<?php echo $franq->id ?>"><?php echo $franq->name ?></option>
										<?php } ?>
									<?php } ?>
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
        url = '<?php echo base_url() ?>assignment/';
        window.location = url;
    });

    $("#edit").click(function (e) {

        e.preventDefault();  // Para evitar que se envíe por defecto

		if ($('#franchises').val() == '') {
			
		  swal("Disculpe,", "para continuar debe seleccionar la franquicia");
	       $('#profile').parent('div').addClass('has-error');
		   
		}  else if ($('#services_ids').val() == '') {
			
		  swal("Disculpe,", "para continuar debe seleccionar los servicios");
	       $('#profile').parent('div').addClass('has-error');
		   
        }   else {

            $.post('<?php echo base_url(); ?>CAssignment/update', $('#form_assignment').serialize()+'&'+$.param({'services_ids':$('#services_ids').val()}), function (response) {

				if (response[0] == '1') {
                    swal("Disculpe,", "ya se encuentra registrado");
                }else{
					swal({ 
						title: "Actualizar",
						 text: "Guardado con exito",
						  type: "success" 
						},
					function(){
					  window.location.href = '<?php echo base_url(); ?>assignment';
					});
				}
            });
        }
    });
});

</script>
