<?php
use models\Region;

class regionesController extends Controller
{
   public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->verificarMensajes();

        $this->_view->assign('titulo','Regiones');
        $this->_view->assign('title','Regiones');
        $this->_view->assign('regiones', Region::select('id','nombre')->orderBy('nombre')->get());
        $this->_view->renderizar('index');
    }

    public function view($id = null)
    {
        $this->verificarRegion($id);
        $this->verificarMensajes();

        $this->_view->assign('titulo','Regiones');
        $this->_view->assign('title','Regiones');
        $this->_view->assign('region', Region::find($this->filtrarInt($id)));
        $this->_view->renderizar('view');
    }

    public function edit($id = null)
    {
        $this->verificarRegion($id);

        $this->_view->assign('titulo', 'Editar Region');
        $this->_view->assign('title', 'Editar Región');
        $this->_view->assign('button','Editar');
        $this->_view->assign('ruta','regiones/view/' . $this->filtrarInt($id));
        $this->_view->assign('region', Region::find($this->filtrarInt($id)));
        $this->_view->assign('enviar', CTRL);

        if ($this->getAlphaNum('enviar') == CTRL) {

            if (!$this->getSql('nombre') || strlen($this->getSql('nombre')) < 4) {
                $this->_view->assign('_error','Ingrese un nombre de al menos 4 caracteres');
                $this->_view->renderizar('edit');
                exit;
            }

            $region = Region::find($this->filtrarInt($id));
            $region->nombre = $this->getSql('nombre');
            $region->save();


            Session::set('msg_success','La región se ha modificado correctamente');

            $this->redireccionar('regiones/view/' . $this->filtrarInt($id));
        }

        $this->_view->renderizar('edit');
    }

    public function add()
    {
        $this->_view->assign('titulo', 'Nueva Region');
        $this->_view->assign('title', 'Nueva Región');
        $this->_view->assign('button','Guardar');
        $this->_view->assign('ruta','regiones/');
        $this->_view->assign('enviar', CTRL);

        if ($this->getAlphaNum('enviar') == CTRL) {
            $this->_view->assign('region', $_POST);

            if (!$this->getSql('nombre') || strlen($this->getSql('nombre')) < 4) {
                $this->_view->assign('_error','Ingrese un nombre de al menos 4 caracteres');
                $this->_view->renderizar('add');
                exit;
            }

            $region = Region::select('id')->where('nombre', $this->getSql('nombre'))->first();

            if ($region) {
                $this->_view->assign('_error', 'La región ingresada ya existe... intente con otra');
                $this->_view->renderizar('add');
                exit;
            }

            $region = new Region;
            $region->nombre = $this->getSql('nombre');
            $region->save();

            Session::set('msg_success','La región se ha registrado correctamente');

            $this->redireccionar('regiones');
        }

        $this->_view->renderizar('add');
    }

    ##################################################################
    /*
    * metodo que comprueba el id de una region
    * @param int $id
    * redirecciona regiones/index
    */

    private function verificarRegion($id)
    {
        if (!$this->filtrarInt($id)) {
            $this->redireccionar('regiones');
        }

        $region = Region::select('id')->find($this->filtrarInt($id));

        if (!$region) {
            $this->redireccionar('regiones');
        }
    }
}
