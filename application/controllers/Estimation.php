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
        
                    $data["sumPV"] = 0;
                    $data["sumJI"] = 0;
                    $i = 0;
                    foreach($table as $row){
                        try{
                            if(is_numeric($row[$jirama])) {
                                $data["sumJI"] += ($row[$jirama]);
                            }
                            if(is_numeric($row[$panneaux])) {
                                $data["sumPV"] += ($row[$panneaux]);
                            }
                        } catch(Exception $e){
                            redirect('Accueil/start?error='.$e);
                        }
                        if($i != 0){
                            //Ne supprimer pas, c'est encore utile
                            // if(!isset($data["date"][date('Y-m-j',strtotime($row[$date]))][date('H',strtotime($row[$date]))])){
                            //     $data["date"][date('Y-m-j',strtotime($row[$date]))]["jirama"][date('H',strtotime($row[$date]))] = 0;
                            //     $data["date"][date('Y-m-j',strtotime($row[$date]))]["panneaux"][date('H',strtotime($row[$date]))] = 0;
                            // }
                            // $data["date"][date('Y-m-j',strtotime($row[$date]))]["jirama"][date('H',strtotime($row[$date]))] += $row[$jirama];
                            // $data["date"][date('Y-m-j',strtotime($row[$date]))]["panneaux"][date('H',strtotime($row[$date]))] += $row[$panneaux];

                            if(!isset($data["date"][date('Y-m-j',strtotime($row[$date]))])){
                                $data["date"][date('Y-m-j',strtotime($row[$date]))]['journalierJI'] = 0;
                                $data["date"][date('Y-m-j',strtotime($row[$date]))]['journalierPV'] = 0;
                            }
                            $data["date"][date('Y-m-j',strtotime($row[$date]))]['journalierJI'] += $row[$jirama];
                            $data["date"][date('Y-m-j',strtotime($row[$date]))]['journalierPV'] += $row[$panneaux];
                        }
                        $i++;
                    }

                    $data['sumPV'] /= 1000;
                    $data['sumJI'] /= 1000;
    
                    $data['sumPV'] /= 10;
                    $data['sumJI'] /= 10;
    
                    //Ne supprimer pas, c'est encore utile
                    // foreach(array_keys($data['date']) as $row){
                    //     $data['date'][$row]['journalierPV'] = 0;
                    //     $data['date'][$row]['journalierJI'] = 0;
                    //     foreach($data['date'][$row]['panneaux'] as $hour){
                    //         $data['date'][$row]['journalierPV'] += $hour;
                    //     }
                    //     foreach($data['date'][$row]['jirama'] as $hour){
                    //         $data['date'][$row]['journalierJI'] += $hour;
                    //     }
                    // }

                    foreach(array_keys($data['date']) as $row){
                        $data['date'][$row]['journalierPV'] /= 1000;
                        $data['date'][$row]['journalierJI'] /= 1000;
                        $data['date'][$row]['journalierPV'] /= 10;
                        $data['date'][$row]['journalierJI'] /= 10;
                    }

                    $data['invalid'] = $this->sheet->insertConso($data);

                    $data['date'] = $this->sheet->getConsommation();
                    
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