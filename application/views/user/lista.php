<input id="base_url" type="hidden" value="<?php echo base_url(); ?>"/>
<script src="<?php echo assets_url('script/users.js'); ?>" type="text/javascript" charset="utf-8" ></script>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Usuarios</h2>
        <ol class="breadcrumb">
            <li>
                <a href="">Inicio</a>
            </li>
            <li class="active">
                <strong>Usuarios</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <a href="<?php echo base_url() ?>users_register">
            <button class="btn btn-outline btn-primary dim" type="button"><i class="fa fa-plus"></i> Agregar</button></a>
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Listado de Usuarios </h5>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table id="tab_users" class="table table-striped table-bordered dt-responsive table-hover dataTables-example" >
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>Usuario</th>
                                    <th>Franquicias</th>
                                    <th>Permisos</th>
                                    <th>Editar</th>
                                    <th>Activar/Desactivar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($listar as $usuario) { ?>
                                    <tr style="text-align: center">
                                        <td>
                                            <?php echo $i; ?>
                                        </td>
                                        <td>
                                            <?php echo $usuario->name; ?>
                                        </td>
                                        <td>
                                            <?php echo $usuario->lastname; ?>
                                        </td>
                                        <td>
                                            <?php echo $usuario->username; ?>
                                        </td>
                                        <td>
                                            <?php
                                            echo "<br>";
                                            // Validamos qué franquicias están asociadas a cada usuario
                                            foreach($users_franquicias as $user_franquicia){
												if($usuario->id == $user_franquicia->user_id){
													foreach ($franquicias as $franquicia){
														if($user_franquicia->franchise_id == $franquicia->id){
															echo $franquicia->name."<br>";
														}else{
															echo "";
														}
													}
												}
											}
											?>
                                        </td>
                                        <td>
                                            <?php
                                            echo "<br>";
                                            // Validamos qué modulos están asociadas a cada usuario
                                            foreach($permisos as $permiso){
												if($usuario->id == $permiso->user_id){
													foreach ($modulos as $modulo){
														if($permiso->module_id == $modulo->id){
															echo $modulo->name."<br>";
														}else{
															echo "";
														}
													}
												}
											}
											?>
                                        </td>
                                        <td style='text-align: center'>
                                            <a href="<?php echo base_url() ?>users_edit/<?= $usuario->id; ?>"  title="Editar" style='color: #1ab394'><i class="fa fa-edit fa-2x"></i></a>
                                        </td>
                                        <td style='text-align: center'>
											<?php if ($usuario->status == 1) {?>
											<input class='activar_desactivar' id='<?php echo $usuario->id; ?>' type="checkbox" title='Desactivar el usuario <?php echo $usuario->id;?>' checked="checked"/>
											<?php }else if ($usuario->status == 0){ ?>
											<input class='activar_desactivar' id='<?php echo $usuario->id; ?>' type="checkbox" title='Activar el usuario <?php echo $usuario->id;?>'/>
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

