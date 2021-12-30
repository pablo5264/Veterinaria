<form action="" method="post">
    <div class="mb-3">
        <label for="numero" class="label text-success" style="font-weight: bold; font-size: 14px;">Teléfono <span
                class="text-danger">*</span></label>
        <input type="number" name="numero" value="{$telefono.numero|default:""}" class="form-control" id="" aria-describedby=""
            placeholder="Número de teléfono">
    </div>
    <div class="mb-3">
        <label for="movil" class="label text-success" style="font-weight: bold; font-size: 14px;">Tipo <span
                class="text-danger">*</span></label>
        <select name="movil" class="form-control">
            {if $button == 'Editar'}
                <option value="{$telefono.movil}">
                    {if $telefono.movil == 1}
                        Móvil
                    {else}
                        Fijo
                    {/if}
                </option>
            {/if}

            <option value="">Seleccione...</option>
            <option value="1">Móvil</option>
            <option value="2">Fijo</option>
        </select>
    </div>
    <input type="hidden" name="enviar" value="{$enviar}">
    <button type="submit" class="btn btn-outline-success">{$button}</button>
    <a href="{$_layoutParams.root}{$ruta}" class="btn btn-outline-primary">Volver</a>
</form>