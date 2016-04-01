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
$redirectpage="CompaniesManager.php";
$SessionUser= new UserObj();
$SessionUser= unserialize($_SESSION['UserObj']);
$SessionUser->GenerateToken();

if(!empty($_POST)){
    if(isset($_POST['token'])){
        $token=$_POST['token'];
        if($token==$SessionUser->token){
            $updatecomp= new CompanyObj();
            $updatecomp->idcompany=$_POST['idcompany'];
            $updatecomp->companyname=$_POST['companyname'];
            $updatecomp->active=$_POST['active'];
             if($updatecomp->idcompany>0){
                 $_ADOCompanies = new ADOCompanies();
                 $_ADOCompanies->debug=$debug;
                 $_ADOCompanies->UpdateCompany($updatecomp);
             }
        }
    }
}

if(!$debug){
     echo '<script type="text/javascript">document.location.href="'. $redirectpage.'"; </script>';
}