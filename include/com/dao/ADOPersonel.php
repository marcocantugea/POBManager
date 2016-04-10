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
 * Description of ADOPersonel
 *
 * @author MarcoCantu
 */
class ADOPersonel {
    private $mysqlconector;
    public $debug=false;
    
    public function __construct() {
        $this->mysqlconector= new MysqlConnector();
    }
    
    public function AddNewMember($PersonelObj){
        if(!empty($PersonelObj)){
            $this->mysqlconector->OpenConnection();
            $names= mysqli_real_escape_string($this->mysqlconector->conn,$PersonelObj->names);
            $lastname= mysqli_real_escape_string($this->mysqlconector->conn,$PersonelObj->lastname);
            $birthday= mysqli_real_escape_string($this->mysqlconector->conn,$PersonelObj->birthday);
            $category= mysqli_real_escape_string($this->mysqlconector->conn,$PersonelObj->category);
            $photopath= mysqli_real_escape_string($this->mysqlconector->conn,$PersonelObj->photopath);
            $sex= mysqli_real_escape_string($this->mysqlconector->conn,$PersonelObj->sex);
            $nationality= mysqli_real_escape_string($this->mysqlconector->conn,$PersonelObj->nationality);
            $crewgroup= mysqli_real_escape_string($this->mysqlconector->conn,$PersonelObj->crewgroup);
             
            $sqlobj= new SqlQueryBuilder("insert");
            $sqlobj->setTable("t_personel");
            $sqlobj->addColumn("names");
            $sqlobj->addValue($names);
            $sqlobj->addColumn("lastname");
            $sqlobj->addValue($lastname);
            $sqlobj->addColumn("birthday");
            $sqlobj->addValue($birthday);
            $sqlobj->addColumn("category");
            $sqlobj->addValue($category);
            $sqlobj->addColumn("photopath");
            $sqlobj->addValue($photopath);
            $sqlobj->addColumn("sex");
            $sqlobj->addValue($sex);
            $sqlobj->addColumn("nationality");
            $sqlobj->addValue($nationality);
            $sqlobj->addColumn("crewgroup");
            $sqlobj->addValue($crewgroup);

            if($this->debug){
                echo '<br/>'. $sqlobj->buildQuery();
            }
            
            $result=  $this->mysqlconector->conn->query($sqlobj->buildQuery()) or trigger_error("Error ADOUsers::AddNewUser:mysqli=".mysqli_error($this->mysqlconector->conn),E_USER_ERROR);
            $this->mysqlconector->CloseDataBase();
        }
    }
    public function UpdateMember($PersonelObj){
        if(!empty($PersonelObj)){
            $this->mysqlconector->OpenConnection();
            $names= mysqli_real_escape_string($this->mysqlconector->conn,$PersonelObj->names);
            $lastname= mysqli_real_escape_string($this->mysqlconector->conn,$PersonelObj->lastname);
            $birthday= mysqli_real_escape_string($this->mysqlconector->conn,$PersonelObj->birthday);
            $category= mysqli_real_escape_string($this->mysqlconector->conn,$PersonelObj->category);
            $photopath= mysqli_real_escape_string($this->mysqlconector->conn,$PersonelObj->photopath);
            $sex= mysqli_real_escape_string($this->mysqlconector->conn,$PersonelObj->sex);
            $nationality= mysqli_real_escape_string($this->mysqlconector->conn,$PersonelObj->nationality);
            $crewgroup= mysqli_real_escape_string($this->mysqlconector->conn,$PersonelObj->crewgroup);
            $idpersonel= mysqli_real_escape_string($this->mysqlconector->conn,$PersonelObj->idpersonel);
             
            $sqlobj= new SqlQueryBuilder("update");
            $sqlobj->setTable("t_personel");
            $sqlobj->addColumn("names");
            $sqlobj->addValue($names);
            $sqlobj->addColumn("lastname");
            $sqlobj->addValue($lastname);
            $sqlobj->addColumn("birthday");
            $sqlobj->addValue($birthday);
            $sqlobj->addColumn("category");
            $sqlobj->addValue($category);
            $sqlobj->addColumn("photopath");
            $sqlobj->addValue($photopath);
            $sqlobj->addColumn("sex");
            $sqlobj->addValue($sex);
            $sqlobj->addColumn("nationality");
            $sqlobj->addValue($nationality);
            $sqlobj->addColumn("crewgroup");
            $sqlobj->addValue($crewgroup);
            $sqlobj->setWhere("idpersonel=$idpersonel");

            if($this->debug){
                echo '<br/>'. $sqlobj->buildQuery();
            }
            
            $result=  $this->mysqlconector->conn->query($sqlobj->buildQuery()) or trigger_error("Error ADOUsers::AddNewUser:mysqli=".mysqli_error($this->mysqlconector->conn),E_USER_ERROR);
            $this->mysqlconector->CloseDataBase();
        }
    }
    
    public function getAllMembers($ListPersonelObj){
        if(!empty($ListPersonelObj)){
            $this->mysqlconector->OpenConnection();

            $sqlobj= new SqlQueryBuilder("select");
            $sqlobj->setTable("t_personel");
            $sqlobj->addColumn("names");
            $sqlobj->addColumn("lastname");
            $sqlobj->addColumn("birthday");
            $sqlobj->addColumn("category");
            $sqlobj->addColumn("photopath");
            $sqlobj->addColumn("sex");
            $sqlobj->addColumn("nationality");
            $sqlobj->addColumn("crewgroup");
            $sqlobj->addColumn("idpersonel");
            //$sqlobj->setWhere("idpersonel=$idpersonel");
            
            if($this->debug){
                echo '<br/>'. $sqlobj->buildQuery();
            }
            
            $result=  $this->mysqlconector->conn->query($sqlobj->buildQuery()) or trigger_error("Error ADOUsers::AddNewUser:mysqli=".mysqli_error($this->mysqlconector->conn),E_USER_ERROR);
            if($result->num_rows>0){
                while($row = $result->fetch_assoc()) {
                    $crew= new PersonelObj();
                    $crew->names=$row['names'];
                    $crew->lastname=$row['lastname'];
                    $crew->birthday=$row['birthday'];
                    $crew->category=$row['category'];
                    $crew->photopath=$row['photopath'];
                    $crew->sex=$row['sex'];
                    $crew->nationality=$row['nationality'];
                    $crew->crewgroup=$row['crewgroup'];
                    $crew->idpersonel=$row['idpersonel'];
                    
                    $ListPersonelObj->addItem($crew);
                }
            }
            $this->mysqlconector->CloseDataBase();
        }
    }
    
    public function getMemberById($PersonelObj){
        if(!empty($PersonelObj)){
            $this->mysqlconector->OpenConnection();
            $idpersonel= mysqli_real_escape_string($this->mysqlconector->conn,$PersonelObj->idpersonel);

            $sqlobj= new SqlQueryBuilder("select");
            $sqlobj->setTable("t_personel");
            $sqlobj->addColumn("names");
            $sqlobj->addColumn("lastname");
            $sqlobj->addColumn("date_format(birthday,'%m/%d/%Y') as birthday");
            $sqlobj->addColumn("category");
            $sqlobj->addColumn("photopath");
            $sqlobj->addColumn("sex");
            $sqlobj->addColumn("nationality");
            $sqlobj->addColumn("crewgroup");
            $sqlobj->addColumn("idpersonel");
            $sqlobj->setWhere("idpersonel=$idpersonel");
            
            if($this->debug){
                echo '<br/>'. $sqlobj->buildQuery();
            }
            
            $result=  $this->mysqlconector->conn->query($sqlobj->buildQuery()) or trigger_error("Error ADOUsers::AddNewUser:mysqli=".mysqli_error($this->mysqlconector->conn),E_USER_ERROR);
            if($result->num_rows>0){
                while($row = $result->fetch_assoc()) {
                    $PersonelObj->names=$row['names'];
                    $PersonelObj->lastname=$row['lastname'];
                    $PersonelObj->birthday=$row['birthday'];
                    $PersonelObj->category=$row['category'];
                    $PersonelObj->photopath=$row['photopath'];
                    $PersonelObj->sex=$row['sex'];
                    $PersonelObj->nationality=$row['nationality'];
                    $PersonelObj->crewgroup=$row['crewgroup'];
                    $PersonelObj->idpersonel=$row['idpersonel'];
                }
            }
            $this->mysqlconector->CloseDataBase();
        }
    }
    
    public function getMemberByQuery($PersonelObj,$SQLQueryBuilder){
        if(!empty($PersonelObj)){
            $this->mysqlconector->OpenConnection();
            
            $SQLQueryBuilder->setTable("t_personel");
            $SQLQueryBuilder->addColumn("names");
            $SQLQueryBuilder->addColumn("lastname");
            $SQLQueryBuilder->addColumn("birthday");
            $SQLQueryBuilder->addColumn("category");
            $SQLQueryBuilder->addColumn("photopath");
            $SQLQueryBuilder->addColumn("sex");
            $SQLQueryBuilder->addColumn("nationality");
            $SQLQueryBuilder->addColumn("crewgroup");
            $SQLQueryBuilder->addColumn("idpersonel");
            
            if($this->debug){
                echo '<br/>'. $SQLQueryBuilder->buildQuery();
            }
            
            $result=  $this->mysqlconector->conn->query($SQLQueryBuilder->buildQuery()) or trigger_error("Error ADOUsers::AddNewUser:mysqli=".mysqli_error($this->mysqlconector->conn),E_USER_ERROR);
            if($result->num_rows>0){
                while($row = $result->fetch_assoc()) {
                    $PersonelObj->names=$row['names'];
                    $PersonelObj->lastname=$row['lastname'];
                    $PersonelObj->birthday=$row['birthday'];
                    $PersonelObj->category=$row['category'];
                    $PersonelObj->photopath=$row['photopath'];
                    $PersonelObj->sex=$row['sex'];
                    $PersonelObj->nationality=$row['nationality'];
                    $PersonelObj->crewgroup=$row['crewgroup'];
                    $PersonelObj->idpersonel=$row['idpersonel'];
                }
            }
            $this->mysqlconector->CloseDataBase();
        }
    }
}
