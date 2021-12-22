<section class="ftco-section ftco-degree-bg">
<section class="ftco-section ftco-degree-bg">
    <div class="container">
        <div class="col-md-6 ftco-animate">
            <div class="sidebar-box ftco-animate">
                <h3>
                    {$title}
                    <a href="{$_layoutParams.root}tiposervicios/add" class="btn btn-outline-success btn-sm">Agregar Tipo Servicio</a>
                </h3>

                {include file="../partials/_mensajes.tpl"}

                {if isset($tiposervicio)}
                    <table class="table table-hover">
                        <tr>
                            <th>id Tipo Servicio</th>
                            <th>Nombre Servicio</th>
                        </tr>

                        {foreach from=$tiposervicio item=service}
                            <tr>
                                <td>
                                    {$service.id}
                                </td>  
                                <td>
                                     <a href="{$_layoutParams.root}tiposervicios/view/{$service.id}">{$service.nombre}</a>
                                </td>  
                            </tr>
                        {/foreach}

                    </table>
                
                {else}
                    <p class="text-info">No hay tipos de servicios registrados</p>
                {/if}
            </div>
        </div>
    </div>
</section> <!-- .section -->