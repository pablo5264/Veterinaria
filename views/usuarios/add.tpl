<section class="ftco-section ftco-degree-bg">
    <div class="container">
        <div class="col-md-6 ftco-animate">
            <div class="sidebar-box ftco-animate">
                <h3>
                    {$title}
                </h3>
                <h4>Funcionario(a): {$funcionario.nombre}</h4>
                {include file="../partials/_mensajes.tpl"}

                <p class="text-danger">Campos obligatorios *</p>
                {include file="../usuarios/_form.tpl"}

            </div>
        </div>
    </div>
</section> <!-- .section -->