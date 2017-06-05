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
									<option value="0" selected="">Seleccione</option>
									<?php foreach ($list_franq as $franq) { ?>
										<option value="<?php echo $franq->id ?>"><?php echo $franq->name ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" >Servicios *</label>
							<div class="col-sm-10">
								<select class="form-control m-b" name="service_id" id="services" multiple="multiple">
									<?php foreach ($list_serv as $serv) { ?>
										<option value="<?php echo $serv->id ?>"><?php echo $serv->name ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-4 col-sm-offset-2">
								<button class="btn btn-white" id="volver" type="button">Volver</button>
								<button class="btn btn-primary" id="registrar" type="submit">Guardar</button>
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


    $("#registrar").click(function (e) {

        e.preventDefault();  // Para evitar que se envíe por defecto

        if ($('#franchises').val() == '0') {
			
		  swal("Disculpe,", "para continuar debe seleccionas la franquicia");
	       $('#profile').parent('div').addClass('has-error');
		   
		}  else if ($('#services').val() == "") {
			
		  swal("Disculpe,", "para continuar debe seleccionar el(los) servicio(s)");
	       $('#profile').parent('div').addClass('has-error');
		   
        }  else {
			//~ alert(String($('#services').val()));

            $.post('<?php echo base_url(); ?>CAssignment/add', $('#form_assignment').serialize()+'&'+$.param({'services_ids':$('#services').val()}), function (response) {
				//~ alert(response);
				if (response == 'existe') {
                    swal("Disculpe,", "ya se encuentra registrado");
                }else{
					swal({ 
						title: "Registro",
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
