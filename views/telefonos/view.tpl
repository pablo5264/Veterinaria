<section class="ftco-section ftco-degree-bg">
    <div class="container">
        <div class="col-md-6 ftco-animate">
            <div class="sidebar-box ftco-animate">
                <h3>
                    {$title}
                </h3>

                {include file="../partials/_mensajes.tpl"}

                <table class="table table-hover">
                    <tr>
                        <th>Teléfono:</th>
                        <td>{$telefono.numero}</td>
                    </tr>
                    <tr>
                        <th>Tipo:</th>
                        <td>
                            {if $telefono.movil == 1}
                                Móvil
                            {else}
                                Fijo
                            {/if}
                        </td>
                    </tr>
                    <tr>
                        <th>Usuario:</th>
                        <td>{$usuario.nombre}</td>
                    </tr>
                    <tr>
                        <th>Modelo:</th>
                        <td>{$telefono.telefonoable_type}</td>
                    </tr>
                    <tr>
                        <th>Creado:</th>
                        <td>{$telefono.created_at|date_format:"%d-%m-%Y %H:%M:%S"}</td>
                    </tr>
                    <tr>
                        <th>Modificado:</th>
                        <td>{$telefono.updated_at|date_format:"%d-%m-%Y %H:%M:%S"}</td>
                    </tr>
                </table>
                <p>
                    <a href="{$_layoutParams.root}telefonos/edit/{$telefono.id}"
                        class="btn btn-outline-primary btn-sm">Editar</a>
                    <a href="{$_layoutParams.root}{$ruta}" class="btn btn-outline-primary btn-sm">Volver</a>
                </p>
                <form name="form" action="{$_layoutParams.root}telefonos/delete/{$telefono.id}"
                    method="post">
                    <input type="hidden" name="enviar" value="{$enviar}">
                    <button type="button" onclick="eliminar('telefono');" class="btn btn-outline-warning">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</section> <!-- .section -->