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
 * Description of ADOCompanies
 *
 * @author MarcoCantu
 */
class ADOCompanies {
    private $mysqlconector;
    public $debug=false;
    
    public function __construct() {
        $this->mysqlconector= new MysqlConnector();
    }
    
    public function AddNewCompany($CompanyObj){
        if(!empty($CompanyObj)){
            $this->mysqlconector->OpenConnection();
            $companyname= mysqli_real_escape_string($this->mysqlconector->conn,$CompanyObj->companyname);
            $active=  mysqli_real_escape_string($this->mysqlconector->conn,$CompanyObj->active);
            
            $sqlobj= new SqlQueryBuilder("insert");
            $sqlobj->setTable("t_companies");
            $sqlobj->addColumn("companyname");
            $sqlobj->addValue($companyname);
            $sqlobj->addColumn("active");
            $sqlobj->addValue($active);

            if($this->debug){
                echo '<br/>'. $sqlobj->buildQuery();
            }
            
            $result=  $this->mysqlconector->conn->query($sqlobj->buildQuery()) or trigger_error("Error ADOUsers::AddNewUser:mysqli=".mysqli_error($this->mysqlconector->conn),E_USER_ERROR);
            $this->mysqlconector->CloseDataBase();
        }
    }
    
    public function UpdateCompany($CompanyObj){
        if(!empty($CompanyObj)){
            $this->mysqlconector->OpenConnection();
            $idcompany= mysqli_real_escape_string($this->mysqlconector->conn,$CompanyObj->idcompany);
            $companyname= mysqli_real_escape_string($this->mysqlconector->conn,$CompanyObj->companyname);
            $active=  mysqli_real_escape_string($this->mysqlconector->conn,$CompanyObj->active);
            
            $sqlobj= new SqlQueryBuilder("update");
            $sqlobj->setTable("t_companies");
            $sqlobj->addColumn("companyname");
            $sqlobj->addValue($companyname);
            $sqlobj->addColumn("active");
            $sqlobj->addValue($active);
            $sqlobj->setWhere("idcompany=$idcompany");

            if($this->debug){
                echo '<br/>'. $sqlobj->buildQuery();
                
            }
            $result=  $this->mysqlconector->conn->query($sqlobj->buildQuery()) or trigger_error("Error ADOUsers::AddNewUser:mysqli=".mysqli_error($this->mysqlconector->conn),E_USER_ERROR);
            
            
            $this->mysqlconector->CloseDataBase();
        }
    }
    
    public function ActiveCompany($CompanyObj){
        if(!empty($CompanyObj)){
            $this->mysqlconector->OpenConnection();
            $idcompany= mysqli_real_escape_string($this->mysqlconector->conn,$CompanyObj->idcompany);
            $companyname= mysqli_real_escape_string($this->mysqlconector->conn,$CompanyObj->companyname);
            $active=  mysqli_real_escape_string($this->mysqlconector->conn,$CompanyObj->active);
            
            $sqlobj= new SqlQueryBuilder("update");
            $sqlobj->setTable("t_companies");
            $sqlobj->addColumn("active");
            $sqlobj->addValue(1);
            $sqlobj->setWhere("idcompany=$idcompany");

            if($this->debug){
                echo '<br/>'. $sqlobj->buildQuery();
            }
            
            $result=  $this->mysqlconector->conn->query($sqlobj->buildQuery()) or trigger_error("Error ADOUsers::AddNewUser:mysqli=".mysqli_error($this->mysqlconector->conn),E_USER_ERROR);
            $this->mysqlconector->CloseDataBase();
        }
    }
    public function DeactiveCompany($CompanyObj){
        if(!empty($CompanyObj)){
            $this->mysqlconector->OpenConnection();
            $idcompany= mysqli_real_escape_string($this->mysqlconector->conn,$CompanyObj->idcompany);
            $companyname= mysqli_real_escape_string($this->mysqlconector->conn,$CompanyObj->companyname);
            $active=  mysqli_real_escape_string($this->mysqlconector->conn,$CompanyObj->active);
            
            $sqlobj= new SqlQueryBuilder("update");
            $sqlobj->setTable("t_companies");
            $sqlobj->addColumn("active");
            $sqlobj->addValue(0);
            $sqlobj->setWhere("idcompany=$idcompany");

            if($this->debug){
                echo '<br/>'. $sqlobj->buildQuery();
            }
            
            $result=  $this->mysqlconector->conn->query($sqlobj->buildQuery()) or trigger_error("Error ADOUsers::AddNewUser:mysqli=".mysqli_error($this->mysqlconector->conn),E_USER_ERROR);
            $this->mysqlconector->CloseDataBase();
        }
    }
    
    public function GetAllCompanies($ListCompaniesObj){
        if(!empty($ListCompaniesObj)){
            $this->mysqlconector->OpenConnection();
            
            $sqlobj= new SqlQueryBuilder("select");
            $sqlobj->setTable("t_companies");
            $sqlobj->addColumn("idcompany");
            $sqlobj->addColumn("companyname");
            $sqlobj->addColumn("active");

            if($this->debug){
                echo '<br/>'. $sqlobj->buildQuery();
            }
            
            $result=  $this->mysqlconector->conn->query($sqlobj->buildQuery()) or trigger_error("Error ADOUsers::AddNewUser:mysqli=".mysqli_error($this->mysqlconector->conn),E_USER_ERROR);
            if($result->num_rows>0){
                while($row = $result->fetch_assoc()) {
                    $company = new CompanyObj();
                    $company->idcompany=$row['idcompany'];
                    $company->companyname=$row['companyname'];
                    $company->active=$row['active'];
                    $ListCompaniesObj->addItem($company);
                }
            }
            $this->mysqlconector->CloseDataBase();
        }
    }
    
    public function GetCompanyByID($CompanyObj){
        if(!empty($CompanyObj)){
            $this->mysqlconector->OpenConnection();
            $idcompany = mysqli_real_escape_string($this->mysqlconector->conn,$CompanyObj->idcompany);
            
            $sqlobj= new SqlQueryBuilder("select");
            $sqlobj->addColumn("idcompany");
            $sqlobj->setTable("t_companies");
            $sqlobj->addColumn("companyname");
            $sqlobj->addColumn("active");
            $sqlobj->setWhere("idcompany=$idcompany");

            if($this->debug){
                echo '<br/>'. $sqlobj->buildQuery();
            }
            
            $result=  $this->mysqlconector->conn->query($sqlobj->buildQuery()) or trigger_error("Error ADOUsers::AddNewUser:mysqli=".mysqli_error($this->mysqlconector->conn),E_USER_ERROR);
            if($result->num_rows>0){
                while($row = $result->fetch_assoc()) {
                    $CompanyObj->idcompany=$row['idcompany'];
                    $CompanyObj->companyname=$row['companyname'];
                    $CompanyObj->active=$row['active'];
                }
            }
            $this->mysqlconector->CloseDataBase();
        }
    }
    
    public function GetCompaniesByQuery($ListCompaniesObj,$SqlQueryBuilder){
        if(!empty($ListCompaniesObj)){
            $this->mysqlconector->OpenConnection();
            
            $SqlQueryBuilder->setTable("t_companies");
            $SqlQueryBuilder->addColumn("idcompany");
            $SqlQueryBuilder->addColumn("companyname");
            $SqlQueryBuilder->addColumn("active");

            if($this->debug){
                echo '<br/>'. $SqlQueryBuilder->buildQuery();
            }
            
            $result=  $this->mysqlconector->conn->query($SqlQueryBuilder->buildQuery()) or trigger_error("Error ADOUsers::AddNewUser:mysqli=".mysqli_error($this->mysqlconector->conn),E_USER_ERROR);
            if($result->num_rows>0){
                while($row = $result->fetch_assoc()) {
                    $company = new CompanyObj();
                    $company->idcompany=$row['idcompany'];
                    $company->companyname=$row['companyname'];
                    $company->active=$row['active'];
                    $ListCompaniesObj->addItem($company);
                }
            }
            $this->mysqlconector->CloseDataBase();
        }
    }
}
