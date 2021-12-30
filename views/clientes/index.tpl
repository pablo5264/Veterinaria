<section class="ftco-section ftco-degree-bg">
    <div class="container">
        <div class="col-md-10 ftco-animate">
            <div class="sidebar-box ftco-animate">
                <h3>
                    {$title}
                    <a href="{$_layoutParams.root}clientes/add" class="btn btn-outline-success btn-sm">Agregar Cliente</a>
                </h3>

                {include file="../partials/_mensajes.tpl"}

                {if isset($clientes) && count($clientes)}
                    <table class="table table-hover">
                        <tr>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Comuna</th>
                        </tr>
                        {foreach from=$clientes item=cliente}
                            <tr>
                                <td>
                                    <a href="{$_layoutParams.root}clientes/view/{$cliente.id}">{$cliente.nombre}</a>
                                </td>
                                <td>{$cliente.email}</td>
                                <td>{$cliente.comuna.nombre}</td>
                            </tr>
                        {/foreach}
                    </table>
                {else}
                    <p class="text-info">No hay clientes registrados</p>
                {/if}
            </div>
        </div>
    </div>
</section> <!-- .section -->