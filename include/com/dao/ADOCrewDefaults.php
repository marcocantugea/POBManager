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
 * Description of ADOCrewDefaults
 *
 * @author MarcoCantu
 */
class ADOCrewDefaults {
    private $mysqlconector;
    public $debug=false;
    
    public function __construct() {
        $this->mysqlconector= new MysqlConnector();
    }
    
    public function AddNewDefault($CrewDefaultsObj){
        if(!empty($CrewDefaultsObj)){
            $this->mysqlconector->OpenConnection();
            $variabledef= mysqli_real_escape_string($this->mysqlconector->conn,$CrewDefaultsObj->variabledef);
            $valuedef= mysqli_real_escape_string($this->mysqlconector->conn,$CrewDefaultsObj->valuedef);
            $variabletype=mysqli_real_escape_string($this->mysqlconector->conn,$CrewDefaultsObj->variabletype);
            $idpersonel=mysqli_real_escape_string($this->mysqlconector->conn,$CrewDefaultsObj->idpersonel);
            $variabletitle=mysqli_real_escape_string($this->mysqlconector->conn,$CrewDefaultsObj->variabletitle);
            
            $sqlobj= new SqlQueryBuilder("insert");
            $sqlobj->setTable("t_personel_defaults");
            $sqlobj->addColumn("variabledef");
            $sqlobj->addValue($variabledef);
            $sqlobj->addColumn("valuedef");
            $sqlobj->addValue($valuedef);
            $sqlobj->addColumn("variabletype");
            $sqlobj->addValue($variabletype);
            $sqlobj->addColumn("idpersonel");
            $sqlobj->addValue($idpersonel);
            $sqlobj->addColumn("variabletitle");
            $sqlobj->addValue($variabletitle);

            if($this->debug){
                echo '<br/>'. $sqlobj->buildQuery();
            }
            
            $result=  $this->mysqlconector->conn->query($sqlobj->buildQuery()) or trigger_error("Error ADOUsers::AddNewUser:mysqli=".mysqli_error($this->mysqlconector->conn),E_USER_ERROR);
            $this->mysqlconector->CloseDataBase();
            
            $CrewDefaultsObj->idpersonel= $this->getlastid();
        }
    }
    
    public function getlastid(){
        $id =0;
        $this->mysqlconector->OpenConnection();
        $sql="select max(idpdefaults) as lastid from t_personel_defaults";
        $result=  $this->mysqlconector->conn->query($sql) or trigger_error("Error ADOUsers::AddNewUser:mysqli=".mysqli_error($this->mysqlconector->conn),E_USER_ERROR);
        if($result->num_rows>0){
            while($row = $result->fetch_assoc()) {
                $id=$row['lastid'];
            }
        }
        $this->mysqlconector->CloseDataBase();
        return $id;
        
    }
    
    public function UpdateDefault($CrewDefaultsObj){}
    
    public function DeleteDefault($CrewDefaultsObj){
        if(!empty($CrewDefaultsObj)){
            $this->mysqlconector->OpenConnection();
            $idpdefaults = mysqli_real_escape_string($this->mysqlconector->conn,$CrewDefaultsObj->idpdefaults);
            $sqlobj= new SqlQueryBuilder("delete");
            $sqlobj->setTable("t_personel_defaults");
            $sqlobj->setWhere("idpdefaults=$idpdefaults");
            
            if($this->debug){
                echo '<br/>'. $sqlobj->buildQuery();
            }
            $result=  $this->mysqlconector->conn->query($sqlobj->buildQuery()) or trigger_error("Error ADOUsers::AddNewUser:mysqli=".mysqli_error($this->mysqlconector->conn),E_USER_ERROR);
            $this->mysqlconector->CloseDataBase();
        }
    }
    
    public function GetDefaultByID($CrewDefaultsObj){}
    
    public function GetDefaultsByCrew($PersonelObj){
        if(!empty($PersonelObj)){
            if(!empty($PersonelObj->ListDefaults)){
                $PersonelObj->ListDefaults =  new ArrayList();
            }
            $this->mysqlconector->OpenConnection();
            $idpersonel= mysqli_real_escape_string($this->mysqlconector->conn,$PersonelObj->idpersonel);
            
            $sqlobj= new SqlQueryBuilder("select");
            $sqlobj->setTable("t_personel_defaults");
            $sqlobj->addColumn("variabledef");
            $sqlobj->addColumn("valuedef");
            $sqlobj->addColumn("variabletype");
            $sqlobj->addColumn("idpersonel");
            $sqlobj->addColumn("idpdefaults");
            $sqlobj->addColumn("variabletitle");
            $sqlobj->setWhere("idpersonel=$idpersonel");
            
             if($this->debug){
                echo '<br/>'. $sqlobj->buildQuery();
            }
            
            $result=  $this->mysqlconector->conn->query($sqlobj->buildQuery()) or trigger_error("Error ADOUsers::AddNewUser:mysqli=".mysqli_error($this->mysqlconector->conn),E_USER_ERROR);
            if($result->num_rows>0){
                 while($row = $result->fetch_assoc()) {
                    $crewdef= new CrewDefaultsObj();
                    $crewdef->idpdefaults=$row['idpdefaults'];
                    $crewdef->idpersonel=$row['idpersonel'];
                    $crewdef->valuedef=$row['valuedef'];
                    $crewdef->variabledef=$row['variabledef'];
                    $crewdef->variabletitle=$row['variabletitle'];
                    $crewdef->variabletype=$row['variabletype'];
                    $PersonelObj->ListDefaults->addItem($crewdef);
                    
                 }
            }
            $this->mysqlconector->CloseDataBase();
            
        }
    }
    
    public function GetDefaultsByQuery($ListCrewDefaults,$SQLQueryBuilder){
        if(!empty($CrewDefaultsObj)){
            $this->mysqlconector->OpenConnection();
            
            $SQLQueryBuilder= new SqlQueryBuilder("select");
            $SQLQueryBuilder->setTable("t_personel_defaults");
            $SQLQueryBuilder->addColumn("variabledef");
            $SQLQueryBuilder->addColumn("valuedef");
            $SQLQueryBuilder->addColumn("variabletype");
            $SQLQueryBuilder->addColumn("idpersonel");
            $SQLQueryBuilder->addColumn("idpdefaults");
            $SQLQueryBuilder->addColumn("variabletitle");

            if($this->debug){
                echo '<br/>'. $SQLQueryBuilder->buildQuery();
            }
            
            $result=  $this->mysqlconector->conn->query($SQLQueryBuilder->buildQuery()) or trigger_error("Error ADOUsers::AddNewUser:mysqli=".mysqli_error($this->mysqlconector->conn),E_USER_ERROR);
            if($result->num_rows>0){
                while($row = $result->fetch_assoc()) {
                    $crewdef= new CrewDefaultsObj();
                    $crewdef->idpdefaults=$row['idpdefaults'];
                    $crewdef->idpersonel=$row['idpersonel'];
                    $crewdef->valuedef=$row['valuedef'];
                    $crewdef->variabledef=$row['variabledef'];
                    $crewdef->variabletitle=$row['variabletitle'];
                    $crewdef->variabletype=$row['variabletype'];
                    $ListCrewDefaults->addItem($crewdef);
                }
            }
            $this->mysqlconector->CloseDataBase();
        }
    }
    
}
