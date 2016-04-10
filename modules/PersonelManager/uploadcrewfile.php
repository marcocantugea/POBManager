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

include 'topinclude.php';
$debug=false;

if(isset($_SESSION['UserObj'])){
//verifica si se subio el archivo correctamente
    if($_FILES['crewfile']['error']>0){
        echo "Error al subir el archivo codigo: ".$_FILES['crewfile']['error']."<br />";
    }else{
        $kb=(int)$_FILES['crewfile']['size'];
        $l_kb= round($kb/1024);
        $carpeta_dest = "./files/docs/";
        $filefullname=$carpeta_dest.$_FILES['crewfile']['name'];
        if(isset($_SESSION['tmpcrewfile'])){
            unset($_SESSION['tmpcrewfile']);
            unset($_SESSION['tmpcrewfilename']);
        }
        $_SESSION['tmpcrewfile']="/modules/PersonelManager/files/docs/".$_FILES['crewfile']['name'];
        $_SESSION['tmpcrewfilename']=$_FILES['crewfile']['name'];
        if($debug){
            echo "Name: " . $_FILES['crewfile']['name']."<br/>";
            echo "Ext: " . $_FILES['crewfile']['type']."<br/>";
            echo "Size: ".$_FILES['crewfile']['size']."($l_kb KB) <br/>";
            echo "Ruta TMP: ".$_FILES['crewfile']['tmp_name']."<br/>";
            echo "File path to save: ". $filefullname;
            echo 'session file: '. $_SESSION['tmpcrewfile'];
        }
        
        copy($_FILES['crewfile']['tmp_name'], $filefullname);
        
        $pathdatabase= "/modules/PersonelManager/files/docs/".$_FILES['crewfile']['name'];
        $pathimgshot=$config->domain."/".$config->pathServer."/modules/PersonelManager/files/docs/".$_FILES['crewfile']['name'];
        echo $pathdatabase.'||'.$pathimgshot;
         
    }
}
