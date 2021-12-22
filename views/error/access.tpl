<div id="separator"></div>
<h2>{if isset($mensaje)}{$mensaje}{/if}</h2>

<p>&nbsp;</p>

<p><a href="{$_layoutParams.root}">Ir al Inicio</a>

{if !Session::get('autenticado')}
	| <a href="{$_layoutParams.root}login">Iniciar Sesion</a></p>
{/if}
<div id="separator"></div>