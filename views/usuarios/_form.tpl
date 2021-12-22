<form action="" method="post">
    {if $button == 'Guardar' || $button == 'Modificar'}
        <div class="mb-3">
            <label for="clave" class="label text-success" style="font-weight: bold; font-size: 14px;">Password <span
                    class="text-danger">*</span></label>
            <input type="password" name="clave" class="form-control" id="" aria-describedby=""
                placeholder="Password del usuario" onpaste="return false">
        </div>
        <div class="mb-3">
            <label for="reclave" class="label text-success" style="font-weight: bold; font-size: 14px;">Confirmar Password <span class="text-danger">*</span></label>
            <input type="password" name="reclave" class="form-control" id="" aria-describedby=""
    placeholder="Confirmar password del usuario" onpaste="return false">
        </div>
    {/if}
    {if $button == 'Editar'}
        <div class="mb-3">
            <label for="activo" class="label text-success" style="font-weight: bold; font-size: 14px;">Estado <span class="text-danger">*</span></label>
            <select name="activo" class="form-control">
                <option value="{$usuario.activo}">
                    {if $usuario.activo == 1}
                        Activo
                    {else}
                        Inactivo
                    {/if}
                </option>

                <option value="">Seleccione...</option>
                <option value="1">Activar</option>
                <option value="2">Desactivar</option>

            </select>
        </div>
    {/if}
    <input type="hidden" name="enviar" value="{$enviar}">
    <button type="submit" class="btn btn-outline-success">{$button}</button>
    <a href="{$_layoutParams.root}{$ruta}" class="btn btn-outline-primary">Cancelar</a>
</form>