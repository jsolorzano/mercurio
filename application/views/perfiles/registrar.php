<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Perfiles </h2>
        <ol class="breadcrumb">
            <li>
                <a href="index.html">Inicio</a>
            </li>
            <li>
                <a>Usuarios</a>
            </li>
            <li class="active">
                <strong>Registrar Perfiles</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
        <div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Registrar Perfil <small></small></h5>
				</div>
				<div class="ibox-content">
					<form id="form_perfil" method="post" accept-charset="utf-8" class="form-horizontal">
						<div class="form-group">
							<label class="col-sm-2 control-label" >Nombre</label>
							<div class="col-sm-10">
								<input type="text" class="form-control"  placeholder="Introduzca nombre" name="name" id="name">
							</div>
						</div>
						<div class="form-group"><label class="col-sm-2 control-label" >Módulos</label>
							<div class="col-sm-10">
								<select id="modules_ids" class="form-control" multiple="multiple">
									<?php
									foreach ($modulos as $modulo) {
										?>
										<option value="<?php echo $modulo->id; ?>"><?php echo $modulo->name; ?></option>
										<?php
									}
									?>
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

    $('#volver').click(function () {
        url = '<?php echo base_url() ?>profile/';
        window.location = url;
    });

    $("#registrar").click(function (e) {

        e.preventDefault();  // Para evitar que se envíe por defecto

        if ($('#name').val().trim() === "") {
          
			swal("Disculpe,", "para continuar debe ingresar nombre");
			$('#name').parent('div').addClass('has-error');
			
        } else if ($('#modules_ids').val() == "") {
          
			swal("Disculpe,", "para continuar debe seleccionar los permisos");
			$('#modules_ids').parent('div').addClass('has-error');
			
        } else {
			//~ alert(String($('#modules_ids').val()));

            $.post('<?php echo base_url(); ?>CPerfil/add', $('#form_perfil').serialize()+'&'+$.param({'modules_ids':$('#modules_ids').val()}), function (response) {
				//~ alert(response);
				if (response == 'existe') {
                    swal("Disculpe,", "este nombre de perfil se encuentra registrado");
                    $('#name').parent('div').addClass('has-error');
                }else{
					swal({ 
						title: "Registro",
						 text: "Guardado con exito",
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
