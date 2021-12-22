<form action="" method="post">
    <div class="mb-3">
        <label for="name" class="label text-success" style="font-weight: bold; font-size: 14px;">Nombre <span
                class="text-danger">*</span></label>
        <input type="text" name="nombre" value="{$comuna.nombre|default:""}" class="form-control" id=""
            aria-describedby="" placeholder="Nombre de la comuna">
    </div>
    <div class="mb-3">
        <label for="name" class="label text-success" style="font-weight: bold; font-size: 14px;">Región <span class="text-danger">*</span></label>
        <select name="region" class="form-control" id="">
            {if $button == 'Editar'}
                <option value="{$comuna.region_id}">{$comuna.region.nombre}</option>
            {/if}

            <option value="">Seleccione...</option>
            {foreach from=$regiones item=region}
                <option value="{$region.id}">{$region.nombre}</option>
            {/foreach}
        </select>
    </div>
    <input type="hidden" name="enviar" value="{$enviar}">
    <button type="submit" class="btn btn-outline-success">{$button}</button>
    <a href="{$_layoutParams.root}{$ruta}" class="btn btn-outline-primary">Volver</a>
</form>