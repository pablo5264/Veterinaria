<section class="ftco-section ftco-degree-bg">
    <div class="container">
        <div class="col-md-6 ftco-animate">
            <div class="sidebar-box ftco-animate">
                <h3>
                    {$title}
                    <a href="{$_layoutParams.root}roles/add" class="btn btn-outline-success btn-sm">Crear Rol</a>
                </h3>

                {include file="../partials/_mensajes.tpl"}

                {if isset($roles) && count($roles)}
                    <table class="table table-hover">
                        <tr>
                            <th>Rol</th>
                        </tr>
                        {foreach from=$roles item=rol}
                            <tr>
                                <td>
                                    <a href="{$_layoutParams.root}roles/view/{$rol.id}">{$rol.nombre}</a>
                                </td>
                            </tr>
                        {/foreach}
                    </table>
                {else}
                    <p class="text-info">No hay roles registrados</p>
                {/if}
            </div>
        </div>
    </div>
</section> <!-- .section -->