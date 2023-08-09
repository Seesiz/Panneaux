<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

class Sheet extends CI_Model { 
    public function getData($sheet){
        $reader = IOFactory::createReader('Xlsx');
        $spreadsheet = $reader->load($sheet);
        
        $workSheet = $spreadsheet->getSheet('0');
        return $workSheet;
    }

    public function isExist($date){
        $this->db->where("date", $date);
        $this->db->from("`conso-jour`");
        $row = $this->db->get();
        $row = $row->result_array();
        if(count($row)>0){
            return true;
        }
        return false;
    }

    public function getConsommation(){
        $this->db->from("`conso-jour`");
        $this->db->order_by('date','ASC');
        $data = $this->db->get();
        return $data->result_array();
    }

    public function insertConso($data){
        $invalidDate = []; 
        foreach(array_keys($data['date']) as $row){
            if(!$this->isExist($row)){
                $this->db->query("INSERT INTO `conso-jour` (date, JI, PV) VALUES('".$row."', ".($data['date'][$row]['journalierJI']).",".($data['date'][$row]['journalierPV']).")");
            } else {
                $invalidDate[] = $row;
            }
        }
        return $invalidDate;
    }

    public function delete($id){
        $this->db->where("id", $id);
        $this->db->from("`conso-jour`");
        $this->db->delete();
    }

    public function getBYMonth(){
        $this->db->from('byMONTH');
        $data = $this->db->get();
        return $data->result_array();
    }
}