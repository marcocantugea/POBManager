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
 * Description of ADOCrewDocuments
 *
 * @author MarcoCantu
 */
class ADOCrewDocuments {
    private $mysqlconector;
    public $debug=false;
    
    public function __construct() {
        $this->mysqlconector= new MysqlConnector();
    }
    
    public function AddNewDocument($CrewDocumentObj){
        if(!empty($CrewDocumentObj)){
            $this->mysqlconector->OpenConnection();
            $docname = mysqli_real_escape_string($this->mysqlconector->conn,$CrewDocumentObj->docname);
            $docpath=mysqli_real_escape_string($this->mysqlconector->conn,$CrewDocumentObj->docpath);
            $expediteddate=mysqli_real_escape_string($this->mysqlconector->conn,$CrewDocumentObj->expediteddate);
            $expiredate=mysqli_real_escape_string($this->mysqlconector->conn,$CrewDocumentObj->expiredate);
            $idpdocuments=mysqli_real_escape_string($this->mysqlconector->conn,$CrewDocumentObj->idpdocuments);
            $idpersonel=mysqli_real_escape_string($this->mysqlconector->conn,$CrewDocumentObj->idpersonel);
            
            $sqlobj= new SqlQueryBuilder("insert");
            $sqlobj->setTable("t_personel_documents");
            $sqlobj->addColumn("docname");
            $sqlobj->addValue($docname);
            $sqlobj->addColumn("docpath");
            $sqlobj->addValue($docpath);
            $sqlobj->addColumn("expediteddate");
            $sqlobj->addValue($expediteddate);
            $sqlobj->addColumn("expiredate");
            $sqlobj->addValue($expiredate);
            //$sqlobj->addColumn("idpdocuments");
            //$sqlobj->addValue($idpdocuments);
            $sqlobj->addColumn("idpersonel");
            $sqlobj->addValue($idpersonel);
            
            if($this->debug){
                echo '<br/>'. $sqlobj->buildQuery();
            }
            
            $result=  $this->mysqlconector->conn->query($sqlobj->buildQuery()) or trigger_error("Error ADOUsers::AddNewUser:mysqli=".mysqli_error($this->mysqlconector->conn),E_USER_ERROR);
            $this->mysqlconector->CloseDataBase();
            
            $CrewDocumentObj->idpdocuments=  $this->getlastid();
        }
    }
    
    public function DeleteDocument($CrewDocumentObj){
        if(!empty($CrewDocumentObj)){
            $this->mysqlconector->OpenConnection();
            $idpdocuments=mysqli_real_escape_string($this->mysqlconector->conn,$CrewDocumentObj->idpdocuments);

            $sqlobj= new SqlQueryBuilder("delete");
            $sqlobj->setTable("t_personel_documents");
            $sqlobj->setWhere("idpdocuments=$idpdocuments");
            
            if($this->debug){
                echo '<br/>'. $sqlobj->buildQuery();
            }
            
            $result=  $this->mysqlconector->conn->query($sqlobj->buildQuery()) or trigger_error("Error ADOUsers::AddNewUser:mysqli=".mysqli_error($this->mysqlconector->conn),E_USER_ERROR);
            $this->mysqlconector->CloseDataBase();
        }
    }
    
    public function GetDocumentById($CrewDocumentObj){
        if(!empty($CrewDocumentObj)){
            $this->mysqlconector->OpenConnection();
            $idpdocuments=mysqli_real_escape_string($this->mysqlconector->conn,$CrewDocumentObj->idpdocuments);
            
            $sqlobj= new SqlQueryBuilder("select");
            $sqlobj->setTable("t_personel_documents");
            $sqlobj->addColumn("docname");
            $sqlobj->addColumn("docpath");
            $sqlobj->addColumn("date_format(expediteddate,'%d - %b - %Y') as expediteddate");
            $sqlobj->addColumn("date_format(expiredate,'%d - %b - %Y') as expiredate");
            $sqlobj->addColumn("idpdocuments");
            $sqlobj->addColumn("idpersonel");
             $sqlobj->setWhere("idpdocuments=$idpdocuments");
            
            if($this->debug){
                echo '<br/>'. $sqlobj->buildQuery();
            }
            
            $result=  $this->mysqlconector->conn->query($sqlobj->buildQuery()) or trigger_error("Error ADOUsers::AddNewUser:mysqli=".mysqli_error($this->mysqlconector->conn),E_USER_ERROR);
            if($result->num_rows>0){
                 while($row = $result->fetch_assoc()) {
                     $CrewDocumentObj->idpdocuments=$row['idpdocuments'];
                     $CrewDocumentObj->docname=$row['docname'];
                     $CrewDocumentObj->docpath=$row['docpath'];
                     $CrewDocumentObj->expediteddate=$row['expediteddate'];
                     $CrewDocumentObj->expiredate=$row['expiredate'];
                     $CrewDocumentObj->idpersonel=$row['idpersonel'];
                 }
            }
            $this->mysqlconector->CloseDataBase();
        }
    }
    
    public function GetDocumentsByPersonel($PersonelObj){
        if(!empty($PersonelObj)){
            if($PersonelObj->idpersonel>0){
                $this->mysqlconector->OpenConnection();
                $idpersonel=  mysqli_real_escape_string($this->mysqlconector->conn,$PersonelObj->idpersonel);
                
                $sqlobj= new SqlQueryBuilder("select");
                $sqlobj->setTable("t_personel_documents");
                $sqlobj->addColumn("docname");
                $sqlobj->addColumn("docpath");
                $sqlobj->addColumn("date_format(expediteddate,'%d - %b - %Y') as expediteddate");
                $sqlobj->addColumn("date_format(expiredate,'%d - %b - %Y') as expiredate");
                $sqlobj->addColumn("idpdocuments");
                $sqlobj->addColumn("idpersonel");
                $sqlobj->setWhere("idpersonel=$idpersonel");
                
                if($this->debug){
                    echo '<br/>'. $sqlobj->buildQuery();
                }
            
                $result=  $this->mysqlconector->conn->query($sqlobj->buildQuery()) or trigger_error("Error ADOUsers::AddNewUser:mysqli=".mysqli_error($this->mysqlconector->conn),E_USER_ERROR);
                if($result->num_rows>0){
                    if(!isset($PersonelObj->ListCrewDocumentsObj)){
                        $PersonelObj->ListCrewDocumentsObj =  new ArrayList();
                    }
                    while($row = $result->fetch_assoc()) {
                        $CrewDocumentObj= new CrewDocumentObj();
                        $CrewDocumentObj->idpdocuments=$row['idpdocuments'];
                        $CrewDocumentObj->docname=$row['docname'];
                        $CrewDocumentObj->docpath=$row['docpath'];
                        $CrewDocumentObj->expediteddate=$row['expediteddate'];
                        $CrewDocumentObj->expiredate=$row['expiredate'];
                        $CrewDocumentObj->idpersonel=$row['idpersonel'];
                        $PersonelObj->ListCrewDocumentsObj->addItem($CrewDocumentObj);
                    }
                }
                
                $this->mysqlconector->CloseDataBase();
            }
        }
    }
    
    public function GetDocumentsByQuery($ListCrewDocumentsObj,$SQLQueryBuilder){
        
    }
    
    public function getlastid(){
        $id =0;
        $this->mysqlconector->OpenConnection();
        $sql="select max(idpdocuments) as lastid from t_personel_documents";
        $result=  $this->mysqlconector->conn->query($sql) or trigger_error("Error ADOUsers::AddNewUser:mysqli=".mysqli_error($this->mysqlconector->conn),E_USER_ERROR);
        if($result->num_rows>0){
            while($row = $result->fetch_assoc()) {
                $id=$row['lastid'];
            }
        }
        $this->mysqlconector->CloseDataBase();
        return $id;
        
    }
    
    
}
