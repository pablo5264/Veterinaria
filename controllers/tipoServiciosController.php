<?php
use models\TipoServicio;


class TipoServiciosController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->verificarMensajes();

        $this->_view->assign('titulo', 'Tipo Servicios'); // titulo del browser
        $this->_view->assign('title', 'Tipo Servicios');  // titulo de la pag
        $this->_view->assign('tiposervicio', TipoServicio::select('id','nombre')->orderBy('id')->get());
        $this->_view->renderizar('index');
    }


 ###########################################################

    public function view($id = null)
    {
         $this->verificarTipoServicio($id);
        $this->verificarMensajes();

        $this->_view->assign('titulo', 'Tipo Servicios');
        $this->_view->assign('title', 'Tipo Servicios');
        $this->_view->assign('tiposervicio', TipoServicio::find($this->filtrarInt($id)));
        $this->_view->renderizar('view');
    }

    public function edit($id = null)
    {
         $this->verificarTipoServicio($id);

        $this->_view->assign('titulo', 'Tipo Servicios');
        $this->_view->assign('title', 'Tipo Servicio');
        $this->_view->assign('button', 'Editar');
        $this->_view->assign('ruta', 'tiposervicios/view/' . $this->filtrarInt($id));
        $this->_view->assign('tiposervicio', TipoServicio::find($this->filtrarInt($id)));


        $this->_view->assign('enviar', CTRL);

        if ($this->getAlphaNum('enviar') == CTRL) {

            if (!$this->getSql('nombre') || strlen($this->getSql('nombre')) < 4) {
                $this->_view->assign('_error','El nombre debe tener al menos 4 caracteres');
                $this->_view->renderizar('edit');
                exit;
            }

            $tipoServicio = TipoServicio::select('id')->where('nombre', $this->getSql('nombre'))->first();

            if ($tipoServicio) {
                $this->_view->assign('_error','El tipo de servicio ya existe, intente otro');
                $this->_view->renderizar('edit');
                exit;
            }

            $tipoServicio = TipoServicio::find($this->filtrarInt($id));
            $tipoServicio->nombre = $this->getSql('nombre');
            $tipoServicio->save();

            Session::set('msg_success','El tipo de servicio se ha modificado correctamente');

            $this->redireccionar('tiposervicios/view/' . $this->filtrarInt($id));
        }

        $this->_view->renderizar('edit');
    }



    ###########################################################

    public function add()
    {

        $this->_view->assign('titulo', 'Nuevo Tipo Servicio');
        $this->_view->assign('title', 'Nuevo Tipo Servicio');
        $this->_view->assign('button', 'Guardar');     
        $this->_view->assign('ruta', 'tiposervicios'); 
        $this->_view->assign('tiposervicio', TipoServicio::select('id','nombre')->orderBy('id')->get());
        $this->_view->assign('enviar', CTRL);

        if ($this->getAlphaNum('enviar') == CTRL) {
            $this->_view->assign('comuna', $_POST);

            if (!$this->getSql('nombre') || strlen($this->getSql('nombre')) < 4) {
                $this->_view->assign('_error','El nombre debe tener al menos 4 caracteres');
                $this->_view->renderizar('add');
                exit;
            }

            $tipoServicio = TipoServicio::select('id')->where('nombre', $this->getSql('nombre'))->first();

            if ($tipoServicio) {
                $this->_view->assign('_error','El tipo de servicio ya fue ingresado y existe... intente con otro servicio');
                $this->_view->renderizar('add');
                exit;
            }

            $tipoServicio = new TipoServicio;
            $tipoServicio->nombre = $this->getSql('nombre');
            $tipoServicio->save();

            Session::set('msg_success','Tipo de Servicio fue registrado correctamente');

            $this->redireccionar('tiposervicios'); //
        }

        $this->_view->renderizar('add');
    }




    // ###########################################################
     /*
    * metodo que comprueba el id de una tipo de servicio
    * @param int $id
    * redirecciona tiposervicio/index
    */

    private function verificarTipoServicio($id)
    {
        if (!$this->filtrarInt($id)) {
            $this->redireccionar('tiposervicios');
        }

        $tipoServicio = TipoServicio::select('id')->find($this->filtrarInt($id));

        if (!$tipoServicio) {
            $this->redireccionar('tiposervicios');
        }
    }
}
