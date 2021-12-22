<section class="ftco-section ftco-degree-bg">
    <div class="container">
        <div class="col-md-8 ftco-animate">
            <div class="sidebar-box ftco-animate">
                <h3>
                    {$title}
                    <a href="{$_layoutParams.root}funcionarios/add" class="btn btn-outline-success btn-sm">Crear Funcionario</a>
                </h3>

                {include file="../partials/_mensajes.tpl"}

                {if isset($funcionarios) && count($funcionarios)}
                    <table class="table table-hover">
                        <tr>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Comuna</th>
                        </tr>
                        {foreach from=$funcionarios item=funcionario}
                            <tr>
                                <td>
                                    <a href="{$_layoutParams.root}funcionarios/view/{$funcionario.id}">{$funcionario.nombre}</a>
                                </td>
                                <td>{$funcionario.email}</td>
                                <td>{$funcionario.comuna.nombre}</td>
                            </tr>
                        {/foreach}
                    </table>
                {else}
                    <p class="text-info">No hay funcionarios registrados</p>
                {/if}
            </div>
        </div>
    </div>
</section> <!-- .section -->