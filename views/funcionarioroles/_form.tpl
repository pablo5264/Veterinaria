<form action="" method="post">
    <div class="mb-3">
        <label for="rol" class="label text-success" style="font-weight: bold; font-size: 14px;">Rol <span
                class="text-danger">*</span></label>
        <select name="rol" class="form-control">
            {if $button == 'Editar'}
                <option value="{$funcionarioRol.rol_id}">{$funcionarioRol.rol.nombre}</option>
            {/if}

            <option value="">Seleccione...</option>

            {foreach from=$roles item=rol}
                <option value="{$rol.id}">{$rol.nombre}</option>
            {/foreach}
        </select>
    </div>
    <input type="hidden" name="enviar" value="{$enviar}">
    <button type="submit" class="btn btn-outline-success">{$button}</button>
    <a href="{$_layoutParams.root}{$ruta}" class="btn btn-outline-primary">Volver</a>
</form>