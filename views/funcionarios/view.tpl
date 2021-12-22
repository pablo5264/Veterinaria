<section class="ftco-section ftco-degree-bg">
    <div class="container">
        <div class="row">

            <div class="col-md-6 ftco-animate">
                <div class="sidebar-box ftco-animate">
                    <h3>
                        {$title}
                    </h3>

                    {include file="../partials/_mensajes.tpl"}


                    <table class="table table-hover">
                        <tr>
                            <th>RUN:</th>
                            <td>{$funcionario.rut}</td>
                        </tr>
                        <tr>
                            <th>Nombre:</th>
                            <td>{$funcionario.nombre}</td>
                        </tr>
                        <tr>
                            <th>Email:</th>
                            <td>{$funcionario.email}</td>
                        </tr>
                        <tr>
                            <th>Dirección:</th>
                            <td>{$funcionario.direccion}</td>
                        </tr>
                        <tr>
                            <th>Comuna:</th>
                            <td>{$funcionario.comuna.nombre}</td>
                        </tr>
                        <tr>
                            <th>Región:</th>
                            <td>{$funcionario.comuna.region.nombre}</td>
                        </tr>
                        <tr>
                            <th>Creado:</th>
                            <td>{$funcionario.created_at|date_format:"%d-%m-%Y %H:%M:%S"}</td>
                        </tr>
                        <tr>
                            <th>Modificado:</th>
                            <td>{$funcionario.updated_at|date_format:"%d-%m-%Y %H:%M:%S"}</td>
                        </tr>
                        <tr>
                            <th>Activo:</th>
                            {if isset($funcionario.usuario)}
                                <td>
                                    {if $funcionario.usuario.activo == 1}
                                        Si
                                    {else}
                                        No
                                    {/if}
                                    <a href="{$_layoutParams.root}usuarios/edit/{$funcionario.usuario.id}">Cambiar Estado</a>
                                </td>
                            {else}
                                <td>
                                    No tiene una cuenta asociada
                                </td>
                            {/if}
                        </tr>
                    </table>
                    <p>
                        <a href="{$_layoutParams.root}funcionarios/edit/{$funcionario.id}"
                            class="btn btn-outline-primary btn-sm">Editar</a>
                        <a href="{$_layoutParams.root}funcionarios/" class="btn btn-outline-primary btn-sm">Volver</a>

                        {if !isset($funcionario.usuario.id)}
                            <a href="{$_layoutParams.root}usuarios/add/{$funcionario.id}" class="btn btn-outline-success">Crear Cuenta</a>
                        {else}
                            <a href="{$_layoutParams.root}usuarios/editPassword/{$funcionario.usuario.id}"
                                class="btn btn-outline-success">Cambiar Password</a>
                        {/if}

                    </p>
                </div>
            </div>
            {* sidebar derecho *}
            <div class="col-md-6 ftco-animate">
                <div class="sidebar-box ftco-animate">
                    <h3>Roles</h3>
                    <a href="{$_layoutParams.root}funcionarioroles/add/{$funcionario.id}" class="btn btn-outline-success btn-sm">Agregar Rol</a>

                    {if isset($roles) && count($roles)}
                        <div class="list-group mt-3">
                            {foreach from=$roles item=rol}
                                <a href="{$_layoutParams.root}funcionarioroles/view/{$rol.id}" class="list-group-item list-group-item-action">{$rol.rol.nombre}</a>
                            {/foreach}

                        </div>
                    {else}
                        <p class="text-info">No hay roles asociados</p>
                    {/if}
                </div>
            </div>
        </div>
    </div>
</section> <!-- .section -->