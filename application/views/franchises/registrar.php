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
                <strong>Registrar Franquicias</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
        <div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Registrar Franquicias <small></small></h5>
					
				</div>
				<div class="ibox-content">
					<form id="form_franchises" method="post" accept-charset="utf-8" class="form-horizontal">
						<div class="form-group">
							<label class="col-sm-2 control-label" >Nombre *</label>
							<div class="col-sm-10">
								<input type="text" class="form-control"   name="name" id="name">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" >Dirección *</label>
							<div class="col-sm-10">
								<input type="text" class="form-control"  name="address" id="address">
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
							<label class="col-sm-2 control-label" >Servicios</label>
							<div class="col-sm-10">
								<select class="form-control m-b" id="services" multiple="multiple">
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
        url = '<?php echo base_url() ?>franchises/';
        window.location = url;
    });


    $("#registrar").click(function (e) {

        e.preventDefault();  // Para evitar que se envíe por defecto

        if ($('#name').val().trim() === "") {

          
			swal("Disculpe,", "para continuar debe ingresar nombre");
			$('#name').parent('div').addClass('has-error');
			
        } else if ($('#address').val().trim() === "") {

          
			swal("Disculpe,", "para continuar debe ingresar la direccion");
			$('#address').parent('div').addClass('has-error');
			
        }  else {
			//~ alert(String($('#services').val()));

            $.post('<?php echo base_url(); ?>CFranchises/add', $('#form_franchises').serialize()+'&'+$.param({'services_ids':$('#services').val()}), function (response) {
				//~ alert(response);
				if (response == 'existe') {
                    swal("Disculpe,", "esta franquicia se encuentra registrada");
                }else{
					swal({ 
						title: "Registro",
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
