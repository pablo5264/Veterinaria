<?php
class adminController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        // $this->verificarSession();
        // $this->verificarRolAdmin();
        $this->_view->assign('titulo','Administrar');
        $this->_view->renderizar('index');
    }
}
