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

 //Load Cabins
 $ListBoats = new ArrayList();
 $_ADOBoats = new ADOBoats();
 $_ADOBoats->GetAllBoats($ListBoats);
 
 
?>
<?php include '../../../view/headinclude.php' ?>
<?php include '../../../view/menu.php' ?>

<h1>System Catalog - Boats</h1>
<div>
    <table>
        <tr>
            <td>
                <button id="showAddnew">Add New Boat</button>
            </td>
        </tr>
    </table>
</div>
<div id="AddNewRecord" class="addnew">
    <div id="CloseDiv" style="text-align: right;  width: 100%;margin-bottom: 15px; ">
        <button id="HideDiv">X</button>
    </div>
    <h3>Add New Boat</h3>
    <form name="addnewRecotd" method="post" action="addNewBoat.php">
        <table  style="width: 400px">
        <tr>
            <td>
                Boat Number:
            </td>
             <td>
                 <input type="text" name="boatnumber" id="boatnumber" value=""/>
                 <input type="hidden" name="active" value="1">
                 <input type="hidden" name="token" value="<?php echo $SessionUser->token;?>" />
            </td>
        </tr>
        <tr>
            <td>
                Boat Location:
            </td>
             <td>
                 <input type="text" name="boatlocation" id="boatlocation" value=""/>
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
<div id="UpdateRecord" class="addnew">
     <div id="CloseDivUpdate" style="text-align: right;  width: 100%;margin-bottom: 15px; ">
        <button id="HideDivUpdate">X</button>
    </div>
    <h3>Update Cabin</h3>
    <form id="updateRecordfrm" name="updateRecordfrm" method="post" action="updateBoat.php">
    <table  style="width: 400px">
        <tr>
            <td>
                Boat Number:
            </td>
             <td>
                 <input type="text" name="boatnumber" id="boatnumber" value=""/>
                 <input type="hidden" name="active" value="1">
                 <input type="hidden" name="idboat" value="1">
                 <input type="hidden" name="token" value="<?php echo $SessionUser->token;?>" />
            </td>
        </tr>
        <tr>
            <td>
                Boat Location:
            </td>
             <td>
                 <input type="text" name="boatlocation" id="boatlocation" value=""/>
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
<div style="width: 90%; margin-left: 10%" >
    <table id="tblRecords" class="tableInfo" style="width: 600px; text-align: center">
        <tr>
            <th>Boat Number</th>
            <th>Boat Location</th>
            <th>Status</th>
            <th>Options</th>
        </tr>
        <?php
            foreach($ListBoats->array as $item){
                $btnActiveDeactive="";
                if($item->active==0){
                    $status="Inactive";
                    $btnActiveDeactive="<button id=\"btn_activate_$item->idboat\">Activate</button>";
                }else{
                    $status="Active";
                    $btnActiveDeactive="<button id=\"btn_deactivate_$item->idboat\">Deactivate</button>";
                }
        ?>
        <tr>
            <td><?php echo $item->boatnumber;?></td>
            <td><?php echo $item->boatlocation?></td>
            <td><?php echo $status;?></td>
            <td>
                <button id="btn_edit_<?php echo $item->idboat?>">Edit</button>
                <?php echo $btnActiveDeactive;?>
            </td>
        </tr>
            <?php } ?>
    </table>
</div>
<script src="../../../js/jquery-1.12.1.min.js"></script>
<script type="text/javascript" >
    $().ready(function(){
        $('#AddNewRecord').hide();
        $('#UpdateRecord').hide();
    });
    $('#showAddnew').click(function(){
        $('#AddNewRecord').show(500);
    });
    $('#HideDiv').click(function(){
        $('#AddNewRecord').hide(500);
    });
     $('#HideDivUpdate').click(function(){
        $('#UpdateRecord').hide(500);
    });
    
    $('#tblRecords td button').click(function(){
        var id=$(this).attr('id');
        var strsplited= id.split("_");
        var idcomp= strsplited[2];
        var action=strsplited[1];
        var token='<?php echo $SessionUser->token?>';
        //alert(idcomp);
        if(action=="edit"){
            $('#UpdateRecord').show(500);
            //document.location.href='CabinInfo.php?param='+idcomp+'&token=<?php echo $SessionUser->token;?>&type=json'
            setInfo(idcomp,"json");
            $.scrollTop();
        }
        if(action=="activate"){
            document.location.href="activeBoat.php?param="+idcomp+"&token="+token;
        }
        if(action=="deactivate"){
          document.location.href="deactiveBoat.php?param="+idcomp+"&token="+token;
        }
        
        return false;
    });
    
    function setInfo(param,type){
        $.ajax({
            url:'BoatInfo.php?param='+param+'&token=<?php echo $SessionUser->token;?>&type='+type+'',
            type:'get',
            dataType: "json",
            success:function(result){
                var obj1=result;
                $('#updateRecordfrm input[name=idboat]').val(obj1.idboat)
                $('#updateRecordfrm input[name=boatnumber]').val(obj1.boatnumber);
                $('#updateRecordfrm input[name=active]').val(obj1.active);
                $('#updateRecordfrm input[name=boatlocation]').val(obj1.boatlocation);
            }
            
        });
    }
</script>

<?php include '../../../view/footerinclude.php'?>