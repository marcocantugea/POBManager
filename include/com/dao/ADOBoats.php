<?php

/*
 * Copyright (C) 2016 Marco Cantu
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
 * Description of ADOBoats
 *
 * @author Marco Cantu
 */
class ADOBoats {
    private $mysqlconector;
    public $debug=false;
    
    public function __construct() {
        $this->mysqlconector= new MysqlConnector();
    }
    
    public function AddNewBoat($BoatObj){
        if(!empty($BoatObj)){
            $this->mysqlconector->OpenConnection();
            $boatnumber= mysqli_real_escape_string($this->mysqlconector->conn,$BoatObj->boatnumber);
            $boatlocation= mysqli_real_escape_string($this->mysqlconector->conn,$BoatObj->boatlocation);
            $active= mysqli_real_escape_string($this->mysqlconector->conn,$BoatObj->active);
            
            $sqlobj= new SqlQueryBuilder("insert");
            $sqlobj->setTable("t_lifeboats");
            $sqlobj->addColumn("boatnumber");
            $sqlobj->addValue($boatnumber);
            $sqlobj->addColumn("boatlocation");
            $sqlobj->addValue($boatlocation);
            $sqlobj->addColumn("active");
            $sqlobj->addValue($active);

            if($this->debug){
                echo '<br/>'. $sqlobj->buildQuery();
            }
            
            $result=  $this->mysqlconector->conn->query($sqlobj->buildQuery()) or trigger_error("Error ADOUsers::AddNewUser:mysqli=".mysqli_error($this->mysqlconector->conn),E_USER_ERROR);
            $this->mysqlconector->CloseDataBase();            
        }
        
    }
    
    public function UpdateBoat($BoatObj){
        if(!empty($BoatObj)){
            $this->mysqlconector->OpenConnection();
            $boatnumber= mysqli_real_escape_string($this->mysqlconector->conn,$BoatObj->boatnumber);
            $boatlocation= mysqli_real_escape_string($this->mysqlconector->conn,$BoatObj->boatlocation);
            $active= mysqli_real_escape_string($this->mysqlconector->conn,$BoatObj->active);
            $idboat=mysqli_real_escape_string($this->mysqlconector->conn,$BoatObj->idboat);
            
            $sqlobj= new SqlQueryBuilder("update");
            $sqlobj->setTable("t_lifeboats");
            $sqlobj->addColumn("boatnumber");
            $sqlobj->addValue($boatnumber);
            $sqlobj->addColumn("boatlocation");
            $sqlobj->addValue($boatlocation);
            $sqlobj->addColumn("active");
            $sqlobj->addValue($active);
            $sqlobj->setWhere("idboat=$idboat");

            if($this->debug){
                echo '<br/>'. $sqlobj->buildQuery();
            }
            
            $result=  $this->mysqlconector->conn->query($sqlobj->buildQuery()) or trigger_error("Error ADOUsers::AddNewUser:mysqli=".mysqli_error($this->mysqlconector->conn),E_USER_ERROR);
            $this->mysqlconector->CloseDataBase();
        }
    }
    
    public function ActiveBoat($BoatObj){
        if(!empty($BoatObj)){
            $this->mysqlconector->OpenConnection();
            $idboat=mysqli_real_escape_string($this->mysqlconector->conn,$BoatObj->idboat);
            
            $sqlobj= new SqlQueryBuilder("update");
            $sqlobj->setTable("t_lifeboats");
            $sqlobj->addColumn("active");
            $sqlobj->addValue(1);
            $sqlobj->setWhere("idboat=$idboat");

            if($this->debug){
                echo '<br/>'. $sqlobj->buildQuery();
            }
            
            $result=  $this->mysqlconector->conn->query($sqlobj->buildQuery()) or trigger_error("Error ADOUsers::AddNewUser:mysqli=".mysqli_error($this->mysqlconector->conn),E_USER_ERROR);
            $this->mysqlconector->CloseDataBase();
        }
    }
    
    public function DeactiveBoath($BoatObj){
        if(!empty($BoatObj)){
            if(!empty($BoatObj)){
            $this->mysqlconector->OpenConnection();
            $idboat=mysqli_real_escape_string($this->mysqlconector->conn,$BoatObj->idboat);
            
            $sqlobj= new SqlQueryBuilder("update");
            $sqlobj->setTable("t_lifeboats");
            $sqlobj->addColumn("active");
            $sqlobj->addValue(0);
            $sqlobj->setWhere("idboat=$idboat");

            if($this->debug){
                echo '<br/>'. $sqlobj->buildQuery();
            }
            
            $result=  $this->mysqlconector->conn->query($sqlobj->buildQuery()) or trigger_error("Error ADOUsers::AddNewUser:mysqli=".mysqli_error($this->mysqlconector->conn),E_USER_ERROR);
            $this->mysqlconector->CloseDataBase();
        }
        }
    }
    
    public function GetAllBoats($ListBoatObj){
        if(!empty($ListBoatObj)){
           $this->mysqlconector->OpenConnection();
            
            $sqlobj= new SqlQueryBuilder("select");
            $sqlobj->setTable("t_lifeboats");
            $sqlobj->addColumn("boatnumber");
            $sqlobj->addColumn("boatlocation");
            $sqlobj->addColumn("active");
            $sqlobj->addColumn("idboat");

            if($this->debug){
                echo '<br/>'. $sqlobj->buildQuery();
            }
            
            $result=  $this->mysqlconector->conn->query($sqlobj->buildQuery()) or trigger_error("Error ADOUsers::AddNewUser:mysqli=".mysqli_error($this->mysqlconector->conn),E_USER_ERROR);
            if($result->num_rows>0){
                while($row = $result->fetch_assoc()) {
                    $boat= new BoatObj();
                    $boat->idboat=$row['idboat'];
                    $boat->boatnumber=$row['boatnumber'];
                    $boat->boatlocation=$row['boatlocation'];
                    $boat->active=$row['active'];
                    $ListBoatObj->addItem($boat);
                }
            }
            $this->mysqlconector->CloseDataBase();           
        }
    }
    
    public function GetBoatById($BoatObj){
        if(!empty($BoatObj)){
            $this->mysqlconector->OpenConnection();
            $idboat=mysqli_real_escape_string($this->mysqlconector->conn,$BoatObj->idboat);
            
            $sqlobj= new SqlQueryBuilder("select");
            $sqlobj->setTable("t_lifeboats");
            $sqlobj->addColumn("boatnumber");
            $sqlobj->addColumn("boatlocation");
            $sqlobj->addColumn("active");
            $sqlobj->addColumn("idboat");
            $sqlobj->setWhere("idboat=$idboat");
            

            if($this->debug){
                echo '<br/>'. $sqlobj->buildQuery();
            }
            
            $result=  $this->mysqlconector->conn->query($sqlobj->buildQuery()) or trigger_error("Error ADOUsers::AddNewUser:mysqli=".mysqli_error($this->mysqlconector->conn),E_USER_ERROR);
            if($result->num_rows>0){
                while($row = $result->fetch_assoc()) {
                    $BoatObj->idboat=$row['idboat'];
                    $BoatObj->boatnumber=$row['boatnumber'];
                    $BoatObj->boatlocation=$row['boatlocation'];
                    $BoatObj->active=$row['active'];
                }
            }
            $this->mysqlconector->CloseDataBase();
        }
    }
    
    public function GetBoatsByQuery($ListBoatObj,$SqlQueryBuilder){
        if(!empty($ListBoatObj) && !empty($SqlQueryBuilder)){
            $this->mysqlconector->OpenConnection();
            
            $SqlQueryBuilder->setTable("t_lifeboats");
            $SqlQueryBuilder->addColumn("boatnumber");
            $SqlQueryBuilder->addColumn("boatlocation");
            $SqlQueryBuilder->addColumn("active");
            $SqlQueryBuilder->addColumn("idboat");
            
            if($this->debug){
                echo '<br/>'. $SqlQueryBuilder->buildQuery();
            }
            
            $result=  $this->mysqlconector->conn->query($SqlQueryBuilder->buildQuery()) or trigger_error("Error ADOUsers::AddNewUser:mysqli=".mysqli_error($this->mysqlconector->conn),E_USER_ERROR);
            if($result->num_rows>0){
                while($row = $result->fetch_assoc()) {
                    $BoatObj = new BoatObj();
                    $BoatObj->idboat=$row['idboat'];
                    $BoatObj->boatnumber=$row['boatnumber'];
                    $BoatObj->boatlocation=$row['boatlocation'];
                    $BoatObj->active=$row['active'];
                    $ListBoatObj->addItem($BoatObj);
                }
            }
            $this->mysqlconector->CloseDataBase();
        }
    }
    
}
