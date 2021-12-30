<?php
use models\Telefono;
use models\Funcionario;
use models\Cliente;

class telefonosController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        // $this->verificarSession();
        // $this->verificarRolAdminSuper();
    }

    public function index()
    {
        # code...
    }

    public function view($id = null)
    {
        $this->verificarTelefono($id);
        $this->verificarMensajes();

        $telefono = Telefono::find($this->filtrarInt($id));

        if ($telefono->telefonoable_type == 'Funcionario') {
            $usuario = Funcionario::find($telefono->telefonoable_id);
            $ruta = 'funcionarios/view/' . $usuario->id;
        }elseif ($telefono->telefonoable_type == 'Cliente') {
            $usuario = Cliente::find($telefono->telefonoable_id);
            $ruta = 'clientes/view/' . $usuario->id;
        }elseif ($telefono->telefonoable_type == 'Proveedor') {
            $usuario = '';
            $ruta = '';
        }

        $this->_view->assign('titulo','Telefono');
        $this->_view->assign('title','Teléfono');
        $this->_view->assign('telefono', $telefono);
        $this->_view->assign('usuario', $usuario);
        $this->_view->assign('ruta', $ruta);
        $this->_view->renderizar('view');
    }

    public function edit($id = null)
    {
        $this->verificarTelefono($id);

        $this->_view->assign('titulo', 'Editar Telefono');
        $this->_view->assign('title', 'Editar Teléfono');
        $this->_view->assign('button', 'Editar');
        $this->_view->assign('ruta', 'telefonos/view/' . $this->filtrarInt($id));
        $this->_view->assign('telefono', Telefono::find($this->filtrarInt($id)));
        $this->_view->assign('enviar', CTRL);

        if ($this->getAlphaNum('enviar') == CTRL) {

            if (!$this->getInt('numero') || strlen($this->getInt('numero')) != 9) {
                $this->_view->assign('_error','Ingrese un teléfono de 9 dígitos');
                $this->_view->renderizar('edit');
                exit;
            }

            if (!$this->getInt('movil')) {
                $this->_view->assign('_error','Seleccione el tipo de teléfono');
                $this->_view->renderizar('edit');
                exit;
            }

            $telefono = Telefono::select('id')->where('numero', $this->getInt('numero'))->where('movil', $this->getInt('movil'))->first();

            if ($telefono) {
                $this->_view->assign('_error','El teléfono ingresado ya existe... modifique el número o el tipo para continuar');
                $this->_view->renderizar('edit');
                exit;
            }

            $telefono = Telefono::find($this->filtrarInt($id));
            $telefono->numero = $this->getInt('numero');
            $telefono->movil = $this->getInt('movil');
            $telefono->save();

            Session::set('msg_success', 'El teléfono se ha modificado correctamente');

            $this->redireccionar('telefonos/view/' . $this->filtrarInt($id));
        }

        $this->_view->renderizar('edit');
    }

    public function add($type_id = null, $type = null)
    {
        if ($type == 'Funcionario') {
            $ruta = 'funcionarios/view/' . $this->filtrarInt($type_id);
            $modeloUsuario = Funcionario::find($this->filtrarInt($type_id));
            $type = $type;
        }elseif ($type == 'Cliente') {
            $ruta = 'clientes/view/' . $this->filtrarInt($type_id);
            $modeloUsuario = Cliente::find($this->filtrarInt($type_id));
            $type = $type;
        }elseif ($type == 'Proveedor') {
            $ruta = '';
            $modeloUsuario = '';
            $type = $type;
        }

        $this->_view->assign('titulo','Nuevo Telefono');
        $this->_view->assign('title','Nuevo Teléfono');
        $this->_view->assign('button','Guardar');
        $this->_view->assign('ruta', $ruta);
        $this->_view->assign('$modeloUsuario', $modeloUsuario);
        $this->_view->assign('enviar', CTRL);

        if ($this->getAlphaNum('enviar') == CTRL) {
            $this->_view->assign('telefono', $_POST);

            //print_r($_POST);exit;

            if (!$this->getInt('numero') || strlen($this->getInt('numero')) != 9) {
                $this->_view->assign('_error', 'Ingrese un número de teléfono de 9 dígitos');
                $this->_view->renderizar('add');
                exit;
            }

            if (!$this->getInt('movil')) {
                $this->_view->assign('_error', 'Seleccione un opción para el teléfono');
                $this->_view->renderizar('add');
                exit;
            }

            $telefono = Telefono::select('id')->where('numero', $this->getInt('telefono'))->first();

            if ($telefono) {
                $this->_view->assign('_error', 'El teléfono ingresado ya existe... intente con otro');
                $this->_view->renderizar('add');
                exit;
            }

            $telefono = new Telefono;
            $telefono->numero = $this->getInt('numero');
            $telefono->movil = $this->getInt('movil');
            $telefono->telefonoable_id = $modeloUsuario->id;
            $telefono->telefonoable_type = $type;
            $telefono->save();

            Session::set('msg_success', 'El teléfono se ha registrado correctamente');

            $this->redireccionar($ruta);
        }

        $this->_view->renderizar('add');
    }

    public function delete($id = null)
    {
        $this->verificarTelefono($id);

        $telefono = Telefono::find($this->filtrarInt($id));

        if ($telefono->telefonoable_type == 'Funcionario') {
            $usuario = Funcionario::select('id')->find($telefono->telefonoable_id);
            $ruta = 'funcionarios/view/' . $usuario->id;
        }elseif ($telefono->telefonoable_type == 'Cliente') {
            $usuario = Cliente::select('id')->find($telefono->telefonoable_id);
            $ruta = 'clientes/view/' . $usuario->id;
        }elseif ($telefono->telefonoable_type == 'Proveedor') {
            $usuario = '';
            $ruta = '';
        }

        $telefono->delete();

        Session::set('msg_success','El teléfono se ha eliminado correctamente');

        $this->redireccionar($ruta);
    }

    ##########################################################
    private function verificarTelefono($id)
    {
        if (!$this->filtrarInt($id)) {
            $this->redireccionar('funcionarios');
        }

        $telefono = Telefono::select('id')->find($this->filtrarInt($id));

        if (!$telefono) {
            $this->redireccionar('funcionarios');
        }
    }
}
