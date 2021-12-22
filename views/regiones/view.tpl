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
                        <th>Id:</th>
                        <td>{$region.id}</td>
                    </tr>
                    <tr>
                        <th>Región:</th>
                        <td>{$region.nombre}</td>
                    </tr>
                    <tr>
                        <th>Creado:</th>
                        <td>{$region.created_at|date_format:"%d-%m-%Y %H:%M:%S"}</td>
                    </tr>
                    <tr>
                        <th>Modificado:</th>
                        <td>{$region.updated_at|date_format:"%d-%m-%Y %H:%M:%S"}</td>
                    </tr>
                </table>
                <p>
                    <a href="{$_layoutParams.root}regiones/edit/{$region.id}" class="btn btn-outline-primary btn-sm">Editar</a>
                    <a href="{$_layoutParams.root}regiones/" class="btn btn-outline-primary btn-sm">Volver</a>
                </p>
            </div>
        </div>
    </div>
</section> <!-- .section -->