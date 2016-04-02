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

 //Load Shifts
 $ListShifts = new ArrayList();
 $_ADOShift = new ADOShift();
 $_ADOShift->getAllShifts($ListShifts);
 
 
?>
<?php include '../../../view/headinclude.php' ?>
<?php include '../../../view/menu.php' ?>
<h1>System Catalog - Shifts</h1>
<div>
    <table>
        <tr>
            <td>
                <button id="showAddnew">Add new Shift</button>
            </td>
        </tr>
    </table>
</div>
<div id="AddnewShif" class="addnew">
    <div id="CloseDiv" style="text-align: right;  width: 100%;margin-bottom: 15px; ">
        <button id="HideDiv">X</button>
    </div>
    <h3>Add New Shift</h3>
    <form name="addnewshift" method="post" action="addNewShift.php">
        <table  style="width: 400px">
        <tr>
            <td>
                Shift:
            </td>
             <td>
                 <input type="text" name="shift" id="shift" value=""/>
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

<div id="UpdateShift" class="addnew">
    <div id="CloseDivUpdate" style="text-align: right;  width: 100%;margin-bottom: 15px; ">
        <button id="HideDivUpdate">X</button>
    </div>
    <h3>Update Company info</h3>
    <form name="updateshift" method="post" action="updateShift.php">
        <table id="TableUpdateShift" style="width: 400px">
        <tr>
            <td>
                Company Name:
            </td>
             <td>
                 <input type="hidden" name="idshift" id="idshift" value=""/>
                 <input type="text" name="shift" id="shift" value=""/>
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
    <table id="tblShifts" class="tableInfo" style="width: 450px; text-align: center">
        <tr>
            <th>Shift</th>
            <th>Status</th>
            <th>Options</th>
        </tr>
        <?php
            foreach($ListShifts->array as $item){
                $btnActiveDeactive="";
                if($item->active==0){
                    $status="Inactive";
                    $btnActiveDeactive="<button id=\"btn_activate_$item->idshift\">Activate</button>";
                }else{
                    $status="Active";
                    $btnActiveDeactive="<button id=\"btn_deactivate_$item->idshift\">Deactivate</button>";
                }
        ?>
        <tr>
            <td><?php echo $item->shift;?></td>
            <td><?php echo $status;?></td>
            <td>
                <button id="btn_edit_<?php echo $item->idshift?>">Edit</button>
                <?php echo $btnActiveDeactive;?>
            </td>
        </tr>
            <?php } ?>
    </table>
</div>
<script src="../../../js/jquery-1.12.1.min.js"></script>
<script type="text/javascript" >
    $().ready(function(){
        $('#AddnewShif').hide();
        $('#UpdateShift').hide();
    });
    $('#showAddnew').click(function(){
        $('#AddnewShif').show(500);
    })
    $('#HideDiv').click(function(){
        $('#AddnewShif').hide(500);
    });
    
    $('#HideDivUpdate').click(function(){
        $('#UpdateShift').hide(500);
    });
    
    
    $('#tblShifts td button').click(function(){
        var id=$(this).attr('id');
        var strsplited= id.split("_");
        var idcomp= strsplited[2];
        var action=strsplited[1];
        var token='<?php echo $SessionUser->token?>';
        //alert(idcomp);
        if(action=="edit"){
            $('#UpdateShift').show(500);
            setInfo(idcomp,"json");
        }
        if(action=="activate"){
            document.location.href="activeShift.php?param="+idcomp+"&token="+token;
        }
        if(action=="deactivate"){
          document.location.href="deactivateShift.php?param="+idcomp+"&token="+token;
        }
        
        return false;
    });
    
    function setInfo(param,type){
        $.ajax({
            url:'ShiftInfo.php?param='+param+'&token=<?php echo $SessionUser->token;?>&type='+type+'',
            type:'get',
            dataType: "json",
            success:function(result){
                var obj1=result;
                $('#TableUpdateShift input[name=idshift]').val(obj1.idshift)
                $('#TableUpdateShift input[name=shift]').val(obj1.shift);
                $('#TableUpdateShift input[name=active]').val(obj1.active);
            }
            
        });
    }
</script>
<?php include '../../../view/footerinclude.php'?>