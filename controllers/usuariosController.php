<?php

use models\Funcionario;
use models\Usuario;
use models\FuncionarioRol;

class usuariosController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        # code...
    }

    public function view($id = null)
    {
        # code...
    }

    public function login()
    {
        if(Session::get('autenticado')){
            $this->redireccionar();
        }

        $this->_view->assign('titulo', 'Login');
        $this->_view->assign('title', 'Iniciar Sesión');
        $this->_view->assign('enviar', CTRL);

        if ($this->getAlphaNum('enviar') == CTRL) {

            if (!$this->validarEmail($this->getPostParam('email'))) {
                $this->_view->assign('_error','Ingrese su correo electrónico');
                $this->_view->renderizar('login');
                exit;
            }

            if (!$this->getSql('clave')) {
                $this->_view->assign('_error','Ingrese su password');
                $this->_view->renderizar('login');
                exit;
            }

            $clave = $this->encriptar($this->getSql('clave'));

            $funcionario = Funcionario::select('id')->where('email', $this->getPostParam('email'))->first();

            $usuario = Usuario::with('funcionario')->where('clave', $clave)->where('activo', 1)->where('funcionario_id', $funcionario->id)->first();

            $roles = Funcionario::with('funcionarioRol')->find($funcionario->id);
            // foreach ($roles->funcionarioRol as $funcionarioRol) {
            //     echo $funcionarioRol->rol->nombre;
            // }

            //exit;

            if (!$usuario) {
                $this->_view->assign('_error','El email o el password no están registrados');
                $this->_view->renderizar('login');
                exit;
            }

            Session::set('autenticado', true);
            Session::set('usuario_id', $usuario->id);
            Session::set('usuario_nombre', $usuario->funcionario->nombre);
            Session::set('usuario_roles', $roles);
            Session::set('tiempo', time());

            $this->redireccionar();
        }

        $this->_view->renderizar('login');
    }

    public function logout()
    {
        Session::destroy();

        $this->redireccionar();
    }

    public function edit($id = null)
    {
        $this->verificarSession();
        $this->verificarUsuario($id);

        $usuario = Usuario::with('funcionario')->find($this->filtrarInt($id));

        $this->_view->assign('titulo','Editar Usuario');
        $this->_view->assign('title', 'Editar Usuario');
        $this->_view->assign('button','Editar');
        $this->_view->assign('ruta', 'funcionarios/view/' . $usuario->funcionario_id);
        $this->_view->assign('usuario', $usuario);
        $this->_view->assign('enviar', CTRL);

        if ($this->getAlphaNum('enviar') == CTRL) {

            if (!$this->getInt('activo')) {
                $this->_view->assign('_error','Seleccione un estado para el usuario');
                $this->_view->renderizar('edit');
                exit;
            }

            $usuario->activo = $this->getInt('activo');
            $usuario->save();

            Session::set('msg_success','El usuario se ha modificado correctamente');

            $this->redireccionar('funcionarios/view/' . $usuario->funcionario_id);
        }

        $this->_view->renderizar('edit');
    }

    public function editPassword($id = null)
    {
        $this->verificarSession();
        $this->verificarUsuario($id);

        $usuario = Usuario::with('funcionario')->find($this->filtrarInt($id));

        $this->_view->assign('titulo', 'Modificar Password');
        $this->_view->assign('title', 'Modificar Password');
        $this->_view->assign('button', 'Modificar');
        $this->_view->assign('ruta', 'funcionarios/view/' . $usuario->funcionario_id);
        $this->_view->assign('usuario', $usuario);
        $this->_view->assign('enviar', CTRL);

        if ($this->getAlphaNum('enviar') == CTRL) {

            if (!$this->getSql('clave') || strlen($this->getSql('clave')) < 8) {
                $this->_view->assign('_error', 'Ingrese una clave de al menos 8 caracteres');
                $this->_view->renderizar('add');
                exit;
            }

            if ($this->getSql('reclave') != $this->getSql('clave')) {
                $this->_view->assign('_error', 'Las claves ingresadas no coinciden');
                $this->_view->renderizar('add');
                exit;
            }

            $clave = $this->encriptar($this->getSql('clave'));

            $usuario = Usuario::find($this->filtrarInt($id));
            $usuario->clave = $clave;
            $usuario->save();

            Session::set('msg_success', 'El password se ha modificado correctamente');

            $this->redireccionar('funcionarios/view/' . $usuario->funcionario_id);
        }

        $this->_view->renderizar('editPassword');
    }

    public function add($funcionario = null)
    {
        $this->verificarSession();
        $this->verificarFuncionario($funcionario);

        $this->_view->assign('titulo','Nueva Cuenta de Usuario');
        $this->_view->assign('title', 'Crear Cuenta de Usuario');
        $this->_view->assign('button','Guardar');
        $this->_view->assign('ruta', 'funcionarios/view/' . $this->filtrarInt($funcionario));
        $this->_view->assign('funcionario', Funcionario::select('nombre')->find($this->filtrarInt($funcionario)));
        $this->_view->assign('enviar', CTRL);

        if ($this->getAlphaNum('enviar') == CTRL) {
            $this->_view->assign('usuario', $_POST);

            if (!$this->getSql('clave') || strlen($this->getSql('clave')) < 8) {
                $this->_view->assign('_error', 'Ingrese una clave de al menos 8 caracteres');
                $this->_view->renderizar('add');
                exit;
            }

            if ($this->getSql('reclave') != $this->getSql('clave')) {
                $this->_view->assign('_error', 'Las claves ingresadas no coinciden');
                $this->_view->renderizar('add');
                exit;
            }

            #verificar que el funcionario ingresado no tenga una cuenta
            $usuario = Usuario::select('id')->where('funcionario_id', $this->filtrarInt($funcionario))->first();

            if ($usuario) {
                $this->_view->assign('_error', 'El funcionario ingresado ya tiene una cuenta de usuario... intente con otro');
                $this->_view->renderizar('add');
                exit;
            }

            $clave = $this->encriptar($this->getSql('clave'));

            $usuario = new Usuario;
            $usuario->clave = $clave;
            $usuario->activo = 1;
            $usuario->funcionario_id = $this->filtrarInt($funcionario);
            $usuario->save();

            Session::set('msg_success','La cuenta de usuario se ha registrado correctamente');

            $this->redireccionar('funcionarios/view/' . $this->filtrarInt($funcionario));
        }

        $this->_view->renderizar('add');
    }

    #############################################
    private function verificarUsuario($id)
    {
        if (!$this->filtrarInt($id)) {
            $this->redireccionar('funcionarios');
        }

        $usuario = Usuario::select('id')->find($this->filtrarInt($id));

        if (!$usuario) {
            $this->redireccionar('funcionarios');
        }
    }

    private function verificarFuncionario($id)
    {
        if (!$this->filtrarInt($id)) {
           $this->redireccionar('funcionarios');
        }

        $funcionario = Funcionario::select('id')->find($this->filtrarInt($id));
        //select id from funcionarios where id = $id;
        if (!$funcionario) {
            $this->redireccionar('funcionarios');
        }
    }

    private function encriptar($clave)
    {
        $clave = Hash::getHash('sha1', $clave, HASH_KEY);

        return $clave;
    }
}
