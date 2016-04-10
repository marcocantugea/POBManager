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
 * Description of ADOCabins
 *
 * @author MarcoCantu
 */
class ADOCabins {
    private $mysqlconector;
    public $debug=false;
    
    public function __construct() {
        $this->mysqlconector= new MysqlConnector();
    }
    
    public function AddNewCabin($CabinObj){
        if(!empty($CabinObj)){
            $this->mysqlconector->OpenConnection();
            $cabin= mysqli_real_escape_string($this->mysqlconector->conn,$CabinObj->cabin);
            $active=  mysqli_real_escape_string($this->mysqlconector->conn,$CabinObj->active);
            $capofcabin=  mysqli_real_escape_string($this->mysqlconector->conn,$CabinObj->capofcabin);
            $telephone=  mysqli_real_escape_string($this->mysqlconector->conn,$CabinObj->telephone);
            
            $sqlobj= new SqlQueryBuilder("insert");
            $sqlobj->setTable("t_cabins");
            $sqlobj->addColumn("cabin");
            $sqlobj->addValue($cabin);
            $sqlobj->addColumn("active");
            $sqlobj->addValue($active);
            $sqlobj->addColumn("capofcabin");
            $sqlobj->addValue($capofcabin);
            $sqlobj->addColumn("telephone");
            $sqlobj->addValue($telephone);

            if($this->debug){
                echo '<br/>'. $sqlobj->buildQuery();
            }
            
            $result=  $this->mysqlconector->conn->query($sqlobj->buildQuery()) or trigger_error("Error ADOUsers::AddNewUser:mysqli=".mysqli_error($this->mysqlconector->conn),E_USER_ERROR);
            $this->mysqlconector->CloseDataBase();
        }
    }
    
    public function UpdateCabin($CabinObj){
        if(!empty($CabinObj)){
            $this->mysqlconector->OpenConnection();
            $idcabin= mysqli_real_escape_string($this->mysqlconector->conn,$CabinObj->idcabin);
            $cabin= mysqli_real_escape_string($this->mysqlconector->conn,$CabinObj->cabin);
            $active=  mysqli_real_escape_string($this->mysqlconector->conn,$CabinObj->active);
            $capofcabin=  mysqli_real_escape_string($this->mysqlconector->conn,$CabinObj->capofcabin);
            $telephone=  mysqli_real_escape_string($this->mysqlconector->conn,$CabinObj->telephone);
            
            $sqlobj= new SqlQueryBuilder("update");
            $sqlobj->setTable("t_cabins");
            $sqlobj->addColumn("cabin");
            $sqlobj->addValue($cabin);
            $sqlobj->addColumn("active");
            $sqlobj->addValue($active);
            $sqlobj->addColumn("capofcabin");
            $sqlobj->addValue($capofcabin);
            $sqlobj->addColumn("telephone");
            $sqlobj->addValue($telephone);
            $sqlobj->setWhere("idcabin=$idcabin");

            if($this->debug){
                echo '<br/>'. $sqlobj->buildQuery();
            }
            
            $result=  $this->mysqlconector->conn->query($sqlobj->buildQuery()) or trigger_error("Error ADOUsers::AddNewUser:mysqli=".mysqli_error($this->mysqlconector->conn),E_USER_ERROR);
            $this->mysqlconector->CloseDataBase();
        }
    }
    
    public function ActivateCabin($CabinObj){
        if(!empty($CabinObj)){
            $this->mysqlconector->OpenConnection();
            $idcabin= mysqli_real_escape_string($this->mysqlconector->conn,$CabinObj->idcabin);
            
            $sqlobj= new SqlQueryBuilder("update");
            $sqlobj->setTable("t_cabins");
            $sqlobj->addColumn("active");
            $sqlobj->addValue(1);
            $sqlobj->setWhere("idcabin=$idcabin");

            if($this->debug){
                echo '<br/>'. $sqlobj->buildQuery();
            }
            
            $result=  $this->mysqlconector->conn->query($sqlobj->buildQuery()) or trigger_error("Error ADOUsers::AddNewUser:mysqli=".mysqli_error($this->mysqlconector->conn),E_USER_ERROR);
            $this->mysqlconector->CloseDataBase();
        }
    }
    
    public function DeactivateCabin($CabinObj){
        if(!empty($CabinObj)){
            $this->mysqlconector->OpenConnection();
            $idcabin= mysqli_real_escape_string($this->mysqlconector->conn,$CabinObj->idcabin);
            
            $sqlobj= new SqlQueryBuilder("update");
            $sqlobj->setTable("t_cabins");
            $sqlobj->addColumn("active");
            $sqlobj->addValue(0);
            $sqlobj->setWhere("idcabin=$idcabin");

            if($this->debug){
                echo '<br/>'. $sqlobj->buildQuery();
            }
            
            $result=  $this->mysqlconector->conn->query($sqlobj->buildQuery()) or trigger_error("Error ADOUsers::AddNewUser:mysqli=".mysqli_error($this->mysqlconector->conn),E_USER_ERROR);
            $this->mysqlconector->CloseDataBase();
        }
    }
    
    public function GetAllCabins($ListCabinObj){
        if(!empty($ListCabinObj)){
            $this->mysqlconector->OpenConnection();
            
            $sqlobj= new SqlQueryBuilder("select");
            $sqlobj->setTable("t_cabins");
            $sqlobj->addColumn("cabin");
            $sqlobj->addColumn("active");
            $sqlobj->addColumn("capofcabin");
            $sqlobj->addColumn("telephone");
            $sqlobj->addColumn("idcabin");

            if($this->debug){
                echo '<br/>'. $sqlobj->buildQuery();
            }
            
            $result=  $this->mysqlconector->conn->query($sqlobj->buildQuery()) or trigger_error("Error ADOUsers::AddNewUser:mysqli=".mysqli_error($this->mysqlconector->conn),E_USER_ERROR);
            if($result->num_rows>0){
                while($row = $result->fetch_assoc()) {
                    $cabin= new CabinObj();
                    $cabin->idcabin=$row['idcabin'];
                    $cabin->cabin=$row['cabin'];
                    $cabin->active=$row['active'];
                    $cabin->capofcabin=$row['capofcabin'];
                    $cabin->telephone=$row['telephone'];
                    $ListCabinObj->addItem($cabin);
                }
            }
            $this->mysqlconector->CloseDataBase();
        }
    }
    
    public function GetCabinByID($CabinObj){
        if(!empty($CabinObj)){
            $this->mysqlconector->OpenConnection();
            $idcabin= mysqli_real_escape_string($this->mysqlconector->conn,$CabinObj->idcabin);
            
            $sqlobj= new SqlQueryBuilder("select");
            $sqlobj->setTable("t_cabins");
            $sqlobj->addColumn("cabin");
            $sqlobj->addColumn("active");
            $sqlobj->addColumn("capofcabin");
            $sqlobj->addColumn("telephone");
            $sqlobj->addColumn("idcabin");
            $sqlobj->setWhere("idcabin=$idcabin");

            if($this->debug){
                echo '<br/>'. $sqlobj->buildQuery();
            }
            
            $result=  $this->mysqlconector->conn->query($sqlobj->buildQuery()) or trigger_error("Error ADOUsers::AddNewUser:mysqli=".mysqli_error($this->mysqlconector->conn),E_USER_ERROR);
            if($result->num_rows>0){
                while($row = $result->fetch_assoc()) {
                    $CabinObj->idcabin=$row['idcabin'];
                    $CabinObj->cabin=$row['cabin'];
                    $CabinObj->active=$row['active'];
                    $CabinObj->capofcabin=$row['capofcabin'];
                    $CabinObj->telephone=$row['telephone'];
                }
            }
            $this->mysqlconector->CloseDataBase();
        }
    }
    
    public function GetCabinsByQuery($ListCabinObj,$SqlQueryBuilder){
        if(!empty($ListCabinObj) && !empty($SqlQueryBuilder)){
            $this->mysqlconector->OpenConnection();
            
            $SqlQueryBuilder->setTable("t_cabins");
            $SqlQueryBuilder->addColumn("cabin");
            $SqlQueryBuilder->addColumn("active");
            $SqlQueryBuilder->addColumn("capofcabin");
            $SqlQueryBuilder->addColumn("telephone");
            $SqlQueryBuilder->addColumn("idcabin");
            
            if($this->debug){
                echo '<br/>'. $SqlQueryBuilder->buildQuery();
            }
            
            $result=  $this->mysqlconector->conn->query($SqlQueryBuilder->buildQuery()) or trigger_error("Error ADOUsers::AddNewUser:mysqli=".mysqli_error($this->mysqlconector->conn),E_USER_ERROR);
            if($result->num_rows>0){
                while($row = $result->fetch_assoc()) {
                    $CabinObj = new CabinObj();
                    $CabinObj->idcabin=$row['idcabin'];
                    $CabinObj->cabin=$row['cabin'];
                    $CabinObj->active=$row['active'];
                    $CabinObj->capofcabin=$row['capofcabin'];
                    $CabinObj->telephone=$row['telephone'];
                    $ListCabinObj->addItem($CabinObj);
                }
            }
            $this->mysqlconector->CloseDataBase();
        }
    }
}
