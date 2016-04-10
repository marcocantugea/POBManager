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
 
?>
<?php include '../../view/headinclude.php'?>
<?php include '../../view/menu.php'?>
<h2>New Member</h2>
<!--HML Content-->
<div style="width: 100%">
    <form id='frmNewCrewMember' method="post" action="addNewMember.php">
    <table id="personelTable" class="tablePersonel">
        <tr>
            <td rowspan="4" style="width:200px">
                <img id="imgMember" src="./files/images/member_icon.jpg" style="width:200px;height: 200px;" />
                <button id="btnSetPhoto" style="width:100%">Change Photo</button>
                <input name="photopath" id="photopath" type="hidden" value="/modules/PersonelManager/files/images/member_icon.jpg">
            </td>
            <th>Name(s)</th>
            <td>
                <input name="names" id="names" value="" style="width:90%" type="text" />
                <span id="error_names"></span>
            </td>
            <th>Last Name</th>
            <td>
                <input name="lastname" id="lasname" value="" style="width:90%" type="text" />
                <span id="error_lastname"></span>
                <input  type="hidden" name="token" id="token" value="<?php echo $SessionUser->token;?>" />
            </td>
        </tr>
        <tr>
            
            <th>Birthday</th>
            <td>
                Day <select name="days" id="days"></select>
                Month <select name="months" id="months"></select>
                Year <select name="years" id="years"></select>
                <input name="birthday" id="birthday" value="" type="hidden"/>
            </td>
            <th>Age</th>
            <td><span id="agefield"></span></td>
        </tr>
        <tr>
            
            <th>Gender</th>
            <td>
                <input type="radio" name="gender" value="male" checked="true"> Male<br>
                <input type="radio" name="gender" value="female"> Female<br>
            </td>
            <th>Cateogry</th>
            <td>
                <input name="category" id="category" value="" style="width:90%" type="text"/>
                <span id="error_category"></span>
            </td>
        </tr>
        <tr>
            
            <th>Nationalty</th>
            <td>
                <input name="nationality" id="nationality" value="" style="width:90%" type="text"/>
                <span id="error_nationality"></span>
            </td>
            <th>Crew Group</th>
            <td>
                <input name="crewgroup" id="crewgroup" value="" style="width:90%" type="text" />
                <span id="error_crewgroup"></span>
            </td>
        </tr>
    </table>
    </form>
    <!--
    <table style="width:100%" border='1'>
        <tr>
            <td style="width:50%">
                <table class="tablePersonel">
                    <tr>
                        <th>Add New Default Option</th>
                    </tr>
                    <tr>
                        <td style="padding-top: 5px;">
                            Option: 
                            <select>
                                <option>Company</option>
                                <option>Shift</option>
                                <option>Cabin</option>
                                 <option>Boat</option>
                            </select>
                            :
                            <select>
                                <option></option>
                            </select>
                            <button style="height: 25px;">Add</button>
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table class="tablePersonel">
                     <tr>
                        <th>Add New Document</th>
                    </tr>
                    <td style="text-align:center; padding-top: 5px;">
                        <button style="height: 25px;width: 40%">Add Document</button>
                    </td>
                </table>
            </td>
        </tr>
        <tr>
            <td style="width:50%">
                <table class="tablePersonel">
                    <tr>
                        <th colspan="2">Default options</th>
                    </tr>
                    <tr>
                        <td>Default Cabin:</td>
                        <td>A407</td>
                    </tr>
                    <tr>
                        <td>Default Boat:</td>
                        <td>2 FWD</td>
                    </tr>
                    <tr>
                        <td>Default Boat:</td>
                        <td>4 STBD</td>
                    </tr>
                    <tr>
                        <td>Default Company:</td>
                        <td>Grupo R</td>
                    </tr>
                    <tr>
                        <td>Default Shift:</td>
                        <td>06 to 18</td>
                    </tr>
                </table>
            </td>
            <td style="vertical-align: top">
                <table class="tablePersonel">
                    <tr>
                        <th>Document</th>
                        <th>Expires</th>
                        <th>Options</th>
                    </tr>
                    <tr>
                        <td>Pasaport</th>
                        <td>02/20/2018</th>
                        <td>
                            <button>Open</button>
                            <button>Edit</button>
                            <button>Delete</button>
                        </th>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
-->
</div>
<div style="width: 100%;">
    <table class="tablePersonel">
        <tr>
            <th >
                <button id="SaveMemberInfo" style="width: 40%; margin: 15px;">Save Info</button>
            </th>
        </tr>
    </table>
</div>
<div id="UploadDiv" title="Upload Photo" style="font-size: medium">
    <form id="uploadphoto">
        <h4>Select a photo</h4>
        <input type="file" name="photomember" value="" accept=".jpg" id="photomember">
        <p></p>
        <span id="UploadMessage"></span>
    </form>
</div>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="../../js/jquery-1.12.1.min.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script type="text/javascript">
    $(function(){
        dialog=$('#UploadDiv').dialog({
            autoOpen: false,
            height: 320,
            width: 400,
            modal: true,
            buttons:{"Upload File":function(){
                    $.ajax({
                        url: "uploadphoto.php",
                        type: "POST",
                        data:  new FormData($('#uploadphoto')[0]),
                        contentType: false,
                        cache: false,
                        processData:false,
                        success: function(data){
                            $("#UploadMessage").html(data);
                            var result=data;
                            var v=result.split("||");
                            var pathdatabase=v[0];
                            var pathimg=v[1];
                            //var imgurl=route+data;
                            $("#imgMember").attr("src",pathimg);
                            $('#photopath').val(pathdatabase);
                            dialog.dialog( "close" );
                        }           
                    });
                //$("#UploadMessage").html("file uploaded");
                    
            },Cancel:function(){dialog.dialog( "close" );}}
        });
    });
    $('document').ready(function(){
        loadDays();
        loadMonths();
        loadYears();
        
       
    });
    
    
    $('#btnSetPhoto').click(function(){
        //$('#uploadphoto').submit();
        $('#UploadDiv').dialog("open");
        return false;
    });
    
    
    
    $('#SaveMemberInfo').click(function(){
        $('#frmNewCrewMember span[id^=error]').html("");
        $('#frmNewCrewMember span[id^=error]').css("color","red");
        
        var dayselected= $('#days').val();
        var monthselected=$('#months').val();
        var yearselected=$('#years').val();
        
        var birthday=yearselected+"-"+monthselected+"-"+dayselected;
        $('#birthday').val(birthday);
        
        var submitform=true;
        var fields=$('#frmNewCrewMember input[type="text"]').each(function(){
            $(this).css("background-color","white");
            if($(this).val()==""){
                submitform=false;
                $('#error_'+$(this).attr("name")).html("Invalid "+$(this).attr("name")+"<br/>");
                $(this).css("background-color","lightpink");
            }
        });
       if(submitform){
           $('#frmNewCrewMember').submit();
       } 
       
    });
    
    $('#frmNewCrewMember select').change(function(){
        getAge();
    });
    
    function loadDays(){
        var output="";
        for(i=1;i<=31;i++){
            output='<option value="'+i+'">'+i+'</option>';
            $('#days').append(output);
        }
    }
    
    function loadMonths(){
        var output="";
        for(i=1;i<=12;i++){
            output='<option value="'+i+'">'+i+'</option>';
            $('#months').append(output);
        }
    }
    
    function loadYears(){
        var output="";
        var actualyear=new Date().getFullYear();
        for(i=actualyear;i>=1930;i--){
            output='<option value="'+i+'">'+i+'</option>';
            $('#years').append(output);
        }
    }
    
    function calcAge(dateString) {
        var birthday = +new Date(dateString);
        return ~~((Date.now() - birthday) / (31557600000));
    }
    
    function getAge(){
        var dayselected= $('#days').val();
        var monthselected=$('#months').val();
        var yearselected=$('#years').val();
        var v=monthselected+"/"+dayselected+"/"+yearselected;
        var datetocalc= Date.parse(v);
        var age=calcAge(datetocalc);
        $('#agefield').html(age);
    }
    
</script>
<?php include '../../view/footerinclude.php'?>
