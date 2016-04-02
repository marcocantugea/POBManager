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

$SessionUser= new UserObj();
$SessionUser= unserialize($_SESSION['UserObj']);
$SessionUser->GenerateToken();

if(!empty($_GET)){
    if(isset($_GET['token'])){
        $token=$_GET['token'];
        if($token==$SessionUser->token){
            $shift= new ShiftObj();
            $shift->idshift = $_GET['param'];
            $type = $_GET['type'];
            
            if($shift->idshift>0){
                $_ADOShift = new ADOShift();
                $_ADOShift->debug= $debug;
                $_ADOShift->getShiftById($shift);
                switch ($type){
                    case "json": echo json_encode($shift);                break;
                    case "text": echo $shift->idshift." ". $shift->shift." ". $shift->active; break;
                    case "csv": echo $shift->idshift.";". $shift->shift.";". $shift->active; break;
                    case "pipe": $shift->idshift."|". $shift->shift."|". $shift->active; break;
                }
            }
        }
    }
}