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
$redirectpage="BoatManager.php";

$SessionUser= new UserObj();
$SessionUser= unserialize($_SESSION['UserObj']);
$SessionUser->GenerateToken();

if(!empty($_POST)){
    if(isset($_POST['token'])){
        $token=$_POST['token'];
        if($token==$SessionUser->token){
            $newboat= new BoatObj();
            $newboat->boatnumber=$_POST['boatnumber'];
            $newboat->boatlocation=$_POST['boatlocation'];
            $newboat->active=$_POST['active'];
            
            $_ADOBoats = new ADOBoats();
            $_ADOBoats->debug=$debug;
            $_ADOBoats->AddNewBoat($newboat);

            if($debug){
                echo '<br/>Record Added';
            }
        }
    }
}

if(!$debug){
    echo '<script type="text/javascript" > document.location.href="'.$redirectpage.'"</script>';
}