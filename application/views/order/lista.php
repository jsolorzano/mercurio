<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Orden Servicios</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url() ?>home">Inicio</a>
            </li>
            <li class="active">
                <strong>Orden Servicios</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <a href="<?php echo base_url() ?>order/register">
                <button class="btn btn-outline btn-primary dim" type="button"><i class="fa fa-plus"></i> Agregar</button></a>
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Listado de Ordenes de Servicios </h5>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table id="tab_order" class="table table-striped table-bordered dt-responsive table-hover dataTables-example">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Orden N°</th>
                                    <th class="text-center">Franquicia</th>
                                    <th class="text-center">Cliente</th>
                                    <th class="text-center">Fecha</th>
                                    <th class="text-center">Monto</th>
                                    <th class="text-center">Servicios</th>
                                    <th class="text-center">Productos</th>
                                    <th class="text-center">Estatus</th>
                                    <th class="text-center">Editar</th>
                                    <th class="text-center">Eliminar</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($list_orders as $list) { ?>
                                    <tr style="text-align: center">
                                        <td>
                                            <?php echo $i; ?>
                                        </td>
                                        <td>
                                            <?php printf("%08d", $list->id) ?> 
                                        </td>
                                        <td>
                                            <?php
                                            foreach ($list_franq as $listar) {
                                                if ($listar->id == $list->franchise_id) {
                                                    echo $listar->name;
                                                }
                                            };
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            foreach ($list_client as $listar) {
                                                if ($listar->id == $list->customer_id) {
                                                    echo $listar->name . ' ' . $listar->lastname;
                                                }
                                            };
                                            ?>
                                        </td>
                                        <td>
                                            <?php echo $list->date_order; ?>
                                        </td>
                                        <td>
                                            <?php echo $list->total; ?>
                                        </td>
                                        <td>
                                            <?php
                                            foreach ($list_orders_services as $order_service) {
                                                if ($order_service->order_id == $list->id) {
                                                    foreach ($list_serv as $servicio) {
                                                        if ($servicio->id == $order_service->service_id) {
                                                            echo $servicio->name . ", ";
                                                        }
                                                    }
                                                }
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            foreach ($list_orders_products as $order_product) {
                                                if ($order_product->order_id == $list->id) {
                                                    foreach ($list_prod as $producto) {
                                                        if ($producto->id == $order_product->product_id) {
                                                            echo $producto->name . ", ";
                                                        }
                                                    }
                                                }
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php foreach ($status as $listar) { ?>
                                                <?php if ($listar->id == $list->status): ?>
                                                    <span class='<?php echo $listar->labels; ?>'><?php echo $listar->name; ?></span>
                                                <?php endif; ?>
                                            <?php } ?>
                                        </td>

                                        <td style='text-align: center'>

                                            <a href="<?php echo base_url() ?>order/edit/<?= $list->id; ?>" title="Editar" title="Editar" style='color: #1ab394'><i class="fa fa-edit fa-2x"></i></a>
                                        </td>
                                        <td style='text-align: center'>

                                            <a class='borrar' id='<?php echo $list->id; ?>' style='color: #1ab394' title="Eliminar"><i class="fa fa-trash-o fa-2x"></i></a>
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
    $(document).ready(function () {


        $('#tab_order').DataTable({
            "paging": true,
            "lengthChange": false,
            "autoWidth": false,
            "searching": true,
            "info": true,
            dom: '<"html5buttons"B>lTfgitp',

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
            "iDisplayLength": 5,
            "iDisplayStart": 0,
            "sPaginationType": "full_numbers",
            "aLengthMenu": [5, 10, 15],
            "oLanguage": {"sUrl": "<?= assets_url() ?>js/es.txt"},
            "aoColumns": [
                {"sClass": "registro center", "sWidth": "5%"},
                {"sClass": "registro center", "sWidth": "10%"},
                {"sClass": "registro center", "sWidth": "10%"},
                {"sClass": "registro center", "sWidth": "8%"},
                {"sClass": "registro center", "sWidth": "5%"},
                {"sClass": "registro center", "sWidth": "5%"},
                {"sClass": "none", "sWidth": "8%"},
                {"sClass": "none", "sWidth": "8%"},
                {"sClass": "registro center", "sWidth": "5%"},
                {"sWidth": "8%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false},
                {"sWidth": "8%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false},
            ]
        });

        // Validacion para borrar
        $("table#tab_order").on('click', 'a.borrar', function (e) {
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
                    function (isConfirm) {
                        if (isConfirm) {

                            $.post('<?php echo base_url(); ?>order/delete/' + id + '', function (response) {

                                if (response[0] == "e") {

                                    swal({
                                        title: "Disculpe,",
                                        text: "No se puede eliminar se encuentra asociado a un usuario",
                                        type: "warning"
                                    },
                                            function () {

                                            });
                                } else {
                                    swal({
                                        title: "Eliminar",
                                        text: "Registro eliminado con exito",
                                        type: "success"
                                    },
                                            function () {
                                                window.location.href = '<?php echo base_url(); ?>order';
                                            });
                                }
                            });
                        }
                    });
        });
    });

</script>
