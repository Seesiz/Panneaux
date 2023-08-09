<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

class Estimation extends CI_Controller {
    public function index(){
        $this->load->model("sheet");
        if(isset($this->session->jirama)){
            if(file_exists('DATA/sheet.xlsx')){
                $date = $_POST['date-column'];
                $jirama = $_POST['jirama-column'];
                $panneaux = $_POST['panneaux-column'];
                if($date != $jirama && $date!=$panneaux && $jirama!=$panneaux){
                    $data['titlePage'] = "Solar Control - Result";
                    $this->load->view('component/header', $data);
                    $this->load->view('component/loading');
                    
                    $workSheet = $this->sheet->getData('DATA/sheet.xlsx');
                    $table = $workSheet->toArray();
        
                    $i = 0;
                    foreach($table as $row){
                        if($i != 0){
                            if(!isset($data["date"][date('Y-m-j',strtotime($row[$date]))])){
                                $data["date"][date('Y-m-j',strtotime($row[$date]))]['journalierJI'] = 0;
                                $data["date"][date('Y-m-j',strtotime($row[$date]))]['journalierPV'] = 0;
                            }
                            $data["date"][date('Y-m-j',strtotime($row[$date]))]['journalierJI'] += $row[$jirama];
                            $data["date"][date('Y-m-j',strtotime($row[$date]))]['journalierPV'] += $row[$panneaux];
                        }
                        $i++;
                    }
                    foreach(array_keys($data['date']) as $row){
                        $data['date'][$row]['journalierPV'] /= 1000;
                        $data['date'][$row]['journalierJI'] /= 1000;
                        $data['date'][$row]['journalierPV'] /= 10;
                        $data['date'][$row]['journalierJI'] /= 10;
                    }

                    $data['invalid'] = $this->sheet->insertConso($data);

                    $data['date'] = $this->sheet->getConsommation();
                    $data['byMonth'] = $this->sheet->getBYMonth();
                    
                    $this->load->view("Estim/result", $data);
                    $this->load->view("component/footer");
                } else {
                    redirect("Accueil/start?error=Les colonnes ne doivent pas être les mêmes!");
                }
            } else {
                redirect('Accueil?error=Premièrement, vous devez choisir votre fichier');
            }
        } else {
            redirect("Accueil?error=Session expiré");
        }
    }

    public function delete(){
        if(isset($_GET['id'])){
            $this->load->model("sheet");
            $this->sheet->delete($_GET['id']);
        }
    }
}