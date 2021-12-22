<?php
use models\Comuna;
use models\Region;

class comunasController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->verificarMensajes();

        $this->_view->assign('titulo', 'Comunas');
        $this->_view->assign('title', 'Comunas');
        $this->_view->assign('comunas', Comuna::with('region')->orderBy('nombre')->get());
        $this->_view->renderizar('index');
    }

    public function view($id = null)
    {
        $this->verificarComuna($id);
        $this->verificarMensajes();

        $this->_view->assign('titulo', 'Comuna');
        $this->_view->assign('title', 'Comuna');
        $this->_view->assign('comuna', Comuna::find($this->filtrarInt($id)));
        $this->_view->renderizar('view');
    }

    public function edit($id = null)
    {
        $this->verificarComuna($id);

        $this->_view->assign('titulo', 'Editar Comuna');
        $this->_view->assign('title', 'Editar Comuna');
        $this->_view->assign('button', 'Editar');
        $this->_view->assign('ruta', 'comunas/view/' . $this->filtrarInt($id));
        $this->_view->assign('comuna', Comuna::find($this->filtrarInt($id)));
        $this->_view->assign('regiones', Region::select('id','nombre')->orderBy('nombre')->get());
        $this->_view->assign('enviar', CTRL);

        if ($this->getAlphaNum('enviar') == CTRL) {

            if (!$this->getSql('nombre') || strlen($this->getSql('nombre')) < 4) {
                $this->_view->assign('_error','El nombre debe tener al menos 4 caracteres');
                $this->_view->renderizar('edit');
                exit;
            }

            if (!$this->getInt('region')) {
                $this->_view->assign('_error','Seleccione una región');
                $this->_view->renderizar('edit');
                exit;
            }

            $comuna = Comuna::select('id')->where('nombre', $this->getSql('nombre'))->where('region_id', $this->getInt('region'))->first();

            if ($comuna) {
                $this->_view->assign('_error','La comuna y la region ingresadas ya existen... intente con otra combinación');
                $this->_view->renderizar('edit');
                exit;
            }

            $comuna = Comuna::find($this->filtrarInt($id));
            $comuna->nombre = $this->getSql('nombre');
            $comuna->region_id = $this->getInt('region');
            $comuna->save();

            Session::set('msg_success','La comuna se ha modificado correctamente');

            $this->redireccionar('comunas/view/' . $this->filtrarInt($id));
        }

        $this->_view->renderizar('edit');
    }

    public function add()
    {

        $this->_view->assign('titulo', 'Nueva Comuna');
        $this->_view->assign('title', 'Nueva Comuna');
        $this->_view->assign('button', 'Guardar');
        $this->_view->assign('ruta', 'comunas');
        $this->_view->assign('regiones', Region::select('id','nombre')->orderBy('nombre')->get());
        $this->_view->assign('enviar', CTRL);

        if ($this->getAlphaNum('enviar') == CTRL) {
            $this->_view->assign('comuna', $_POST);

            if (!$this->getSql('nombre') || strlen($this->getSql('nombre')) < 4) {
                $this->_view->assign('_error','El nombre debe tener al menos 4 caracteres');
                $this->_view->renderizar('add');
                exit;
            }

            if (!$this->getInt('region')) {
                $this->_view->assign('_error','Seleccione una región');
                $this->_view->renderizar('add');
                exit;
            }

            $comuna = Comuna::select('id')->where('nombre', $this->getSql('nombre'))->first();

            if ($comuna) {
                $this->_view->assign('_error','La comuna ingresada y existe... intente con otra');
                $this->_view->renderizar('add');
                exit;
            }

            $comuna = new Comuna;
            $comuna->nombre = $this->getSql('nombre');
            $comuna->region_id = $this->getInt('region');
            $comuna->save();

            Session::set('msg_success','La comuna se ha registrado correctamente');

            $this->redireccionar('comunas');
        }

        $this->_view->renderizar('add');
    }

    ###########################################################
     /*
    * metodo que comprueba el id de una comuna
    * @param int $id
    * redirecciona comunas/index
    */

    private function verificarComuna($id)
    {
        if (!$this->filtrarInt($id)) {
            $this->redireccionar('comunas');
        }

        $comuna = Comuna::select('id')->find($this->filtrarInt($id));

        if (!$comuna) {
            $this->redireccionar('comunas');
        }
    }
}
