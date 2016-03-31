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
 * Description of MysqlConnector
 *
 * @author MarcoCantu
 */
class MSAccessConnector {
    private $servername;
    private $username;
    private $password;
    private $database;
    public $conn;
    private $pathServer;
    
    
    public function __construct() {
        $settings=new Config();
        $this->username=$settings->username;
        $this->password=$settings->password;
        $this->database=$settings->database;
        $this->servername=$settings->servername;
        $this->pathServer=$settings->pathServer;
    }
    
    public function OpenConnection(){
        $dbName = $_SERVER["DOCUMENT_ROOT"] ."/".$this->pathServer. "/database/pobdatabase.mdb";
        if (!file_exists($dbName)) {
           die("Could not find database file.");
        }
        $this->conn = new PDO("odbc:Driver={Microsoft Access Driver (*.mdb)}; DBQ=$dbName; Uid=; Pwd=;");
    }
    
    public function CloseDataBase(){
        try{
            $this->conn->close();
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
}
