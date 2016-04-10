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
    if($_FILES['photomember']['error']>0){
        echo "Error al subir el archivo codigo: ".$_FILES['photomember']['error']."<br />";
    }else{
        $kb=(int)$_FILES['photomember']['size'];
        $l_kb= round($kb/1024);
        if($debug){
            echo "Name: " . $_FILES['photomember']['name']."<br/>";
            echo "Ext: " . $_FILES['photomember']['type']."<br/>";
            echo "Size: ".$_FILES['photomember']['size']."($l_kb KB) <br/>";
            echo "Ruta TMP: ".$_FILES['photomember']['tmp_name']."<br/>";
        }
        $carpeta_dest = "./files/images/";
        $filefullname=$carpeta_dest.$_FILES['photomember']['name'];
        copy($_FILES['photomember']['tmp_name'], $filefullname);
        if(isset($_SESSION['tmpphoto'])){
            unset($_SESSION['tmpphoto']);
        }
        $_SESSION['tmpphoto']="/modules/InvoiceManager/invoices/".$_FILES['photomember']['name'];
        $pathdatabase= "/modules/PersonelManager/files/images/".$_FILES['photomember']['name'];
        $pathimgshot=$config->domain."/".$config->pathServer."/modules/PersonelManager/files/images/".$_FILES['photomember']['name'];
        echo $pathdatabase.'||'.$pathimgshot;
    }
}
