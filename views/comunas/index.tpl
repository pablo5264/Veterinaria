<section class="ftco-section ftco-degree-bg">
    <div class="container">
        <div class="col-md-6 ftco-animate">
            <div class="sidebar-box ftco-animate">
                <h3>
                    {$title}
                    <a href="{$_layoutParams.root}comunas/add" class="btn btn-outline-success btn-sm">Agregar Comuna</a>
                </h3>

                {include file="../partials/_mensajes.tpl"}

                {if isset($comunas) && count($comunas)}
                    <table class="table table-hover">
                        <tr>
                            <th>Comuna</th>
                            <th>Región</th>
                        </tr>
                        {foreach from=$comunas item=comuna}
                            <tr>
                                <td>
                                    <a href="{$_layoutParams.root}comunas/view/{$comuna.id}">{$comuna.nombre}</a>
                                </td>
                                <td>{$comuna.region.nombre}</td>
                            </tr>
                        {/foreach}
                    </table>
                {else}
                    <p class="text-info">No hay comunas registradas</p>
                {/if}
            </div>
        </div>
    </div>
</section> <!-- .section -->