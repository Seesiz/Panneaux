<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
		$this->load->model('sheet');

		if(isset($_FILES['file'])){
			if(isset($_GET['error'])){
				$data['error'] = $_GET['error'];
			}
			$count = count($_FILES['file']['name']);
			if(file_exists('DATA/sheet.xlsx')){
				if(!unlink('DATA/sheet.xlsx')){
					redirect('Accueil?error=Une erreur a été rencontrer durant le traitement de votre fichier!');
				}
			}
			
			$data['titlePage'] = "Solar Control - Data";
			$this->load->view('component/header', $data);
			$this->load->view('component/loading');

			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();

			$numero = 0;
			for($i = 0; $i < $count; $i++){
				$extension = pathinfo($_FILES['file']['name'][$i], PATHINFO_EXTENSION);;
				if($extension == 'xlsx'){
					$table = $this->sheet->getData($_FILES['file']['tmp_name'][$i]);
					$lastRow = $sheet->getHighestRow();
					if($numero>0){
						$lastRow++;
					}
					$skipFirstRow = true;
					foreach($table->getRowIterator() as $row){
						if($skipFirstRow && $numero>0){
							$skipFirstRow = false;
							continue;
						}
						foreach($row->getCellIterator() as $cell){
							$sheet->setCellValue($cell->getColumn() . $lastRow, $cell->getValue());
						}
						$lastRow++;
					}
				} else {
					redirect('Accueil?error=Fichier non valide!');
				}
				$numero++;
			}

			$sheetName = 'DATA/sheet.xlsx';
			$writer = new Xlsx($spreadsheet);
			$writer->save($sheetName);
			
			$data['table'] = $this->sheet->getData('DATA/sheet.xlsx');

			$this->session->set_flashdata("jirama", $_POST["PU"]);

			$this->load->view('Estim/estimation', $data);
			$this->load->view('component/footer');
			
		} else {
			if(isset($_GET['error'])){
				$data['error'] = $_GET['error'];
				$data['titlePage'] = "Solar Control - Data";
				$this->load->view('component/header', $data);
				$this->load->view('component/loading');

				$data['table'] = $this->sheet->getData('DATA/sheet.xlsx');;

				$this->load->view('Estim/estimation', $data);
				$this->load->view('component/footer');
			} else {
				redirect('Accueil?error=Une erreur a été rencontrer durant le traitement de votre fichier!');
			}
		}
	}
}
