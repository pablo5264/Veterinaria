<?php
use models\Cliente;
use models\Comuna;
use models\Telefono;

class clientesController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        // $this->verificarSession();
        // $this->verificarRolAdmin();
    }

    public function index()
    {
        $this->verificarMensajes();

        $this->_view->assign('titulo', 'Clientes');
        $this->_view->assign('title', 'Clientes');
        $this->_view->assign('clientes', Cliente::with('comuna')->orderBy('nombre')->get());
        $this->_view->renderizar('index');
    }

    public function view($id = null)
    {
        $this->verificarCliente($id);
        $this->verificarMensajes();

        $this->_view->assign('titulo','Clientes');
        $this->_view->assign('title','Clientes');
        $this->_view->assign('cliente', Cliente::with('comuna')->find($this->filtrarInt($id)));
        $this->_view->assign('type', 'Cliente');
        $this->_view->assign('telefonos', Telefono::where('telefonoable_id',$this->filtrarInt($id))->where('telefonoable_type','Cliente')->get());
        $this->_view->renderizar('view');
    }

    public function edit($id = null)
    {
        $this->verificarCliente($id);

        $this->_view->assign('titulo', 'Editar Cliente');
        $this->_view->assign('title', 'Editar Cliente');
        $this->_view->assign('button', 'Editar');
        $this->_view->assign('ruta', 'clientes/view/' . $this->filtrarInt($id));
        $this->_view->assign('cliente', Cliente::with('comuna')->find($this->filtrarInt($id)));
        $this->_view->assign('comunas', Comuna::select('id','nombre')->orderBy('nombre')->get());
        $this->_view->assign('enviar', CTRL);

        if ($this->getAlphaNum('enviar') == CTRL) {

            if (!$this->getSql('nombre') || strlen($this->getSql('nombre')) < 4) { $this->_view->assign('_error', 'Ingrese
                el nombre del cliente');
                $this->_view->renderizar('edit');
                exit;
            }

            if (!$this->validarEmail($this->getPostParam('email'))) {
                $this->_view->assign('_error','Ingrese el email del cliente');
                $this->_view->renderizar('edit');
                exit;
            }

            if (!$this->getSql('direccion') || strlen($this->getSql('direccion')) < 4) {
                $this->_view->assign('_error','Ingrese la dirección del cliente');
                $this->_view->renderizar('edit');
                exit;
            }

            if (!$this->getInt('comuna')) {
                $this->_view->assign('_error','Seleccione la comuna del cliente');
                $this->_view->renderizar('edit');
                exit;
            }

            $cliente = Cliente::select('id')->where('nombre', $this->getSql('nombre'))->where('email', $this->getPostParam('email'))->where('direccion', $this->getSql('direccion'))->where('comuna_id', $this->getInt('comuna'))->first();

            if ($cliente) {
                $this->_view->assign('_error','El cliente ingresado ya existe... modifique alguno de los datos del formulario');
                $this->_view->renderizar('edit');
                exit;
            }

            $cliente = Cliente::find($this->filtrarInt($id));
            $cliente->nombre = $this->getSql('nombre');
            $cliente->email = $this->getPostParam('email');
            $cliente->direccion = $this->getSql('direccion');
            $cliente->comuna_id = $this->getInt('comuna');
            $cliente->save();

            Session::set('msg_success', 'El cliente se ha modificado correctamente');

            $this->redireccionar('clientes/view/' . $this->filtrarInt($id));

        }

        $this->_view->renderizar('edit');
    }

    public function add()
    {
        $this->_view->assign('titulo', 'Nuevo Cliente');
        $this->_view->assign('title', 'Nuevo Cliente');
        $this->_view->assign('button', 'Guardar');
        $this->_view->assign('ruta', 'clientes');
        $this->_view->assign('comunas', Comuna::select('id','nombre')->orderBy('nombre')->get());
        $this->_view->assign('enviar', CTRL);

        if ($this->getAlphaNum('enviar') == CTRL) {
            $this->_view->assign('cliente', $_POST);

            if (!$this->validaRut($this->getSql('rut')) ) {
                $this->_view->assign('_error', 'Ingrese el rut del cliente');
                $this->_view->renderizar('add');
                exit;
            }

            if (!$this->getSql('nombre') || strlen($this->getSql('nombre')) < 4) {
                $this->_view->assign('_error', 'Ingrese el nombre del cliente');
                $this->_view->renderizar('add');
                exit;
            }

            if (!$this->validarEmail($this->getPostParam('email'))) {
                $this->_view->assign('_error','Ingrese el email del cliente');
                $this->_view->renderizar('add');
                exit;
            }

            if (!$this->getSql('direccion') || strlen($this->getSql('direccion')) < 4) {
                $this->_view->assign('_error','Ingrese la dirección del cliente');
                $this->_view->renderizar('add');
                exit;
            }

            if (!$this->getInt('comuna')) {
                $this->_view->assign('_error','Seleccione la comuna del cliente');
                $this->_view->renderizar('add');
                exit;
            }

            $cliente = Cliente::select('id')->where('rut', $this->getSql('rut'))->first();

            if ($cliente) {
                $this->_view->assign('_error','El cliente ingresado ya existe... intente con otro');
                $this->_view->renderizar('add');
                exit;
            }

            $cliente = new Cliente;
            $cliente->rut = $this->getSql('rut');
            $cliente->nombre = $this->getSql('nombre');
            $cliente->email = $this->getPostParam('email');
            $cliente->direccion = $this->getSql('direccion');
            $cliente->comuna_id = $this->getInt('comuna');
            $cliente->save();

            Session::set('msg_success', 'El cliente se ha registrado correctamente');

            $this->redireccionar('clientes');
        }

        $this->_view->renderizar('add');
    }

    ################################################
    private function verificarCliente($id)
    {
        if (!$this->filtrarInt($id)) {
            $this->redireccionar('clientes');
        }

        $cliente = Cliente::select('id')->find($this->filtrarInt($id));

        if (!$cliente) {
            $this->redireccionar('clientes');
        }
    }
}