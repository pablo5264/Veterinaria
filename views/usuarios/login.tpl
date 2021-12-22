<section class="ftco-section ftco-degree-bg">
    <div class="container">
        <div class="col-md-6 ftco-animate">
            <div class="sidebar-box ftco-animate">
                <h3>
                    {$title}
                </h3>

                <h4 class="text-info">Inicie sesión para continuar</h4>

                {include file="../partials/_mensajes.tpl"}

                <p class="text-danger">Campos obligatorios *</p>

                <form action="" method="post">
                    <div class="mb-3">
                        <label for="email" class="label text-success" style="font-weight: bold; font-size: 14px;">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" id="" aria-describedby=""
                            placeholder="Ingrese su email" onpaste="return false">
                    </div>
                    <div class="mb-3">
                        <label for="clave" class="label text-success" style="font-weight: bold; font-size: 14px;">Password <span
                                class="text-danger">*</span></label>
                        <input type="password" name="clave" class="form-control" id="" aria-describedby=""
                            placeholder="Ingrese su password" onpaste="return false">
                    </div>
                    <input type="hidden" name="enviar" value="{$enviar}">
                    <button type="submit" class="btn btn-outline-success">Ingresar</button>
                    <a href="{$_layoutParams.root}" class="btn btn-outline-primary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</section> <!-- .section -->