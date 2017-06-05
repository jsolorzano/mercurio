<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Servicios </h2>
        <ol class="breadcrumb">
            <li>
                <a href="index.html">Inicio</a>
            </li>
            
            <li>
                <a href="<?php echo base_url() ?>services">Servicios</a>
            </li>
           
            <li class="active">
                <strong>Editar Servicio</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
        <div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Editar Servicio <small></small></h5>
				</div>
				<div class="ibox-content">
					<form id="form_services" method="post" accept-charset="utf-8" class="form-horizontal">
						<div class="form-group">
							<label class="col-sm-2 control-label" >Nombre *</label>
							<div class="col-sm-10">
								<input type="text" class="form-control"   name="name" id="name" maxlength="150" value="<?php echo $editar[0]->name ?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" >Descripción *</label>
							<div class="col-sm-10">
								<input type="text" class="form-control"  name="description" maxlength="200" id="description" value="<?php echo $editar[0]->description ?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" >Precio *</label>
							<div class="col-sm-10">
								<input type="text" class="form-control"  name="price" maxlength="11" id="price" value="<?php echo $editar[0]->price ?>">
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
        url = '<?php echo base_url() ?>services/';
        window.location = url;
    });
	
	$("#status").val($("#id_status").val());

    $("#edit").click(function (e) {

        e.preventDefault();  // Para evitar que se envíe por defecto

        if ($('#name').val().trim() === "") {

          
			swal("Disculpe,", "para continuar debe ingresar nombre");
			$('#name').parent('div').addClass('has-error');
			
        } else if ($('#description').val().trim() === "") {

          
			swal("Disculpe,", "para continuar debe ingresar la descripción");
			$('#description').parent('div').addClass('has-error');
			
        }else if ($('#price').val().trim() === "") {

          
			swal("Disculpe,", "para continuar debe ingresar el precio");
			$('#price').parent('div').addClass('has-error');
			
        }   else {

            $.post('<?php echo base_url(); ?>CServices/update', $('#form_services').serialize(), function (response) {

				if (response[0] == '1') {
                    swal("Disculpe,", "este nombre se encuentra registrado");
                }else{
					swal({ 
						title: "Actualizar",
						 text: "Guardado con exito",
						  type: "success" 
						},
					function(){
					  window.location.href = '<?php echo base_url(); ?>services';
					});
				}
            });
        }
    });
});

</script>
