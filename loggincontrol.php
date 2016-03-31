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

?>
<!--<form id="loginform" name="loginform" method="post" action="#">-->
<div id="LoginForm" class="addnew" style="width: 350px;">
    <h3>Inicie Session</h3>
    
        <table  style="width: 300px">
             <tr>
                <td>
                    Usuario:
                </td>
                 <td>
                     <input type="text" name="user" id="user" value=""/>
                </td>
            </tr>
            <tr>
                <td>
                    Contraseña:
                </td>
                 <td>
                     <input type="password" name="password" id="password" value=""/>
                </td>
            </tr>
            <tr>
                
                <td  colspan="2" style="text-align: center">
                    <p></p>
                    <button id="btnLoggin" style="width: 176px;">Entrar</button>
                </td>
            </tr>
        </table>   
</div>
<div id="meesageboard" style="color: red;text-align: center">
    <h2 id="messagefail"></h2>
</div>
    
   
<!-- </form>-->
<script src="./js/jquery-1.12.1.min.js"></script>
<script type="text/javascript">
    $().ready();
    $('#btnLoggin').click(function(){
         $('#messagefail').html("");
        var user=$('#user').val();
        var pass=$('#password').val();
       $.post("loggin.php",{user:user,pass:pass},function(data){
           var splitval=data.split("|");
           var attempts=splitval[0];
           var result=splitval[1];
           if(result==="true"){
               document.location.href="index.php";
           }
           if(result==="false"){
              $('#messagefail').html("Usuario y/o contraseña invalida");
           }
       });
       
       return false;
    });

</script>
<!--HTML Code goes here-->