<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

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
		if(isset($_POST['start']) && $_POST['start'] == "start"){
			if(isset($_GET['error'])){
				$data['error'] = $_GET['error'];
			}
			$extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);;
			if($extension == 'xlsx'){
				if(file_exists('DATA/sheet.xlsx')){
					if(!unlink('DATA/sheet.xlsx')){
						redirect('Accueil?error=Une erreur a été rencontrer durant le traitement de votre fichier!');
					}
				}
				if (move_uploaded_file($_FILES["file"]["tmp_name"], 'DATA/sheet.xlsx')) {
					$data['titlePage'] = "Solar Control - Data";
					$this->load->view('component/header', $data);
					$this->load->view('component/loading');
	
					$reader = IOFactory::createReader('Xlsx');
					$spreadsheet = $reader->load('DATA/sheet.xlsx');
					
					$workSheet = $spreadsheet->getSheet('0');
					$data['table'] = $workSheet;
	
					$this->load->view('Estim/estimation', $data);
					$this->load->view('component/footer');
				} else {
					redirect('Accueil?error=Une erreur a été rencontrer durant le traitement de votre fichier!');
				}
				
			} else {
				redirect('Accueil?error=Fichier non valide!');
			}
		} else {
			if(isset($_GET['error'])){
				$data['error'] = $_GET['error'];
				$data['titlePage'] = "Solar Control - Data";
				$this->load->view('component/header', $data);
				$this->load->view('component/loading');

				$reader = IOFactory::createReader('Xlsx');
				$spreadsheet = $reader->load('DATA/sheet.xlsx');
				
				$workSheet = $spreadsheet->getSheet('0');
				$data['table'] = $workSheet;

				$this->load->view('Estim/estimation', $data);
				$this->load->view('component/footer');
			} else {
				redirect('Accueil');
			}
		}
	}
}
