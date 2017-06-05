<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Sub Menús</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url() ?>home">Inicio</a>
            </li>
            
            <li>
                <a href="<?php echo base_url() ?>submenus">Sub Menús</a>
            </li>

            <li class="active">
                <strong>Registrar Sub Menú</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
        <div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Registrar Sub Menús<small></small></h5>
					
				</div>
				<div class="ibox-content">
					<form id="form_submenus" method="post" accept-charset="utf-8" class="form-horizontal">
						<div class="form-group"><label class="col-sm-2 control-label" >Nombre *</label>
							<div class="col-sm-10"><input type="text" class="form-control"  maxlength="100" name="name" id="name"></div>
						</div>
						<div class="form-group"><label class="col-sm-2 control-label" >Ruta *</label>
							<div class="col-sm-10"><input type="text" class="form-control"  maxlength="100" name="route" id="route"></div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" >Menú *</label>
							<div class="col-sm-10">
								<select class="form-control m-b" name="menu_id" id="menu_id">
									<option value="0" selected="">Seleccione</option>
									<?php foreach ($menus as $menu) { ?>
										<option value="<?php echo $menu->id ?>"><?php echo $menu->name ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" >Acción *</label>
							<div class="col-sm-10">
								<select class="form-control m-b" name="action_id" id="action_id">
									<option value="0" selected="">Seleccione</option>
									<?php foreach ($acciones as $accion) { ?>
										<option value="<?php echo $accion->id ?>"><?php echo $accion->name ?></option>
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
        url = '<?php echo base_url() ?>submenus/';
        window.location = url;
    });


    $("#registrar").click(function (e) {

        e.preventDefault();  // Para evitar que se envíe por defecto

        if ($('#name').val().trim() === "") {
          
			swal("Disculpe,", "para continuar debe ingresar el nombre");
			$('#name').parent('div').addClass('has-error');
			
        } else if ($('#route').val().trim() === "") {
          
			swal("Disculpe,", "para continuar debe ingresar la ruta");
			$('#route').parent('div').addClass('has-error');
			
        } else if ($('#menu_id').val().trim() == "0") {
          
			swal("Disculpe,", "para continuar debe seleccionar el menú");
			$('#menu_id').parent('div').addClass('has-error');
			
        } else if ($('#action_id').val().trim() == "0") {
          
			swal("Disculpe,", "para continuar debe seleccionar la acción");
			$('#action_id').parent('div').addClass('has-error');
			
        } else {

            $.post('<?php echo base_url(); ?>CSubMenus/add', $('#form_submenus').serialize(), function (response) {

				if (response == 'existe') {
                    swal("Disculpe,", "este nombre se encuentra registrado");
                }else{
					swal({ 
						title: "Registro",
						 text: "Guardado con exito",
						  type: "success" 
						},
					function(){
					  window.location.href = '<?php echo base_url(); ?>submenus';
					});

				}

            });
        }

    });
});

</script>
