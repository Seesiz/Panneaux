<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Accueil extends CI_Controller {
	public function index()
	{
		$data['titlePage'] = "Solar Control - Accueil";

		if(isset($_GET['error'])){
			$data['error'] = $_GET['error'];
		}
        $this->load->view('component/header', $data);
		$this->load->view('Accueil/start');
        $this->load->view('component/footer');
	}

	public function start(){
		$data = $_FILES["file"];
		$extension = pathinfo($data['name'], PATHINFO_EXTENSION);;
		if($extension == 'xlsx'){
			$data['titlePage'] = "Solar Control - Column";
			$this->load->view('component/header', $data);
			$this->load->view('component/loading');

			$reader = PHPExcel_IOFactory::createReaderForFile($data['tmp_name']);
			$excel_Obj = $reader->load($data['tmp_name']);
	
			$workSheet = $excel_Obj->getSheet('0');
			$data['table'] = $workSheet;

			$this->load->view('Estim/estimation', $data);
			$this->load->view('component/footer');
		} else {
			redirect('Accueil?error=Fichier non valide!');
		}
	}
}
