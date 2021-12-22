<!DOCTYPE html>
<html>
   <head>
   	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{$titulo|default:"Veterinaria"}</title>
    <meta name="description" content="Your Description Here">
    <meta name="keywords" content="bootstrap themes, portfolio, responsive theme">
      <!-- Favicons
    ================================================== -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:200,300,400,500,600,700,800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="{$_layoutParams.ruta_css}animate.css">

    <link rel="stylesheet" href="{$_layoutParams.ruta_css}owl.carousel.min.css">
    <link rel="stylesheet" href="{$_layoutParams.ruta_css}owl.theme.default.min.css">
    <link rel="stylesheet" href="{$_layoutParams.ruta_css}magnific-popup.css">


    <link rel="stylesheet" href="{$_layoutParams.ruta_css}bootstrap-datepicker.css">
    <link rel="stylesheet" href="{$_layoutParams.ruta_css}jquery.timepicker.css">

    <link rel="stylesheet" href="{$_layoutParams.ruta_css}flaticon.css">
    <link rel="stylesheet" href="{$_layoutParams.ruta_css}style.css">



    <script src="{$_layoutParams.ruta_js}funciones.js"></script>


     <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

      {if isset($_layoutParams.js) && count($_layoutParams.js)}
        {foreach item=js from=$_layoutParams.js}
          <script type="text/javascript" src="{$js}"></script>
        {/foreach}

      {/if}

   </head>
   <body>
    {include file="header.tpl"}
    {include file="menu.tpl"}

      <div class="content">
            <noscript><p>Debe tener el soporte de Javascript habilitado</p></noscript>

            {include file=$_contenido}
          </div>

  <script src="{$_layoutParams.ruta_js}jquery.min.js"></script>
  <script src="{$_layoutParams.ruta_js}jquery-migrate-3.0.1.min.js"></script>
  <script src="{$_layoutParams.ruta_js}popper.min.js"></script>
  <script src="{$_layoutParams.ruta_js}bootstrap.min.js"></script>
  <script src="{$_layoutParams.ruta_js}jquery.easing.1.3.js"></script>
  <script src="{$_layoutParams.ruta_js}jquery.waypoints.min.js"></script>
  <script src="{$_layoutParams.ruta_js}jquery.stellar.min.js"></script>
  <script src="{$_layoutParams.ruta_js}jquery.animateNumber.min.js"></script>
  <script src="{$_layoutParams.ruta_js}bootstrap-datepicker.js"></script>
  <script src="{$_layoutParams.ruta_js}jquery.timepicker.min.js"></script>
  <script src="{$_layoutParams.ruta_js}owl.carousel.min.js"></script>
  <script src="{$_layoutParams.ruta_js}jquery.magnific-popup.min.js"></script>
  <script src="{$_layoutParams.ruta_js}scrollax.min.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
  <script src="{$_layoutParams.ruta_js}google-map.js"></script>
  <script src="{$_layoutParams.ruta_js}main.js"></script>

  </body>
</html>