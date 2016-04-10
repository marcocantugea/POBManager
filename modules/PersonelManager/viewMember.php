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
 
 if(isset($_POST['idpersonel'])){
     $CrewLoaded = new PersonelObj();
     $CrewLoaded->idpersonel=$_POST['idpersonel'];
     $_ADOPersonel = new ADOPersonel();
     $_ADOPersonel->getMemberById($CrewLoaded);
     // set the image of the crew member
     $imgpath= $config->domain."/".$config->pathServer.trim($CrewLoaded->photopath);
     // create the time variable to get the birthday
     $birthay= strtotime($CrewLoaded->birthday);
     //load the defautls of the crew
     $CrewLoaded->GetDefaults();
     //load crew documents
     $CrewLoaded->GetDocuments();
     
 }else{
     echo '<script type="text/javascript">document.location.href="PersonelManager.php"; </script>';
 }
 
?>
<?php include '../../view/headinclude.php'?>
<?php include '../../view/menu.php'?>
<h2 style="margin-left: 10px;">Crew Member - <?php echo $CrewLoaded->names;?> <?php echo $CrewLoaded->lastname;?></h2>
<!--HML Content-->
<div style="width: 100%">
    <form id='frmNewCrewMember' method="post" action="updateMember.php">
        <input type="hidden" name="idpersonel" id="idpersonel" value="<?php echo $CrewLoaded->idpersonel;?>" />
    <table id="personelTable" class="tablePersonel">
        <tr>
            <td rowspan="4" style="width:200px">
                <img id="imgMember" src="<?php echo $imgpath;?>" style="width:200px;height: 200px;" />
                <button id="btnSetPhoto" style="width:100%">Change Photo</button>
                <input name="photopath" id="photopath" type="hidden" value="<?php echo $CrewLoaded->photopath;?>">
            </td>
            <th>Name(s)</th>
            <td>
                <input name="names" id="names" value="<?php echo $CrewLoaded->names;?>" style="width:90%" type="text" />
                <span id="error_names"></span>
            </td>
            <th>Last Name</th>
            <td>
                <input name="lastname" id="lasname" value="<?php echo $CrewLoaded->lastname;?>" style="width:90%" type="text" />
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
                <input type="radio" name="gender" value="male"  <?php if($CrewLoaded->sex=="male"){ echo 'checked="true"';};?> > Male<br>
                <input type="radio" name="gender" value="female" <?php if($CrewLoaded->sex=="female"){ echo 'checked="true"';};?>> Female<br>
            </td>
            <th>Cateogry</th>
            <td>
                <input name="category" id="category" value="<?php echo $CrewLoaded->category;?>" style="width:90%" type="text"/>
                <span id="error_category"></span>
            </td>
        </tr>
        <tr>
            
            <th>Nationalty</th>
            <td>
                <input name="nationality" id="nationality" value="<?php echo $CrewLoaded->nationality;?>" style="width:90%" type="text"/>
                <span id="error_nationality"></span>
            </td>
            <th>Crew Group</th>
            <td>
                <input name="crewgroup" id="crewgroup" value="<?php echo $CrewLoaded->crewgroup;?>" style="width:90%" type="text" />
                <span id="error_crewgroup"></span>
            </td>
        </tr>
    </table>
    </form>
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
                            <select id="SelecDefOption">
                                <option value="0" selected="true">Select Option</option>
                                <option value="1" >Company</option>
                                <option value="2" >Shift</option>
                                <option value="3" >Cabin</option>
                                 <option value="4" >Boat</option>
                            </select>
                            :
                            <select id="ValueOptions" name="ValueOptions">
                            </select>
                            <button id="AddNewDefault" style="height: 25px;">Add</button>
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
                        <button style="height: 25px;width: 40%" id="addNewDocument" >Add Document</button>
                    </td>
                </table>
            </td>
        </tr>
        <tr>
            <td style="width:50%">
                <table id="DefaultOptionsTable" class="tablePersonel">
                    <tr>
                        <th colspan="3">Default options</th>
                    </tr>
                    <?php 
                        $_ADOCompanies = new ADOCompanies();
                        $_ADOCabins = new ADOCabins();
                        $_ADOBoats = new ADOBoats();
                        $_ADOShift = new ADOShift();
                        $valuetoprint="";
                        foreach($CrewLoaded->ListDefaults->array as $item){ 
                            $valuetoprint="";
                            switch ($item->variabletype){
                                case 1:
                                    $company= new CompanyObj();
                                    $company->idcompany=$item->valuedef;
                                    $_ADOCompanies->GetCompanyByID($company);
                                    $valuetoprint=$company->companyname;
                                    break;
                                case 2:
                                    $Shift= new ShiftObj();
                                    $Shift->idshift=$item->valuedef;
                                    $_ADOShift->getShiftById($Shift);
                                    $valuetoprint=$Shift->shift;
                                    break;
                                case 3:
                                    $cabin = new CabinObj();
                                    $cabin->idcabin=$item->valuedef;
                                    $_ADOCabins->GetCabinByID($cabin);
                                    $valuetoprint=$cabin->cabin ." Phone: ".$cabin->telephone;
                                    break;
                                case 4:
                                    $boat= new BoatObj();
                                    $boat->idboat=$item->valuedef;
                                    $_ADOBoats->GetBoatById($boat);
                                    $valuetoprint=$boat->boatnumber." ".$boat->boatlocation;

                        }
                    ?>
                    <tr>
                        <td>Default <?php echo $item->variabletitle;?></td>
                        <td><?php echo $valuetoprint?></td>
                        <td><button id="delete_<?php echo $item->idpdefaults;?>">Delete</button></td>
                    </tr>
                    <?php } ?>
                    
                </table>
            </td>
            <td style="vertical-align: top">
                <table class="tablePersonel" id='TableCrewDocuments'>
                    <tr>
                        <th>Document</th>
                        <th>Expires</th>
                        <th>Options</th>
                    </tr>
                    <?php foreach($CrewLoaded->ListCrewDocumentsObj->array as $item){ 
                    
                        $filepath = $config->domain."/".$config->pathServer.$item->docpath;
                        $labelexpdate="";
                        if($item->expiredate!="0000-00-00 00:00:00"){
                            $labelexpdate=$item->expiredate;
                        }
                        
                    ?>
                    <tr>
                        <td><a href="<?php echo $filepath; ?>" target="_blank" ><?php echo $item->docname;?></a></td>
                        <td><?php echo $labelexpdate;?></td>
                        <td>
                            <button id="delete_<?php echo $item->idpdocuments;?>">Delete</button>
                        </td>
                    </tr>
                     <?php } ?>
                </table>
            </td>
        </tr>
    </table>
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

<div id="UploadFileDiv" title="Upload File" style="font-size: medium">
    <form id="uploadFile">
        <h4>Select a Document</h4>
        <input type="file" name="crewfile" value="" accept=".pdf" id="crewfile"/>
        <div style="margin-top:10px;">
            Expedited Date:<input type="text" id="file_issuedatedoc" name="issuedatedoc"  value="" style="width:110px;" />
        </div>
        <div style="margin-top:10px;">
            Expire Date :<input type="text" id="file_expdatedoc" name="issuedatedoc"  value="" style="width:110px;" />
        </div>
        <p></p>
        <span id="UploadFileMessage"></span>
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
        
        dialog=$('#UploadFileDiv').dialog({
            autoOpen: false,
            height: 320,
            width: 400,
            modal: true,
            buttons:{"Upload File":function(){
                
                    $.ajax({
                        url: "uploadcrewfile.php",
                        type: "POST",
                        data:  new FormData($('#uploadFile')[0]),
                        contentType: false,
                        cache: false,
                        processData:false,
                        success: function(data){
                            var idpersonel="<?php echo $CrewLoaded->idpersonel?>";
                            var expeditedate=$('#file_issuedatedoc').val();
                            var expiredate=$('#file_expdatedoc').val();
                            var token='<?php echo $SessionUser->token;?>';
                            $.post(
                                    "addDocument.php",
                                    {token:token,expediteddate:expeditedate,expiredate:expiredate,idpersonel:idpersonel},
                                    function(result){
                                        var data = $.parseJSON(result);
                                        //alert(data.idpdocuments);
                                        var filepath="<?php echo $config->domain."/".$config->pathServer?>"+data.docpath;
                                        var newrow="";
                                        newrow+="<tr>";
                                        newrow+='<td><a href="'+filepath+'" target="_blank">'+data.docname+"</a></td>";
                                        newrow+="<td>"+data.expiredate+"</td>";
                                        newrow+='<td><button id="deletedoc_'+data.idpdocuments+'">Delete</button></td>';
                                        newrow+="</tr>";
                                        $('#TableCrewDocuments').append(newrow);
                                        
                                    }
                                    );
                            /*$("#UploadMessage").html(data);
                            var result=data;
                            var v=result.split("||");
                            var pathdatabase=v[0];
                            var pathimg=v[1];
                            //var imgurl=route+data;
                            $("#imgMember").attr("src",pathimg);
                            $('#photopath').val(pathdatabase);
                            dialog.dialog( "close" );*/
                        }
                    
                    });
                    dialog.dialog( "close" );
                //$("#UploadMessage").html("file uploaded");
                    
            },Cancel:function(){dialog.dialog( "close" );}}
        });
        
        
    });
    
    
    
    $('document').ready(function(){
        loadDays();
        loadMonths();
        loadYears();
        getAge();
        $("input[id^='file']" ).datepicker({dateFormat: "yy-mm-dd"});
       
    });
    
    $('#btnSetPhoto').click(function(){
        //$('#uploadphoto').submit();
        $('#UploadDiv').dialog("open");
        return false;
    });
    
    $('#addNewDocument').click(function(){
        $('#UploadFileDiv').dialog("open");
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
            var selected='';
            var selectedday="<?php echo date('d',$birthay)?>";
            if(i==parseInt(selectedday)){
                selected='selected="true"';
            }
            output='<option value="'+i+'" '+selected+'>'+i+'</option>';
            $('#days').append(output);
        }
    }
    
    function loadMonths(){
        var output="";
        for(i=1;i<=12;i++){
            var selected='';
            var selectedmonth="<?php echo date('m',$birthay)?>";
            if(i==parseInt(selectedmonth)){
                selected='selected="true"';
            }
            output='<option value="'+i+'" '+selected+'>'+i+'</option>';
            $('#months').append(output);
        }
    }
    
    function loadYears(){
        var output="";
        var actualyear=new Date().getFullYear();
        for(i=actualyear;i>=1930;i--){
            var selected='';
            var selectedyear="<?php echo date('Y',$birthay)?>";
            if(i==parseInt(selectedyear)){
                selected='selected="true"';
            }
            output='<option value="'+i+'" '+selected+'>'+i+'</option>';
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
    
    $('#SelecDefOption').change(function(){
        $('#ValueOptions').empty();
        var option= $(this).val();
        if(option=="0"){
            $('#ValueOptions').empty();
        }
        if(option=="1"){
             FillCompanyOption();
        }
        if(option=="2"){
            FillShiftOption();
        }
        if(option=="3"){
            FillCabinOption();
        }
        if(option=="4"){
            FillBoatOption();
        }
       
    });
    
    function FillCompanyOption(){
        //get the info from the service.
        //document.location.href='../Catalogs/Companies/CompanyInfoService.php?token=<?php echo $SessionUser->token;?>&type=json';
        $.ajax({
            url:'../Catalogs/Companies/CompanyInfoService.php?token=<?php echo $SessionUser->token;?>&type=json',
            type:'get',
            dataType: "json",
            success:function(result){
                //alert(result[0].companyname);
                $.each(result,function(index,element){
                   $('#ValueOptions').append('<option value="'+ element.idcompany +'">'+element.companyname+'</option>')
                });
            }
            
        });
    }
    
    function FillShiftOption(){
        //get the info from the service.
        //document.location.href='../Catalogs/Companies/CompanyInfoService.php?token=<?php echo $SessionUser->token;?>&type=json';
        $.ajax({
            url:'../Catalogs/Shifts/ShiftInfoService.php?token=<?php echo $SessionUser->token;?>&type=json',
            type:'get',
            dataType: "json",
            success:function(result){
                //alert(result[0].companyname);
                $.each(result,function(index,element){
                   $('#ValueOptions').append('<option value="'+ element.idshift +'">'+element.shift+'</option>')
                });
            }
            
        });
    }
    
    function FillCabinOption(){
        //get the info from the service.
        //document.location.href='../Catalogs/Companies/CompanyInfoService.php?token=<?php echo $SessionUser->token;?>&type=json';
        $.ajax({
            url:'../Catalogs/Cabins/CabinInfoService.php?token=<?php echo $SessionUser->token;?>&type=json',
            type:'get',
            dataType: "json",
            success:function(result){
                //alert(result[0].companyname);
                $.each(result,function(index,element){
                   $('#ValueOptions').append('<option value="'+ element.idcabin +'">'+element.cabin+'</option>')
                });
            }
            
        });
    }
    function FillBoatOption(){
        //get the info from the service.
        //document.location.href='../Catalogs/Companies/CompanyInfoService.php?token=<?php echo $SessionUser->token;?>&type=json';
        $.ajax({
            url:'../Catalogs/Boats/BoatInfoService.php?token=<?php echo $SessionUser->token;?>&type=json',
            type:'get',
            dataType: "json",
            success:function(result){
                //alert(result[0].companyname);
                $.each(result,function(index,element){
                   $('#ValueOptions').append('<option value="'+ element.idboat +'">'+element.boatnumber+' '+element.boatlocation+'</option>')
                });
            }
            
        });
    }
    
    $('#AddNewDefault').click(function(){
        var token="<?php echo $SessionUser->token;?>";
        var type=$('#SelecDefOption').val();
        var vardef="";
        switch(type){
            case "1":
                vardef='idcompany'; break;
            case "2":
                vardef='idshift'; break;
            case "3":
                vardef='idcabin'; break;
            case "4":
                vardef='idboat'; break;
        }
        var valuedef=$('#ValueOptions').val();
        var idpersonel="<?php echo $CrewLoaded->idpersonel?>";
        var variabletitle=$('#SelecDefOption option:selected').text();
        var valuedeftitle=$('#ValueOptions option:selected').text();
        
        $.post(
                "addDefault.php",
                {token:token,type:type,vardef:vardef,valuedef:valuedef,idpersonel:idpersonel,variabletitle:variabletitle},
                function(result){
                    var r=result;
                    var svalue=r.split("|");
                    var status = svalue[0];
                    var iddefault= svalue[1];
                    //alert(status);
                    //alert(iddefault);
                    if(status===" Record Added"){
                        var newrow="";
                        newrow+="<tr>";
                        newrow+="<td>Default "+ variabletitle +"</td>";
                        newrow+="<td>"+ valuedeftitle +"</td>";
                        newrow+="<td><button id='delete_"+iddefault+"'>Delete</button></td>";
                        newrow+="</td>";
                        newrow+="</tr>";
        
                        $('#DefaultOptionsTable').append(newrow);
                    }
                }
                );
    });
    
    $(document).on('click', '#DefaultOptionsTable button[id^=delete]', function(){ 
        var svalue=$(this).attr("id").split("_");
        var idpderfault=svalue[1];
        var token="<?php echo $SessionUser->token;?>";
        var butonname=$(this).attr("id");
        var deletebutton= true;
        $.post(
                "deleteDefault.php",
                {idpdefaults:idpderfault,token:token},
                function(result){
                    //console.log(result);
                    var r=result;
                    var svalue=r.split("|");
                    var status=svalue[0];
                    //console.log(status);
                    if(status!=" deleted"){
                       deletebutton=false;
                    }
                }
        );

        if(deletebutton){
            $(this).parent().parent().remove();
        }
        //console.log($(this).parent().parent());
    });
    
    $(document).on('click','#TableCrewDocuments button[id^=delete]',function(){
        var s=$(this).attr("id");
        var svalue=s.split("_");
        var idpdocument=svalue[1];
        var token="<?php echo $SessionUser->token;?>";
        var deleterow=true;
        
        $.post(
                "deleteCrewDocument.php",
                {token:token,idpdocument:idpdocument},
                function(){
                    var r=result;
                    var svalue=r.split("|");
                    var status=svalue[0];
                    //console.log(status);
                    if(status!=" deleted"){
                       deleterow=false;
                    }
                }
            );
        
        if(deleterow){
            $(this).parent().parent().remove();
        }
    });
    
    
</script>
<?php include '../../view/footerinclude.php'?>
