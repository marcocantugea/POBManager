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

<?php include 'topinclude.php';
 $SessionUser= new UserObj();
 $SessionUser = unserialize($_SESSION['UserObj']);
 $SessionUser->GenerateToken();

 
 $ListCompanies = new ArrayList();
 $_ADOCompanies = new ADOCompanies();
 $_ADOCompanies->GetAllCompanies($ListCompanies);
 
?>
<?php include '../../../view/headinclude.php' ?>
<?php include '../../../view/menu.php' ?>
<h1>System Catalog - Companies</h1>
<div>
    <table>
        <tr>
            <td>
                <button id="showAddnew">Add new Company</button>
            </td>
        </tr>
    </table>
</div>
<div id="Addnewcompany" class="addnew">
    <div id="CloseDiv" style="text-align: right;  width: 100%;margin-bottom: 15px; ">
        <button id="HideDiv">X</button>
    </div>
    <h3>Add New Company</h3>
    <form name="addnewcompany" method="post" action="addNewCompany.php">
        <table  style="width: 400px">
        <tr>
            <td>
                Company Name:
            </td>
             <td>
                 <input type="text" name="company" id="company" value=""/>
                 <input type="hidden" name="active" value="1">
                 <input type="hidden" name="token" value="<?php echo $SessionUser->token;?>" />
            </td>
        </tr>
        <tr>
            <td>
               
            </td>
             <td>
                 <button name="btnAddnew" id="btnAddNew" >Save Info</button>
                 
            </td>
        </tr>
    </table>
       
    </form>
    
</div>

<div id="Updatecompany" class="addnew">
    <div id="CloseDivUpdate" style="text-align: right;  width: 100%;margin-bottom: 15px; ">
        <button id="HideDivUpdate">X</button>
    </div>
    <h3>Update Company info</h3>
    <form name="updatecompany" method="post" action="updateCompany.php">
        <table id="UpdateCompany" style="width: 400px">
        <tr>
            <td>
                Company Name:
            </td>
             <td>
                 <input type="hidden" name="idcompany" id="idcompany" value=""/>
                 <input type="text" name="companyname" id="company" value=""/>
                 <input type="hidden" name="active" value="">
                 <input type="hidden" name="token" value="<?php echo $SessionUser->token;?>" />
            </td>
        </tr>
        <tr>
            <td>
               
            </td>
             <td>
                 <button name="btnAddnew" id="btnAddNew" >Save Info</button>
                 
            </td>
        </tr>
    </table>
       
    </form>
    
</div>
<hr />

<div style="width: 80%; margin-left: 20%" >
    <table id="tblCompanies" class="tableInfo" style="width: 450px; text-align: center">
        <tr>
            <th>Company Name</th>
            <th>Status</th>
            <th>Options</th>
        </tr>
        <?php
            foreach($ListCompanies->array as $item){
                $btnActiveDeactive="";
                if($item->active==0){
                    $status="Inactive";
                    $btnActiveDeactive="<button id=\"btn_activate_$item->idcompany\">Activate</button>";
                }else{
                    $status="Active";
                    $btnActiveDeactive="<button id=\"btn_deactivate_$item->idcompany\">Deactivate</button>";
                }
        ?>
        <tr>
            <td><?php echo $item->companyname;?></td>
            <td><?php echo $status;?></td>
            <td>
                <button id="btn_edit_<?php echo $item->idcompany?>">Edit</button>
                <?php echo $btnActiveDeactive;?>
            </td>
        </tr>
            <?php } ?>
    </table>
</div>
<script src="../../../js/jquery-1.12.1.min.js"></script>
<script type="text/javascript" >
    $().ready(function(){
        $('#Addnewcompany').hide();
        $('#Updatecompany').hide();
    });
    $('#showAddnew').click(function(){
        $('#Addnewcompany').show(500);
    })
    $('#HideDiv').click(function(){
        $('#Addnewcompany').hide(500);
    });
    
      $('#HideDivUpdate').click(function(){
        $('#Updatecompany').hide(500);
    });
    
    
    $('#tblCompanies td button').click(function(){
        var id=$(this).attr('id');
        var strsplited= id.split("_");
        var idcomp= strsplited[2];
        var action=strsplited[1];
        var token='<?php echo $SessionUser->token?>';
        //alert(idcomp);
        if(action=="edit"){
            //document.location.href="CompanyInfo.php?token="+token+"&param="+idcomp+"&type=json";
             $('#Updatecompany').show(500);
            setComanyInfo(idcomp,"json");
        }
        if(action=="activate"){
            document.location.href="activateCompany.php?param="+idcomp+"&token="+token;
        }
        if(action=="deactivate"){
           document.location.href="deactivateCompany.php?param="+idcomp+"&token="+token;
        }
        
        return false;
    });
    
    function setComanyInfo(param,type){
        $.ajax({
            url:'CompanyInfo.php?param='+param+'&token=<?php echo $SessionUser->token;?>&type='+type+'',
            type:'get',
            dataType: "json",
            success:function(result){
                var obj1=result;
                $('#UpdateCompany input[name=idcompany]').val(obj1.idcompany)
                $('#UpdateCompany input[name=companyname]').val(obj1.companyname);
                $('#UpdateCompany input[name=active]').val(obj1.active);
            }
            
        });
    }
</script>
<?php include '../../../view/footerinclude.php'?>