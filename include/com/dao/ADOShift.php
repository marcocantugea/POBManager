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
 * Description of ADOShift
 *
 * @author MarcoCantu
 */
class ADOShift {
   private $mysqlconector;
    public $debug=false;
    
    public function __construct() {
        $this->mysqlconector= new MysqlConnector();
    }
    
    public function AddNewShift($ShiftObj){
        if(!empty($ShiftObj)){
            $this->mysqlconector->OpenConnection();
            $shift= mysqli_real_escape_string($this->mysqlconector->conn,$ShiftObj->shift);
            $active=  mysqli_real_escape_string($this->mysqlconector->conn,$ShiftObj->active);
            
            $sqlobj= new SqlQueryBuilder("insert");
            $sqlobj->setTable("t_shifts");
            $sqlobj->addColumn("shift");
            $sqlobj->addValue($shift);
            $sqlobj->addColumn("active");
            $sqlobj->addValue($active);

            if($this->debug){
                echo '<br/>'. $sqlobj->buildQuery();
            }
            
            $result=  $this->mysqlconector->conn->query($sqlobj->buildQuery()) or trigger_error("Error ADOUsers::AddNewUser:mysqli=".mysqli_error($this->mysqlconector->conn),E_USER_ERROR);
            $this->mysqlconector->CloseDataBase();
        }
    }
    
    public function UpdateShift($ShiftObj){
        if(!empty($ShiftObj)){
            $this->mysqlconector->OpenConnection();
            $shift= mysqli_real_escape_string($this->mysqlconector->conn,$ShiftObj->shift);
            $active=  mysqli_real_escape_string($this->mysqlconector->conn,$ShiftObj->active);
            $idshift= mysqli_real_escape_string($this->mysqlconector->conn,$ShiftObj->idshift);
            
            $sqlobj= new SqlQueryBuilder("update");
            $sqlobj->setTable("t_shifts");
            $sqlobj->addColumn("shift");
            $sqlobj->addValue($shift);
            $sqlobj->addColumn("active");
            $sqlobj->addValue($active);
            $sqlobj->setWhere("idshift=$idshift");

            if($this->debug){
                echo '<br/>'. $sqlobj->buildQuery();
            }
            
            $result=  $this->mysqlconector->conn->query($sqlobj->buildQuery()) or trigger_error("Error ADOUsers::AddNewUser:mysqli=".mysqli_error($this->mysqlconector->conn),E_USER_ERROR);
            $this->mysqlconector->CloseDataBase();
        }
    }
    
    public function ActiveShift($ShiftObj){
        if(!empty($ShiftObj)){
            $this->mysqlconector->OpenConnection();
            $active=  mysqli_real_escape_string($this->mysqlconector->conn,$ShiftObj->active);
            $idshift= mysqli_real_escape_string($this->mysqlconector->conn,$ShiftObj->idshift);
            
            $sqlobj= new SqlQueryBuilder("update");
            $sqlobj->setTable("t_shifts");
            $sqlobj->addColumn("active");
            $sqlobj->addValue(1);
            $sqlobj->setWhere("idshift=$idshift");

            if($this->debug){
                echo '<br/>'. $sqlobj->buildQuery();
            }
            
            $result=  $this->mysqlconector->conn->query($sqlobj->buildQuery()) or trigger_error("Error ADOUsers::AddNewUser:mysqli=".mysqli_error($this->mysqlconector->conn),E_USER_ERROR);
            $this->mysqlconector->CloseDataBase();
        }
    }
    
    public function DeactiveShift($ShiftObj){
        if(!empty($ShiftObj)){
            $this->mysqlconector->OpenConnection();
            $active=  mysqli_real_escape_string($this->mysqlconector->conn,$ShiftObj->active);
            $idshift= mysqli_real_escape_string($this->mysqlconector->conn,$ShiftObj->idshift);
            
            $sqlobj= new SqlQueryBuilder("update");
            $sqlobj->setTable("t_shifts");
            $sqlobj->addColumn("active");
            $sqlobj->addValue(0);
            $sqlobj->setWhere("idshift=$idshift");

            if($this->debug){
                echo '<br/>'. $sqlobj->buildQuery();
            }
            
            $result=  $this->mysqlconector->conn->query($sqlobj->buildQuery()) or trigger_error("Error ADOUsers::AddNewUser:mysqli=".mysqli_error($this->mysqlconector->conn),E_USER_ERROR);
            $this->mysqlconector->CloseDataBase();
        }
    }
    
    public function getAllShifts($ListShiftObj){
        if(!empty($ListShiftObj)){
            $this->mysqlconector->OpenConnection();
            
            $sqlobj= new SqlQueryBuilder("select");
            $sqlobj->setTable("t_shifts");
            $sqlobj->addColumn("idshift");
            $sqlobj->addColumn("shift");
            $sqlobj->addColumn("active");
            
            if($this->debug){
                echo '<br/>'. $sqlobj->buildQuery();
            }
            
            $result=  $this->mysqlconector->conn->query($sqlobj->buildQuery()) or trigger_error("Error ADOUsers::AddNewUser:mysqli=".mysqli_error($this->mysqlconector->conn),E_USER_ERROR);
            if($result->num_rows>0){
                while($row = $result->fetch_assoc()) {
                    $Shift= new ShiftObj();
                    $Shift->idshift= $row['idshift'];
                    $Shift->shift=$row['shift'];
                    $Shift->active=$row['active'];
                    $ListShiftObj->addItem($Shift);
                }
            }
            $this->mysqlconector->CloseDataBase();
        }
    }
    
    public function getShiftById($ShiftObj){
        if(!empty($ShiftObj)){
            $this->mysqlconector->OpenConnection();
            $idshift= mysqli_real_escape_string($this->mysqlconector->conn,$ShiftObj->idshift);
            
            $sqlobj= new SqlQueryBuilder("select");
            $sqlobj->setTable("t_shifts");
            $sqlobj->addColumn("idshift");
            $sqlobj->addColumn("shift");
            $sqlobj->addColumn("active");
            $sqlobj->setWhere("idshift=$idshift");

            if($this->debug){
                echo '<br/>'. $sqlobj->buildQuery();
            }
            
            $result=  $this->mysqlconector->conn->query($sqlobj->buildQuery()) or trigger_error("Error ADOUsers::AddNewUser:mysqli=".mysqli_error($this->mysqlconector->conn),E_USER_ERROR);
            if($result->num_rows>0){
                while($row = $result->fetch_assoc()) {
                    $ShiftObj->idshift= $row['idshift'];
                    $ShiftObj->shift=$row['shift'];
                    $ShiftObj->active=$row['active'];
                }
            }
            $this->mysqlconector->CloseDataBase();
        }
    }
    
    public function getShiftByQuery($ListShiftObj,$SQLQueryBuilder){
        if(!empty($ListShiftObj) && !empty($SQLQueryBuilder)){
            $this->mysqlconector->OpenConnection();
            
            if($this->debug){
                echo '<br/>'. $SQLQueryBuilder->buildQuery();
            }
            
            $result=  $this->mysqlconector->conn->query($SQLQueryBuilder->buildQuery()) or trigger_error("Error ADOUsers::AddNewUser:mysqli=".mysqli_error($this->mysqlconector->conn),E_USER_ERROR);
            if($result->num_rows>0){
                while($row = $result->fetch_assoc()) {
                    $ShiftObj->idshift= $row['idshift'];
                    $ShiftObj->shift=$row['shift'];
                    $ShiftObj->active=$row['active'];
                }
            }
            $this->mysqlconector->CloseDataBase();
        }
    }
    
}
