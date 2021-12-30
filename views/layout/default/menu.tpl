<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
	<div class="container">
	 	<a class="navbar-brand" href="{$_layoutParams.root}"><span class="flaticon-pawprint-1 mr-2"></span>Veterinaria</a>
	  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
	    <span class="fa fa-bars"></span> Menu
	  </button>
	  <div class="collapse navbar-collapse" id="ftco-nav">
	    <ul class="navbar-nav ml-auto">
			{if isset(Session::get('autenticado'))}
				<li class="nav-item active"><a href="{$_layoutParams.root}" class="nav-link">{Session::get('usuario_nombre')}</a></li>
			{/if}
	     	<li class="nav-item"><a href="{$_layoutParams.root}" class="nav-link">Home</a></li>

			{if isset(Session::get('autenticado'))}
				{foreach from=Session::get('usuario_roles')->funcionarioRol item=funcionarioRol}
					{if $funcionarioRol.rol.nombre == 'Administrador(a)'}
						<li class="nav-item"><a href="{$_layoutParams.root}admin/" class="nav-link">Administración</a></li>
					{/if}
				{/foreach}

			{/if}

			{if !isset(Session::get('autenticado'))}
				<li class="nav-item"><a href="{$_layoutParams.root}usuarios/login" class="nav-link">Login</a></li>
			{else}
				<li class="nav-item"><a href="{$_layoutParams.root}usuarios/logout" class="nav-link">Logout</a></li>
			{/if}
	    </ul>
	  </div>
	</div>
</nav>



