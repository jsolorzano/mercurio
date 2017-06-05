<div class="modal inmodal fade" id="modal_password" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close cerrar_modal" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h5 class="modal-title">Actualizar Contraseña</h5>
            </div>
            <div class="modal-body" >
                <form id="modal_pass" method="post" accept-charset="utf-8" class="form-horizontal">
                    <div class="form-group">
                        <label>Contraseña nueva</label>
                        <input id="password" name="password" class="form-control" type="password" maxlength="50" >
                        <label>Confirme contraseña</label>
                        <input id="confirm" name="confirm" class="form-control" type="password" maxlength="50" >
                        <input id="id_client" name="id_client" class="form-control" type="hidden" maxlength="50" >

                    </div>
                </form>
            </div>
            <div class="modal-footer" >
                <button class="btn btn-primary" type="button" id="agregar">
                    Aceptar
                </button>
            </div>
        </div>
    </div>
</div>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Clientes</h2>
        <ol class="breadcrumb">
            <li>
                <a href="">Inicio</a>
            </li>
            <li class="active">
                <strong>Clientes</strong>
            </li>
        </ol>

    </div>

</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <a href="<?php echo base_url() ?>clients/register">
                <button class="btn btn-outline btn-primary dim" type="button"><i class="fa fa-plus"></i> Agregar</button></a>
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Listado de Clientes </h5>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table id="tab_client" class="table table-striped table-bordered table-hover dataTables-example" >
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>Usuario</th>
                                    <th>Contraseña</th>
                                    <th>Editar</th>
                                    <th>Activar/Desactivar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($listar as $list) { ?>
                                    <tr style="text-align: center">
                                        <td>
                                            <?php echo $i; ?>
                                        </td>
                                        <td>
                                            <?php echo $list->name; ?>
                                        </td>
                                        <td>
                                            <?php echo $list->lastname; ?>
                                        </td>
                                        <td>
                                            <?php echo $list->username; ?>
                                        </td>
                                        <td style='text-align: center'>
                                            <a class="pass" id='<?php echo $list->id; ?>' style='color: #1ab394'><i class="fa fa-key fa-2x"></i></a>
                                        </td>
                                        <td style='text-align: center'>

                                            <a href="<?php echo base_url() ?>clients/edit/<?= $list->id; ?>" title="Editar" title="Editar" style='color: #1ab394'><i class="fa fa-edit fa-2x"></i></a>
                                        </td>
                                        <td style='text-align: center'>
                                            <?php if ($list->status == 1) { ?>
                                                <input class='activar_desactivar' id='<?php echo $list->id; ?>' type="checkbox" title='Desactivar el usuario <?php echo $list->id; ?>' checked="checked"/>
                                            <?php } else if ($list->status == 0) { ?>
                                                <input class='activar_desactivar' id='<?php echo $list->id; ?>' type="checkbox" title='Activar el usuario <?php echo $list->id; ?>'/>
                                            <?php } ?>
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
<script>
    $(document).ready(function () {


        // Función para activar/desactivar un usuario
        $("table#tab_client").on('click', 'input.activar_desactivar', function (e) {
            e.preventDefault();
            var id = this.getAttribute('id');
            //alert(id)

            var check = $(this);

            //~ alert(check.prop('checked'));

            var accion = '';
            if (check.is(':checked')) {
                accion = 'activar';
            } else {
                accion = 'desactivar';
            }

            swal({
                title: accion.charAt(0).toUpperCase() + accion.substring(1) + " registro",
                text: "¿Desea " + accion + " el cliente?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: accion.charAt(0).toUpperCase() + accion.substring(1),
                cancelButtonText: "Cancelar",
                closeOnConfirm: false,
                closeOnCancel: true
            },
                function (isConfirm) {
                    if (isConfirm) {

                        $("#motivo_anulacion").val('');
                        $("#accion").val(accion);

                        var mensaje = "";
                        if (accion == 'desactivar') {
                            mensaje = "desactivado";
                        } else {
                            mensaje = "activado";
                        }

                        $.post('<?= base_url() ?>CClient/update_status/' + id, {'accion': accion}, function (response) {
                            swal("El cliente fue " + mensaje + " exitosamente");
                            location.reload();
                        })
                    }
                });

        });

        $("a.pass").click(function (e) {
            e.preventDefault();  // Para evitar que se envíe por defecto
            $("#modal_password").modal('show');
            var id = this.getAttribute('id');
            $("#id_client").val(id);

        });

        $("#agregar").click(function (e) {
            e.preventDefault();
            $("#lunares").prop('disabled', false);
            swal({
                title: "Cambiar Contraseña",
                text: "¿Está seguro de cambiar la contraseña?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Actualizar",
                cancelButtonText: "Cancelar",
                closeOnConfirm: false,
                closeOnCancel: true
            },
                function (isConfirm) {
                    if (isConfirm) {

                        $.post('<?php echo base_url(); ?>CClient/pass', $('#modal_pass').serialize(), function (response) {
                            swal({
                                title: "Contraseña",
                                text: "actualizada con exito",
                                type: "success"
                            },
                                    function () {
                                        window.location.href = '<?= base_url() ?>clients';
                                    });

                        });

                    }
                });


        });

        $('#tab_client').DataTable({
            "autoWidth": false,
            "searching": true,
            "aLengthMenu": [5, 10, 15],
            "oLanguage": {"sUrl": "<?= assets_url() ?>js/es.txt"},
            buttons: [
                {extend: 'copy'},
                {extend: 'csv'},
                {extend: 'excel', title: 'ExampleFile'},
                {extend: 'pdf', title: 'ExampleFile'},

                {extend: 'print',
                    customize: function (win) {
                        $(win.document.body).addClass('white-bg');
                        $(win.document.body).css('font-size', '10px');

                        $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');
                    }
                }
            ],

            "aoColumns": [
                {"sClass": "registro center", "sWidth": "5%"},
                {"sClass": "registro center", "sWidth": "10%"},
                {"sClass": "registro center", "sWidth": "10%"},
                {"sClass": "registro center", "sWidth": "10%"},
                {"sWidth": "1%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false},
                {"sWidth": "1%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false},
                {"sWidth": "1%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false}
            ]
        });

        // Validacion para borrar
        $("table#tab_client").on('click', 'a.borrar', function (e) {
            e.preventDefault();
            var id = this.getAttribute('id');

            swal({
                title: "Borrar registro",
                text: "¿Está seguro de borrarlo?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Eliminar",
                cancelButtonText: "Cancelar",
                closeOnConfirm: false,
                closeOnCancel: true
            },
                    function (isConfirm) {
                        if (isConfirm) {

                            $.post('<?= base_url() ?>clients/delete/' + id + '', function () {

                                swal({
                                    title: "Eliminar",
                                    text: "Registro eliminado con exito",
                                    type: "success"
                                },
                                        function () {
                                            window.location.href = '<?= base_url() ?>clients';
                                        });
                            });
                        }
                    });

        });

    });

</script>

