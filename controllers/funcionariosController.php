<?php
use models\Funcionario;
use models\Comuna;
use models\FuncionarioRol;

class funcionariosController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->verificarMensajes();

        $this->_view->assign('titulo','Funcionarios');
        $this->_view->assign('title','Funcionarios');
        $this->_view->assign('funcionarios', Funcionario::with('comuna')->orderBy('id','DESC')->get());
        $this->_view->renderizar('index');
    }

    public function view($id = null)
    {
        $this->verificarFuncionario($id);
        $this->verificarMensajes();

        $this->_view->assign('titulo','Funcionarios');
        $this->_view->assign('title','Funcionarios');
        $this->_view->assign('funcionario', Funcionario::with(['comuna','roles','usuario'])->find($this->filtrarInt($id)));
        $this->_view->assign('roles', FuncionarioRol::with('rol')->where('funcionario_id', $this->filtrarInt($id))->get());
        $this->_view->renderizar('view');
    }

    public function edit($id = null)
    {
        $this->verificarFuncionario($id);

        $this->_view->assign('titulo','Editar Funcionario');
        $this->_view->assign('title','Editar Funcionario');
        $this->_view->assign('comunas', Comuna::select('id','nombre')->orderBy('nombre')->get());
        $this->_view->assign('funcionario', Funcionario::with('comuna')->find($this->filtrarInt($id)));
        $this->_view->assign('button', 'Editar');
        $this->_view->assign('ruta', 'funcionarios/view/' . $this->filtrarInt($id));
        $this->_view->assign('enviar', CTRL);

        if ($this->getAlphaNum('enviar') == CTRL) {


            if (!$this->getSql('nombre')) {
                $this->_view->assign('_error', 'Ingrese el nombre del funcionario');
                $this->_view->renderizar('edit');
                exit;
            }

            if (!$this->getSql('direccion')) {
                $this->_view->assign('_error', 'Ingrese la dirección del funcionario');
                $this->_view->renderizar('edit');
                exit;
            }

            if (!$this->getInt('comuna')) {
                $this->_view->assign('_error', 'Seleccione la comuna del funcionario');
                $this->_view->renderizar('edit');
                exit;
            }

            $funcionario = Funcionario::find($this->filtrarInt($id));
            $funcionario->nombre = $this->getSql('nombre');
            $funcionario->direccion = $this->getSql('direccion');
            $funcionario->comuna_id = $this->getInt('comuna');
            $funcionario->save();

            Session::set('msg_success','El funcionario se ha modificado correctamente');

            $this->redireccionar('funcionarios/view/' . $this->filtrarInt($id));
        }

        $this->_view->renderizar('edit');
    }

    public function add()
    {
        $this->_view->assign('titulo','Nuevo Funcionario');
        $this->_view->assign('title','Nuevo Funcionario');
        $this->_view->assign('comunas', Comuna::select('id','nombre')->orderBy('nombre')->get());
        $this->_view->assign('button', 'Guardar');
        $this->_view->assign('ruta', 'funcionarios');
        $this->_view->assign('enviar', CTRL);

        if ($this->getAlphaNum('enviar') == CTRL) {
            $this->_view->assign('funcionario',$_POST);

            if (!$this->validaRut($this->getSql('rut')) ) {
                $this->_view->assign('_error', 'Ingrese el rut del funcionario');
                $this->_view->renderizar('add');
                exit;
            }

            if (!$this->getSql('nombre')) {
                $this->_view->assign('_error', 'Ingrese el nombre del funcionario');
                $this->_view->renderizar('add');
                exit;
            }

            if (!$this->validarEmail($this->getPostParam('email'))) {
                $this->_view->assign('_error', 'Ingrese el email del funcionario');
                $this->_view->renderizar('add');
                exit;
            }

            if (!$this->getSql('direccion')) {
                $this->_view->assign('_error', 'Ingrese la dirección del funcionario');
                $this->_view->renderizar('add');
                exit;
            }

            if (!$this->getInt('comuna')) {
                $this->_view->assign('_error', 'Seleccione la comuna del funcionario');
                $this->_view->renderizar('add');
                exit;
            }

            $funcionario = Funcionario::select('id')->where('email', $this->getPostParam('email'))->first();

            if ($funcionario) {
                $this->_view->assign('_error', 'El funcionario ingresado ya existe... intente con otro');
                $this->_view->renderizar('add');
                exit;
            }

            $funcionario = new Funcionario;
            $funcionario->rut = $this->getSql('rut');
            $funcionario->nombre = $this->getSql('nombre');
            $funcionario->email = $this->getPostParam('email');
            $funcionario->direccion = $this->getSql('direccion');
            $funcionario->comuna_id = $this->getInt('comuna');
            $funcionario->save();

            Session::set('msg_success','El funcionario se ha registrado correctamente');

            $this->redireccionar('funcionarios');
        }

        $this->_view->renderizar('add');
    }

    ######################################################
    /*
    * valida el id de un funcionrio
    * @params int $id
    * return funcionarios/index
    */
    private function verificarFuncionario($id)
    {
        if (!$this->filtrarInt($id)) {
            $this->redireccionar('funcionarios');
        }

        $funcionario = Funcionario::select('id')->find($this->filtrarInt($id));

        if (!$funcionario) {
            $this->redireccionar('funcionarios');
        }
    }
}
