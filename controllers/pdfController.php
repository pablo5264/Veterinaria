<?php
use models\LogUsuario;

class pdfController extends Controller
{
	private $_pdf;
	
	public function __construct(){
		parent::__construct();
		$this->getLibrary('fpdf');
		ob_start();
		$this->_pdf = new FPDF;

	}
	
	function Header()
	{
		// Logo
		$this->_pdf->Image('logo.png',10,8,33);
		// Arial bold 15
		$this->_pdf->SetFont('Arial','B',15);
		// Movernos a la derecha
		$this->_pdf->Cell(80);
		// Título
		$this->_pdf->Cell(30,10,'Title',1,0,'C');
		// Salto de línea
		$this->_pdf->Ln(20);
	}
	
	function Footer()
	{
		// Posición: a 1,5 cm del final
		$this->SetY(-15);
		// Arial italic 8
		$this->SetFont('Arial','I',8);
		// Número de página
		$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	}


	public function index()
	{	
		$this->_pdf->addPage();
		$this->_pdf->AliasNbPages();
		$this->_pdf->SetFont('Arial', 'B', '12');
		$logusers = LogUsuario::select('id','id_usuario','nombre', 'rut', 'url', 'updated_at', 'created_at')->orderBy('created_at')->get();
		
		
		$this->_pdf->Cell(5,10, utf8_decode("id") ,1,0,'C',0);
		$this->_pdf->Cell(10,10, utf8_decode("id_u") ,1,0,'C',0);
		$this->_pdf->Cell(55,10, utf8_decode("Nombre") ,1,0,'C',0);
		$this->_pdf->Cell(30,10, utf8_decode("Rut") ,1,0,'C',0);
		//$this->_pdf->Cell(5,10, utf8_decode($user->url) ,1,0,'C',0);
		$this->_pdf->Cell(48,10, utf8_decode("Login") ,1,0,'C',0);
		$this->_pdf->Cell(48,10, utf8_decode("Logout") ,1,1,'C',0);

		foreach($logusers as $user )
		{
		$this->_pdf->Cell(5,10, utf8_decode($user->id) ,1,0,'C',0);
		$this->_pdf->Cell(10,10, utf8_decode($user->id_usuario) ,1,0,'C',0);
		$this->_pdf->Cell(55,10, utf8_decode($user->nombre) ,1,0,'C',0);
		$this->_pdf->Cell(30,10, utf8_decode($user->rut) ,1,0,'C',0);
		//$this->_pdf->Cell(5,10, utf8_decode($user->url) ,1,0,'C',0);
		$this->_pdf->Cell(48,10, utf8_decode($user->created_at) ,1,0,'C',0);
		$this->_pdf->Cell(48,10, utf8_decode($user->updated_at) ,1,1,'C',0);

		}


	
		$this->_pdf->Output();
		ob_end_flush(); 
	
	}
}
