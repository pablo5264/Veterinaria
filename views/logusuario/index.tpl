<section class="ftco-section ftco-degree-bg">
    <div class="container">
        <div class="col-md-12 ftco-animate">
            <div class="sidebar-box ftco-animate">
                <h3>
                    {$title}
                     <a href="{$_layoutParams.root}pdf" class="btn btn-outline-success btn-sm">Generar PDF</a>
                  
                </h3>
                {include file="../partials/_mensajes.tpl"}

                {if true}
                    <table class="table table-hover">
                        <tr>
                            <th>Id</th>
                            <th>Id Usuario</th>
                            <th>Nombre</th>
                            <th>Rut</th>
                            <th>Url</th>
                            <th>Registro de Ingreso</th>
                            <th>Registro de Salida</th>

                         </tr>
                        {foreach from=$logusuario item=log}
                            <tr>
                                <td>{$log.id}</td>

                                <td>{$log.id_usuario}</td>

                                <td>{$log.nombre}</td>

                                <td>{$log.rut}</td>

                                <td>{$log.url}</td>

                                <td>{$log.updated_at}</td>

                                <td>{$log.created_at}</td>
                            </tr>
                        {/foreach}
                    </table>
                {else}
                    <p class="text-info">No hay regiones registradas</p>
                {/if}
            </div>
        </div>
    </div>
</section> <!-- .section -->