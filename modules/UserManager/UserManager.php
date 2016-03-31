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
 
 //Load Users
 $ListUsers = new ArrayList();
 $_ADOUser = new ADOUsers();
 $_ADOUser->getUsuarios($ListUsers);
 
 //load session user
 $SessionUser= new UserObj();
 $SessionUser = unserialize($_SESSION['UserObj']);
 $SessionUser->GenerateToken();
?>
<?php include '../../view/headinclude.php'?>
<?php include '../../view/menu.php'?>
<h1>System Users Manager</h1>
<div>
    <table>
        <tr>
            <td>
                <button id="showAddnewUser">Add new user</button>
            </td>
        </tr>
    </table>
</div>
<div id="Addnewuser" class="addnew">
    <div id="CloseAdduser" style="text-align: right;  width: 100%;margin-bottom: 15px; ">
        <button id="HideAddnewUser">X</button>
    </div>
    <h3>Add New User</h3>
    <form name="addnewuser" method="post" action="addNewUser.php">
        <table  style="width: 300px">
        <tr>
            <td>
                User:
            </td>
             <td>
                 <input type="text" name="user" id="user" value=""/>
            </td>
        </tr>
        <tr>
            <td>
                Password:
            </td>
             <td>
                 <input type="password" name="pass" id="pass" value=""/>
            </td>
        </tr>
         <tr>
            <td>
                E-mail:
            </td>
             <td>
                 <input type="text" name="email" id="email" value=""/>
                 <input type="hidden" name="active" value="1">
                 <input type="hidden" name="token" value="<?php echo $SessionUser->token;?>" />
            </td>
        </tr>
        <tr>
            <td>
               
            </td>
             <td>
                 <button name="btnAddNew" id="btnAddNew" >Save User</button>
                 
            </td>
        </tr>
    </table>
       
    </form>
    
</div>
<div id="UpdateUserInfo" class="addnew" style="background-color: lightgoldenrodyellow" >
    <div id="CloseAdduser" style="text-align: right;  width: 100%;margin-bottom: 15px; ">
        <button id="CloseUpdateUser">X</button>
    </div>
    <h3>Update User Info.</h3>
    <form name="updatesuserinfo" method="post" action="updateUser.php">
        <table  style="width: 300px">
        <tr>
            <td>
                User:
            </td>
             <td>
                 <input id="update_iduser" type="hidden" name="iduser" value="" />
                 <input id="update_user" type="text" name="user" id="user" value=""/>
            </td>
        </tr>
         <tr>
            <td>
                E-mail:
            </td>
             <td>
                 <input id="update_email" type="text" name="email" id="email" value=""/>
                 <input type="hidden" name="active" value="1" />
                 <input type="hidden" name="token" value="<?php echo $SessionUser->token;?>" />
            </td>
        </tr>
        <tr>
            <td>
               
            </td>
             <td>
                 <button name="btnUpdateUser" id="btnUpdateUser" >Save User</button>
                 
            </td>
        </tr>
        </table>
       
    </form>
    
</div>
<hr />
<h2>Register Users</h2>
<div style="margin-left: 15%;">
    <table class="tableInfo" style="width: 55%" id="TableUsers">
        <tr>
            <th>User</th>
            <th>E-Mail</th>
            <th>Status</th>
            <th colspan="3">Options</th>
        </tr>
        <?php
            if(count($ListUsers->array)>0){
                foreach($ListUsers->array as $item){
                    $estado=0;
                    if($item->active==1){
                        $estado="Activo";
                    }else{
                         $estado="Desactivado";
                    }
                    
                    
                    echo '<tr>';
                    echo '<td><input type="hidden" id="iduser" name="iduser" value="'. $item->iduser .'" >'. $item->user .'</td>';
                    echo '<td><input type="hidden" id="email" name="email" value="'. $item->email .'" >'. $item->email .'</td>';
                    echo '<td style="text-align: center"><input type="hidden" id="active" name="active" value="'. $item->active .'" >'. $estado .'</td>';
                    echo '<td><button id="btn_edit_'. $item->iduser .'" >Update</button></td>';
                    echo '<td><button id="btn_delete_'. $item->iduser .'" >Delete</button></td>';
                    if($item->active==1){
                        echo '<td><button id="btn_deactivate_'. $item->iduser .'" >Deactivate</button></td>';
                    }
                    if($item->active==0){
                         echo '<td><button id="btn_activate_'. $item->iduser .'" >Activate</button></td>';
                    }
                    
                    echo '</tr>';
                }
            }
        ?>
    </table>
</div>
<script src="../../js/jquery-1.12.1.min.js"></script>
<script type="text/javascript">
    $().ready(function(){
        $('#Addnewuser').hide();
        $('#UpdateUserInfo').hide();
    });
    
    $('#showAddnewUser').click(function(){
        $('#Addnewuser').show(500);
    })
    $('#HideAddnewUser').click(function(){
        $('#Addnewuser').hide(500);
    });
    
    $('#CloseUpdateUser').click(function(){
       $('#UpdateUserInfo').hide(500);
    });
    
    $('#TableUsers td button').click(function(){
        var id=$(this).attr('id');
        var strsplited= id.split("_");
        var iduser= strsplited[2];
        var action=strsplited[1];
        if(action=="edit"){
            //TODO: get by json the user info
            //TODO: set the variables on the form;
            setUserInfo(iduser,"json");
            $('#UpdateUserInfo').show(500);
            
        }
        if(action=="delete"){
            document.location.href="deleteUser.php?param="+iduser+"&token=<?php echo $SessionUser->token;?>"
            
        }
        
        if(action=="activate"){
            document.location.href="ChangeActivation.php?param="+iduser+"&token=<?php echo $SessionUser->token;?>&type=activate";
            
        }
        
        if(action=="deactivate"){
            document.location.href="ChangeActivation.php?param="+iduser+"&token=<?php echo $SessionUser->token;?>&type=deactivate";
            
        }
    });
    
    function setUserInfo(param,type){
        $.ajax({
            url:'UserInfo.php?param='+param+'&token=<?php echo $SessionUser->token;?>&type='+type+'',
            type:'get',
            dataType: "json",
            success:function(result){
                var obj1=result;
                $('#update_iduser').val(obj1.iduser)
                $('#update_user').val(obj1.user);
                $('#update_email').val(obj1.email);
            }
            
        });
    }
    
</script>
<?php include '../../view/footerinclude.php'?>
