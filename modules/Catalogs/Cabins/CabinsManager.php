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
 $ListCabins = new ArrayList();
 $_ADOCabins = new ADOCabins();
 $_ADOCabins->GetAllCabins($ListCabins);
 
 
?>
<?php include '../../../view/headinclude.php' ?>
<?php include '../../../view/menu.php' ?>
<h1>System Catalog - Cabins</h1>
<div>
    <table>
        <tr>
            <td>
                <button id="showAddnew">Add new Cabin</button>
            </td>
        </tr>
    </table>
</div>
<div id="AddNewRecord" class="addnew">
    <div id="CloseDiv" style="text-align: right;  width: 100%;margin-bottom: 15px; ">
        <button id="HideDiv">X</button>
    </div>
    <h3>Add New Cabin</h3>
    <form name="addnewRecotd" method="post" action="addNewCabin.php">
        <table  style="width: 400px">
        <tr>
            <td>
                Cabin:
            </td>
             <td>
                 <input type="text" name="cabin" id="cabin" value=""/>
                 <input type="hidden" name="active" value="1">
                 <input type="hidden" name="token" value="<?php echo $SessionUser->token;?>" />
            </td>
        </tr>
        <tr>
            <td>
                Capacity of cabin:
            </td>
             <td>
                 <input type="text" name="capofcabin" id="capofcabin" value=""/>
            </td>
        </tr>
        <tr>
            <td>
                Phone Num.:
            </td>
             <td>
                 <input type="text" name="telephone" id="telephone" value=""/>
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
<a id="updaterecord"></a>
<div id="UpdateRecord" class="addnew">
    <div id="CloseDivUpdate" style="text-align: right;  width: 100%;margin-bottom: 15px; ">
        <button id="HideDivUpdate">X</button>
    </div>
    <h3>Update Cabin</h3>
    <form id="updateRecordfrm" name="updateRecordfrm" method="post" action="updateCabin.php">
        <table  style="width: 400px">
        <tr>
            <td>
                Cabin:
            </td>
             <td>
                 <input type="text" name="cabin" id="cabin" value=""/>
                 <input type="hidden" name="active" value="1">
                 <input type="hidden" name="idcabin" value="">
                 <input type="hidden" name="token" value="<?php echo $SessionUser->token;?>" />
            </td>
        </tr>
        <tr>
            <td>
                Capacity of cabin:
            </td>
             <td>
                 <input type="text" name="capofcabin" id="capofcabin" value=""/>
            </td>
        </tr>
        <tr>
            <td>
                Phone Num.:
            </td>
             <td>
                 <input type="text" name="telephone" id="telephone" value=""/>
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
            <th>Cabin</th>
            <th>Status</th>
            <th>Cap. of Cabin</th>
            <th>Phone num.</th>
            <th>Options</th>
        </tr>
        <?php
            foreach($ListCabins->array as $item){
                $btnActiveDeactive="";
                if($item->active==0){
                    $status="Inactive";
                    $btnActiveDeactive="<button id=\"btn_activate_$item->idcabin\">Activate</button>";
                }else{
                    $status="Active";
                    $btnActiveDeactive="<button id=\"btn_deactivate_$item->idcabin\">Deactivate</button>";
                }
        ?>
        <tr>
            <td><?php echo $item->cabin;?></td>
            <td><?php echo $status;?></td>
            <td><?php echo $item->capofcabin?></td>
            <td><?php echo $item->telephone?></td>
            <td>
                <button id="btn_edit_<?php echo $item->idcabin?>">Edit</button>
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
    })
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
            document.location.href="activeCabin.php?param="+idcomp+"&token="+token;
        }
        if(action=="deactivate"){
          document.location.href="deactiveCabin.php?param="+idcomp+"&token="+token;
        }
        
        return false;
    });
    
    
    function setInfo(param,type){
        $.ajax({
            url:'CabinInfo.php?param='+param+'&token=<?php echo $SessionUser->token;?>&type='+type+'',
            type:'get',
            dataType: "json",
            success:function(result){
                var obj1=result;
                $('#updateRecordfrm input[name=idcabin]').val(obj1.idcabin)
                $('#updateRecordfrm input[name=cabin]').val(obj1.cabin);
                $('#updateRecordfrm input[name=active]').val(obj1.active);
                $('#updateRecordfrm input[name=capofcabin]').val(obj1.capofcabin);
                $('#updateRecordfrm input[name=telephone]').val(obj1.telephone);
            }
            
        });
    }
    
    
</script>
<?php include '../../../view/footerinclude.php'?>