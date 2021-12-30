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
                            <th>RUT:</th>
                            <td>{$cliente.rut}</td>
                        </tr>
                        <tr>
                            <th>Nombre:</th>
                            <td>{$cliente.nombre}</td>
                        </tr>
                        <tr>
                            <th>Email:</th>
                            <td>{$cliente.email}</td>
                        </tr>
                        <tr>
                            <th>Dirección:</th>
                            <td>{$cliente.direccion}</td>
                        </tr>
                        <tr>
                            <th>Comuna:</th>
                            <td>{$cliente.comuna.nombre}</td>
                        </tr>
                        <tr>
                            <th>Creado:</th>
                            <td>{$cliente.created_at|date_format:"%d-%m-%Y %H:%M:%S"}</td>
                        </tr>
                        <tr>
                            <th>Modificado:</th>
                            <td>{$cliente.updated_at|date_format:"%d-%m-%Y %H:%M:%S"}</td>
                        </tr>
                    </table>
                    <p>
                        <a href="{$_layoutParams.root}clientes/edit/{$cliente.id}"
                            class="btn btn-outline-primary btn-sm">Editar</a>
                        <a href="{$_layoutParams.root}clientes/" class="btn btn-outline-primary btn-sm">Volver</a>
                    </p>
                </div>
            </div>
            {* sidebar derecho *}
            <div class="col-md-6 ftco-animate">
                {* lista de telefonos *}
                <div class="sidebar-box ftco-animate">
                    <h3>Teléfonos</h3>
                    <a href="{$_layoutParams.root}telefonos/add/{$cliente.id}/{$type}"
                        class="btn btn-outline-success btn-sm">Agregar Teléfono</a>

                    {if isset($telefonos) && count($telefonos)}
                        <table class="table table-hover table-responsive">
                            <tr>
                                <th>Número</th>
                                <th>Móvil</th>
                            </tr>
                            {foreach from=$telefonos item=telefono}
                                <tr>
                                    <td>
                                        <a href="{$_layoutParams.root}telefonos/view/{$telefono.id}">{$telefono.numero}</a>
                                    </td>
                                    <td>
                                        {if $telefono.movil == 1}
                                            Si
                                        {else}
                                            No
                                        {/if}
                                    </td>
                                </tr>
                            {/foreach}

                        </table>
                    {else}
                        <p class="text-info">No hay teléfonos asociados</p>
                    {/if}
                </div>
            </div>
        </div>
    </div>
</section> <!-- .section -->