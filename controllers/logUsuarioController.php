<?php
use models\LogUsuario;

class LogUsuarioController extends Controller
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

        $this->_view->assign('titulo', 'Reporte de Usuario'); // titulo del browser
        $this->_view->assign('title', 'Reporte de Usuario');  // titulo de la pag
        $this->_view->assign('logusuario', LogUsuario::select('id','id_usuario','nombre', 'rut', 'url', 'updated_at', 'created_at')->orderBy('created_at')->get());
        $this->_view->renderizar('index');

    }

}