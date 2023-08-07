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
                        if(!isset($data["date"][date('d/M/Y',strtotime($row[$date]))])){
                            $data["date"][date('d/M/Y',strtotime($row[$date]))]["jirama"] = 0;
                            $data["date"][date('d/M/Y',strtotime($row[$date]))]["panneaux"] = 0;
                            $data["date"][date('d/M/Y',strtotime($row[$date]))]["nbr"] = 0;
                        }
                        $data["date"][date('d/M/Y',strtotime($row[$date]))]["jirama"] += $row[$jirama];
                        $data["date"][date('d/M/Y',strtotime($row[$date]))]["panneaux"] += $row[$panneaux];
                        $data["date"][date('d/M/Y',strtotime($row[$date]))]["nbr"] += 1;
                    }
                    $i++;
                } 
                foreach($data["date"] as $row){
                    $row["jirama"] /= $row["nbr"];
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