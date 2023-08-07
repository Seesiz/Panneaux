<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

class Estimation extends CI_Controller {
    public function index(){
        if(file_exists('DATA/sheet.xlsx')){
            $date = $_POST['date-column'];
            $jirama = $_POST['jirama-column'];
            $panneaux = $_POST['panneaux-column'];
            if($date != $jirama && $date!=$panneaux && $jirama!=$panneaux){
                $data['titlePage'] = "Solar Control - Result";
                $this->load->view('component/header', $data);
                $this->load->view('component/loading');

                $reader = IOFactory::createReader('Xlsx');
                $spreadsheet = $reader->load('DATA/sheet.xlsx');
                
                $workSheet = $spreadsheet->getSheet('0');
                $table = $workSheet->toArray();
    
                $data["sumPV"] = 0;
                $data["sumJI"] = 0;
                $i = 0;
                foreach($table as $row){
                    try{
                        if(is_numeric($row[$jirama])) {
                            $data["sumJI"] += $row[$jirama];
                        }
                        if(is_numeric($row[$panneaux])) {
                            $data["sumPV"] += $row[$panneaux];
                        }
                    } catch(Exception $e){
                        redirect('Accueil/start?error='.$e);
                    }
                    if($i != 0){
                        if(!isset($data["date"][date('d/M/Y',strtotime($row[$date]))][date('H',strtotime($row[$date]))])){
                            $data["date"][date('d/M/Y',strtotime($row[$date]))]["jirama"][date('H',strtotime($row[$date]))] = 0;
                            $data["date"][date('d/M/Y',strtotime($row[$date]))]["panneaux"][date('H',strtotime($row[$date]))] = 0;
                        }
                        $data["date"][date('d/M/Y',strtotime($row[$date]))]["jirama"][date('H',strtotime($row[$date]))] += $row[$jirama];
                        $data["date"][date('d/M/Y',strtotime($row[$date]))]["panneaux"][date('H',strtotime($row[$date]))] += $row[$panneaux];
                    }
                    $i++;
                }

                foreach(array_keys($data['date']) as $row){
                    $data['date'][$row]['journalier'] = 0;
                    foreach($data['date'][$row]['panneaux'] as $hour){
                        $hour /= 10;
                        $data['date'][$row]['journalier'] += $hour;
                    }
                }
                
                $this->load->view("Estim/result", $data);
                $this->load->view("component/footer");
            } else {
                redirect("Accueil/start?error=Les colonnes ne doivent pas être les mêmes!");
            }
        } else {
            redirect('Accueil?error=Premièrement, vous devez choisir votre fichier');
        }
    }
}