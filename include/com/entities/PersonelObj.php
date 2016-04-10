<?php

/*
 * Copyright (C) 2016 MarcoCantu
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */

/**
 * Description of PersonelObj
 *
 * @author MarcoCantu
 */
class PersonelObj {
    public $idpersonel;
    public $names;
    public $lastname;
    public $birthday;
    public $category;
    public $photopath;
    public $sex;
    public $nationality;
    public $crewgroup;
    public $CabinObj;
    public $ListBoatObj;
    public $CompanyObj;
    public $ShiftObj;
    public $ListCrewDocumentsObj;
    public $ListDefaults;
    
    public function GetDefaults(){
        if(empty($this->ListDefaults)){
            $this->ListDefaults = new ArrayList();
            $_ADOCrewDefaults=  new ADOCrewDefaults();
            $_ADOCrewDefaults->GetDefaultsByCrew($this);
        }
    }
    
    public function SearchDefaultsByVariable($variablename){
        $returnvalue="";
        if(!empty($this->ListDefaults)){
            foreach($this->ListDefaults->array as $item){
                if($item->variabledef==$variablename){
                    $returnvalue=$item->valuedef;
                }
            }
        }
        return $returnvalue;
    }
    
    public function SearchDefaultsByType($type){
        $returnvalue="";
        if(!empty($this->ListDefaults)){
            foreach($this->ListDefaults->array as $item){
                if($item->variabletype==$type){
                    $returnvalue=$item->valuedef;
                }
            }
        }
        return $returnvalue;
    }
    
    public function SearchDefaultsByTitle($title){
        $returnvalue="";
        if(!empty($this->ListDefaults)){
            foreach($this->ListDefaults->array as $item){
                if($item->variabletitle==$title){
                    $returnvalue=$item->valuedef;
                }
            }
        }
        return $returnvalue;
    }
    
    public function GetDocuments(){
        if($this->idpersonel>0){
            $_ADOCrewDocuments = new ADOCrewDocuments();
            $_ADOCrewDocuments->GetDocumentsByPersonel($this);
        }
    }
    
}
