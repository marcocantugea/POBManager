<!DOCTYPE html>
<!--
Copyright (C) 2016 MarcoCantu

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
-->
<?php
 include 'topinclude.php';
 
 
 //load session user
 $SessionUser= new UserObj();
 $SessionUser = unserialize($_SESSION['UserObj']);
 $SessionUser->GenerateToken();
 
 $ListofCrew = new ArrayList();
 $_ADOPersonel= new ADOPersonel();
 $_ADOPersonel->getAllMembers($ListofCrew);
 
?>
<?php include '../../view/headinclude.php'?>
<?php include '../../view/menu.php'?>
<!--HML Content-->
<h1>Crew Database</h1>
<div>
    <table>
        <tr>
            <td>
                <button id="addnewMember">Add New Member</button>
            </td>
        </tr>
    </table>
</div>
<div id="divMembers" style="width: 100%">
    <?php
        foreach ($ListofCrew->array as $item){
            $imgpath= $config->domain."/".$config->pathServer.trim($item->photopath);
    ?>
    <div class="GridViewItem">
        <a href="MemberView.php" id="viewMember_<?php echo $item->idpersonel?>"><img src="<?php echo $imgpath;?>" /></a>
        <h5><a href="viewMember.php" id="viewMember_<?php echo $item->idpersonel?>"><?php echo $item->names." ".$item->lastname;?></a></h5>
        <div>Nationality : <?php echo $item->nationality;?></div>
         <div>Catetory : <?php echo $item->category;?></div>
         <div>Crew Group : <?php echo $item->crewgroup;?></div>
         <div>Days onboard : ??</div>
    </div>
    <?php }?>
</div>
<form id="frmviewmember" method="post" action="viewMember.php">
    <input type="hidden" id="idpersonel" name="idpersonel" value="" />
</form>
<script src="../../js/jquery-1.12.1.min.js"></script>
<script type="text/javascript">
    $('#addnewMember').click(function(){
       document.location.href="newMember.php"; 
    });
    
    $('#divMembers a').click(function(){
        var id=$(this).attr("id");
        var val = id.split("_");
        var idpersonel=val[1];
        
        $('#idpersonel').val(idpersonel);
        $('#frmviewmember').submit();
        return false;
    });
    
</script>
<?php include '../../view/footerinclude.php'?>