<section class="ftco-section ftco-degree-bg">
    <div class="container">
        <div class="col-md-6 ftco-animate">
            <div class="sidebar-box ftco-animate">
                <h3>
                    {$title}
                    <a href="{$_layoutParams.root}regiones/add" class="btn btn-outline-success btn-sm">Crear Región</a>
                </h3>

                {include file="../partials/_mensajes.tpl"}

                {if isset($regiones) && count($regiones)}
                    <table class="table table-hover">
                        <tr>
                            <th>Id</th>
                            <th>Región</th>
                        </tr>
                        {foreach from=$regiones item=region}
                            <tr>
                                <td>{$region.id}</td>
                                <td>
                                    <a href="{$_layoutParams.root}regiones/view/{$region.id}">{$region.nombre}</a>
                                </td>
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