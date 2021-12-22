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
                        <th>Funcionario:</th>
                        <td>{$funcionarioRol.funcionario.nombre}</td>
                    </tr>
                    <tr>
                        <th>Rol:</th>
                        <td>{$funcionarioRol.rol.nombre}</td>
                    </tr>
                    <tr>
                        <th>Creado:</th>
                        <td>{$funcionarioRol.created_at|date_format:"%d-%m-%Y %H:%M:%S"}</td>
                    </tr>
                    <tr>
                        <th>Modificado:</th>
                        <td>{$funcionarioRol.updated_at|date_format:"%d-%m-%Y %H:%M:%S"}</td>
                    </tr>
                </table>
                <p>
                    <a href="{$_layoutParams.root}funcionarioroles/edit/{$funcionarioRol.id}"
                        class="btn btn-outline-primary btn-sm">Editar</a>
                    <a href="{$_layoutParams.root}funcionarios/view/{$funcionarioRol.funcionario_id}" class="btn btn-outline-primary btn-sm">Volver</a>
                </p>
                <form name="form" action="{$_layoutParams.root}funcionarioroles/delete/{$funcionarioRol.id}" method="post">
                    <input type="hidden" name="enviar" value="{$enviar}">
                    <button type="button" onclick="eliminar();" class="btn btn-outline-warning">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</section> <!-- .section -->