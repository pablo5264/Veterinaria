<?php
use models\FuncionarioRol;
use models\Funcionario;
use models\Rol;

class funcionariorolesController extends Controller
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
        $this->verificarFuncionarioRol($id);
        $this->verificarMensajes();

        $this->_view->assign('titulo', 'Funcionario Rol');
        $this->_view->assign('title', 'Rol de Funcionario');
        $this->_view->assign('funcionarioRol', FuncionarioRol::with(['funcionario','rol'])->find($this->filtrarInt($id)));
        $this->_view->assign('enviar', CTRL);
        $this->_view->renderizar('view');
    }

    public function edit($id = null)
    {
        $this->verificarFuncionarioRol($id);

        $this->_view->assign('titulo', 'Editar Funcionario Rol');
        $this->_view->assign('title', 'Editar Rol de Funcionario');
        $this->_view->assign('button', 'Editar');
        $this->_view->assign('ruta', 'funcionarioroles/view/' . $this->filtrarInt($id));
        $this->_view->assign('roles', Rol::select('id','nombre')->orderBy('nombre')->get());
        $this->_view->assign('funcionarioRol', FuncionarioRol::with(['funcionario','rol'])->find($this->filtrarInt($id)));
        $this->_view->assign('enviar', CTRL);

        if ($this->getAlphaNum('enviar') == CTRL) {

            if (!$this->getInt('rol')) {
                $this->_view->assign('_error','Seleccione el rol');
                $this->_view->renderizar('edit');
                exit;
            }

            $funcionarioRol = FuncionarioRol::select('funcionario_id')->find($this->filtrarInt($id));
            $funcionarioRol = FuncionarioRol::select('id')->where('funcionario_id', $funcionarioRol->funcionario_id)->where('rol_id', $this->getInt('rol'))->first();

            if ($funcionarioRol) {
                $this->_view->assign('_error','El rol y el funcionario ingresados ya existen... intente con otra combinación');
                $this->_view->renderizar('edit');
                exit;
            }

            $funcionarioRol = FuncionarioRol::find($this->filtrarInt($id));
            $funcionarioRol->rol_id = $this->getInt('rol');
            $funcionarioRol->save();

            Session::set('msg_success','El rol del funcionario se ha modificado correctamente');

            $this->redireccionar('funcionarioroles/view/' . $this->filtrarInt($id));
        }

        $this->_view->renderizar('edit');
    }

    public function add($funcionario = null)
    {
        $this->verificarFuncionario($funcionario);

        $this->_view->assign('titulo', 'Nuevo Funcionario Rol');
        $this->_view->assign('title', 'Nuevo Rol de Funcionario');
        $this->_view->assign('button', 'Guardar');
        $this->_view->assign('ruta', 'funcionarios/view/' . $this->filtrarInt($funcionario));
        $this->_view->assign('roles', Rol::select('id','nombre')->orderBy('nombre')->get());
        $this->_view->assign('funcionario', Funcionario::select('id','nombre')->find($this->filtrarInt($funcionario)));
        $this->_view->assign('enviar', CTRL);

        if ($this->getAlphaNum('enviar') == CTRL) {
            $this->_view->assign('funcionarioRol', $_POST);

            if (!$this->getInt('rol')) {
                $this->_view->assign('_error','Seleccione el rol');
                $this->_view->renderizar('add');
                exit;
            }

            $funcionarioRol = FuncionarioRol::select('id')->where('rol_id', $this->getInt('rol'))->where('funcionario_id',$this->filtrarInt($funcionario))->first();

            if ($funcionarioRol) {
                $this->_view->assign('_error','El rol y el funcionario ingresados ya existen... intente con otra combinación');
                $this->_view->renderizar('add');
                exit;
            }

            $funcionarioRol = new FuncionarioRol;
            $funcionarioRol->funcionario_id = $this->filtrarInt($funcionario);
            $funcionarioRol->rol_id = $this->getInt('rol');
            $funcionarioRol->save();

            Session::set('msg_success','El rol del funcionario se ha registrado correctamente');

            $this->redireccionar('funcionarios/view/' . $this->filtrarInt($funcionario));
        }

        $this->_view->renderizar('add');
    }

    public function delete($id = null)
    {
        $this->verificarFuncionarioRol($id);

        $funcionarioRol = FuncionarioRol::find($this->filtrarInt($id));
        $funcionario = $funcionarioRol->funcionario_id;
        $funcionarioRol->delete();

        Session::set('msg_success','El rol del funcionario se ha eliminado correctamente');

        $this->redireccionar('funcionarios/view/' . $funcionario);
    }

    ####################################################
    public function verificarFuncionarioRol($id)
    {
        if (!$this->filtrarInt($id)) {
            $this->redireccionar('funcionarios');
        }

        $funcionarioRol = FuncionarioRol::select('id')->find($this->filtrarInt($id));

        if (!$funcionarioRol) {
            $this->redireccionar('funcionarios');
        }
    }

    public function verificarFuncionario($id)
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
