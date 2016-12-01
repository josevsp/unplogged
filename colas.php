<?
set_time_limit(0);
include '../lib/conn.php';
include "../lib/php_serial.class.php";
$locationModem="";
$estatusModems= "";
$planOperadora="";
$tiemInac="";
$valor=true;

if(isset($_SESSION['login'])){ 
	$ttotal=0;
	$modemsactivos=0;
	
	if($_POST["locationModem"] != null){
	$locationModem= $_POST["locationModem"];	
		}
		if($_POST["estatusModems"] != null){
	$estatusModems= $_POST["estatusModems"];	
		}
		if($_POST["planOperadora"] != null){
	$planOperadora= $_POST["planOperadora"];	
		}
		if($_POST["tiemInac"] != null){
	$tiemInac= $_POST["tiemInac"];	
		}
    $sql = "select COUNT(*) AS total from Outbound where Dispatched = 0 ";
    $query = mysql_query($sql,$conn);
    $row = mysql_fetch_array($query);
	$ttotal = $row['total'];
	
	$sql = "SELECT count(*) as ModemActivos FROM ModemStatus where Active=1";
	$query = mysql_query($sql,$conn);
    $row = mysql_fetch_array($query);
    $modemsactivos = $row['ModemActivos'];
	
	//Lista de Planes asignados
	 	 $operadorasList = array(); 
       	$sql = "SELECT  b.PlanName as PlanName FROM `ModemStatus` as a,  `PrepaidPlans` as  b  WHERE a.`PrepaidPlanID`= b.`PrepaidPlanID` group by b.PlanName";
		$query = mysql_query($sql,$conn);
        $cont = 0;
        while($row = mysql_fetch_array($query)){
                $operadorasList["$cont"] = $row["PlanName"];
                $cont = $cont + 1;
        }
		
	

if(isset($_POST["Guardar"])){
	$sql = "SELECT ModemID FROM ModemStatus ";
	$query = mysql_query($sql,$conn);
	while($row = mysql_fetch_array($query)){
		$sql = "UPDATE ModemStatus SET MobileNumber = '".$_POST["numero".$row["ModemID"]]."', Money = ".$_POST["saldo".$row["ModemID"]].", Active = ".$_POST["activo".$row["ModemID"]].", Comments = '".$_POST["comentario".$row["ModemID"]]."' WHERE ModemID = ".$row["ModemID"]." ";
		$query2 = mysql_query($sql,$conn);
	}
}

?>
<html>
<head>
<title>Despachadores Desarrollo</title>

<script language="javascript">
	var tabla = 'modens';
	var filtro1 = 'estatusModems';
	var filtro2 = 'planOperadora';
	var filtro3 = 'tiemInac';
	var filtro4 = 'locationModem';
	var columFil1 = 1;
	var columFil2 = 5;
	var columFil3 = 7;
	var columFil4 = 0;
	var columSel = 8;
	var columRadio = 1;
	var columResulModems = 9;
	//var columSalModen = 9;
	var columSalDB=3;
	
	//var check = true;
		function doSearch()
		{
			var tableReg = document.getElementById(tabla);
			var searchText = document.getElementById(filtro1).value.toLowerCase();
			var searchText2 = document.getElementById(filtro2).value.toLowerCase();
			var searchText3 = document.getElementById(filtro3).value.toLowerCase();
			var searchText4 = document.getElementById(filtro4).value.toLowerCase();
			var cellsOfRow="";
			var found=false;
			var compareWith="";
 			var compareWith2="";
 			var compareWith3="";
 			var coincideValor3=true;
			var posLoc;
			var locationM="";
 			
 			
			desmarcarTodos();
			//montoSaldo();
			// Recorremos todas las filas con contenido de la tabla
			for (var i = 1; i < tableReg.rows.length; i++)
			{
				cellsOfRow = tableReg.rows[i].getElementsByTagName('td');
				found = false;
				// Recorremos todas las celdas
				if( !found)
				{
					compareWith = cellsOfRow[columFil1].getElementsByTagName('input');
					
					 var value; 
					 for (var k = 0; k < compareWith.length; k++) {
			 				 if (compareWith[k].type === 'radio' && compareWith[k].checked) {
				 				  // get value, set checked flag or do whatever you need to 
				   				value = compareWith[k].value;
								
				   			 }
						 }
				
					compareWith2 = cellsOfRow[columFil2].innerHTML.toLowerCase();
					compareWith3 = cellsOfRow[columFil3].innerHTML.toLowerCase();	
					compareWith4 = cellsOfRow[columFil4].innerHTML.toLowerCase();
					
					if(compareWith4.indexOf("cl") > -1)
						locationM = "cl";
					else if(compareWith4.indexOf("gc") > -1)
					 	locationM = "gc";
					else if(compareWith4.indexOf("dy") > -1)
					 	locationM = "dy";
					
					switch(searchText3) {
							case "-1" :
								if(parseFloat(compareWith3) == -1)
								coincideValor3=true;
								else
								coincideValor3=false;
								break;
							case "0":
								if(parseFloat(compareWith3) >= 0)
								coincideValor3=true;
								else
								coincideValor3=false;
								break;
							case "":
								coincideValor3=true;
								
								break;	
							default:
							
								break;
																	}								
					if ((value.indexOf(searchText) > -1) && (compareWith2.indexOf(searchText2) > -1) && coincideValor3 && (locationM.indexOf(searchText4) > -1))
					{
						found = true;
					}
					
					
				}
				if(found)
				{
					tableReg.rows[i].style.display = '';
				} else {
					// si no ha encontrado ninguna coincidencia, esconde la
					// fila de la tabla
					tableReg.rows[i].style.display = 'none';
				}
			}
		}
		
		function marcar(cantidad)
		{
			var tableReg = document.getElementById(tabla);
			var estatus= '';
			var compareWith="";
			var compareWith="";
			var check = true;
			var j =0;
			if(cantidad == contarChecked() ){
			check = false;
			}
			desmarcarTodos();
			// Recorremos todas las filas con contenido de la tabla
			for (var i = 1; i < tableReg.rows.length && j < cantidad ; i++)
			{
				cellsOfRow = tableReg.rows[i].getElementsByTagName('td');
				compareWith = cellsOfRow[columSel].getElementsByTagName('input');
				
			
				if(tableReg.rows[i].style.display == estatus ){
					var nombre = cellsOfRow[1].innerHTML.toLowerCase();
						 if(compareWith[0].type == "checkbox")
				 			 compareWith[0].checked=check; 
					j++;
					}
					}
					check = true;
			}
	
	function marcarRadio(cantidad)
		{
			var tableReg = document.getElementById(tabla);
			var estatus= '';
			var compareWith="";
			var compareWith="";
			var check = true;
			var j =0;
			
			// Recorremos todas las filas con contenido de la tabla
			for (var i = 1; i < tableReg.rows.length && j < cantidad ; i++)
			{
				cellsOfRow = tableReg.rows[i].getElementsByTagName('td');
				compareWith = cellsOfRow[columRadio].getElementsByTagName('input');
				
			
				if(tableReg.rows[i].style.display == estatus ){
					var nombre = cellsOfRow[1].innerHTML.toLowerCase();
					for (var k = 0; k < compareWith.length; k++) {
						 if(compareWith[k].type == "radio" && compareWith[k].value == 1){
				 			 compareWith[k].checked=check;
							 break; 
							}
							}
			
					j++;
					}
					}
					check = true;
			}
			
	function desmarcarTodos()
		{
			var tableReg = document.getElementById(tabla);
			var cellsOfRow;
			var compareWith;
			for (var i = 1; i < tableReg.rows.length; i++)
			{
				cellsOfRow = tableReg.rows[i].getElementsByTagName('td');
				compareWith = cellsOfRow[columSel].getElementsByTagName('input');
				
			for (var k = 0; k < compareWith.length; k++) {
			 if(compareWith[k].type == "checkbox")
				  compareWith[k].checked=false; 
			}
			}
} 

function todos()
		{
			var tableReg = document.getElementById(tabla);
			var cantidad=0;
			var estatus= '';
			for (var i = 0; i < tableReg.rows.length; i++)
			{
				if(tableReg.rows[i].style.display == estatus ){
				cantidad++;
				}
				}
			
			return (cantidad-1);
} 
function contarChecked()
		{
			var tableReg = document.getElementById(tabla);
			var cellsOfRow;
			var compareWith;
			var contar = 0;
			for (var i = 1; i < tableReg.rows.length; i++)
			{
				cellsOfRow = tableReg.rows[i].getElementsByTagName('td');
				compareWith = cellsOfRow[columSel].getElementsByTagName('input');
				
			for (var k = 0; k < compareWith.length; k++) {
			 if(compareWith[k].type == "checkbox")
				  if(compareWith[k].checked==true) 
				  contar++; 
			}
			
			}
			return contar;
} 

function limpiar(nombreElemento){
	var elemento = document.getElementById(nombreElemento);
	elemento.value="";
}

function copiaValor(nombreElementoDesT,nombreElementoOri){
	var elemento = document.getElementById(nombreElementoDesT);
	var elemento2 = document.getElementById(nombreElementoOri);
	
	if(elemento2.value!= "")
	elemento.value=elemento2.value;
}

	/*
function montoSaldo() {
		
		var tableReg= document.getElementById(tabla);
		 var regex = /Saldo B[sS]+[fF]?\. \d+([,.]?\d*)/gm; 
		 var text="";
		 var compareWith;
		// Recorremos todas las filas con contenido de la tabla
			for (var i = 1; i < tableReg.rows.length; i++)
			{
				cellsOfRow = tableReg.rows[i].getElementsByTagName('td');
				// Recorremos todas las celdas
				 text = cellsOfRow[columResulModems].innerHTML;
				 if(text  == ""){
					 console.log("Error: "+text);
       				continue;
      }
				  var result = text.match(regex);
				  compareWith = cellsOfRow[columSalModen].getElementsByTagName('input');
				  if (result == null){
       				 compareWith[1].value = "";
        continue;
      }
      
      var regex2 = /\d+([,.]\d+)?/g;
      var saldo = result[0].match(regex2);
      var saldoMo = saldo[0].replace(",",".");
	  compareWith[1].value = saldoMo;
	  	}
				     
      
    }
    */

	</script>
    
     <style>
.menu
{	
	float: left;
    position: relative;
    left: -50%;
	background-color:#FFF;
    border-color:#999;
	border-bottom-style:inset;
	border-radius: 8px 8px 8px 8px;
     z-index:3;
	 
   }

.contenido
{
    float: left;
    position: fixed;
    left: 50%;
	top:100px;
	}


   </style>
</head>
<body  onLoad="doSearch()">
<? include "menu.php" ?>

<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>

<form id="form1" name="form1" method="post" action="">
<div  class="contenido" >
 <div  class="menu" >
    <input type="submit" name="Guardar" id="Guardar" value="Guardar P&aacute;gina" />
   
<?
//echo $_POST["comandos"];
?>
        <select name="comandos" id="comandos">
            <option value="1" <?=($_POST["comandos"]==1?"selected":"")?> >CONSULTAR SALDO</option>
            <option value="2" <?=($_POST["comandos"]==2?"selected":"")?> >VERIFICAR SEÑAL</option>
            <option value="3" <?=($_POST["comandos"]==3?"selected":"")?> >APAGAR MODEM</option>
            <option value="4" <?=($_POST["comandos"]==4?"selected":"")?> >PRENDER MODEM</option>
            <option value="5" <?=($_POST["comandos"]==5?"selected":"")?> >VER IMEI MODEM</option>
            <option value="6" <?=($_POST["comandos"]==6?"selected":"")?> >VER CONFIGURACION MODEM</option>
        </select>
	<input type="submit" name="Estado" id="Estado" value="Ejecutar" />
</div>
</div>
 
        <p>
          <?

	$tablaCliente='<br/><table border="1" align="center" cellpadding="1" cellspacing="0">';
	$tablaCliente= $tablaCliente . '<tr><td align="center">Cliente \ Prioridad</td>';


        $arreglo = array();
        $cantidadMensajes = array(); 
        $sql = "select COUNT(*) AS total, ServiceID  as service from Outbound where Dispatched = 0 group by ServiceID order by ServiceID asc";
        $query = mysql_query($sql,$conn);
        $cont = 0;
        while($row = mysql_fetch_array($query)){
                $arreglo["$cont"] = $row["service"];
                $cantidadMensajes["$cont"] = $row["total"];
                $tablaCliente=$tablaCliente . '<td align="center">' . $row["service"] . '</td>';
                $cont = $cont + 1;
        }
        if($cont != 0){
			$tablaCliente=$tablaCliente . '<td align="center"><b>Totales</b></td>';
		}
        $tablaCliente=$tablaCliente . '</tr>';
        $cliente = "aaaaaaa";
        $sql = "SELECT count(*) as total, c.ClientName as NombreCliente, o.ServiceID as Prioridad FROM `Outbound` as o, `Clients` as c WHERE o.Dispatched = 0 and c.ClientID = o.ClientID group by o.ServiceID, o.ClientID order by o.ClientID, o.ServiceID";
        $query = mysql_query($sql,$conn);       
        $bandera = 0;
        $cont = 0;
        $suma = 0;
        while($row = mysql_fetch_array($query)){
                if(strcasecmp($cliente, $row["NombreCliente"]) != 0){
                        
                        if(strcasecmp($bandera, "0") != 0){
                                for($i = $cont ; $i < count($cantidadMensajes) ; $i++ ){
                                        $tablaCliente=$tablaCliente . '<td align="center">0</td>';
                                }
								$tablaCliente=$tablaCliente . '<td align="center">'. $suma .'</td>';
                        }
                        $cliente = $row["NombreCliente"];
                        $tablaCliente=$tablaCliente . '</tr><tr><td align="center">' . $cliente . '</td>';
                        $cont = 0;
                        $bandera = 1;
                        $suma = 0;
                }
                for($i = $cont ; $i < count($cantidadMensajes) ; $i++ ){
                        if(strcasecmp($arreglo["$i"], $row["Prioridad"]) != 0){
                                $tablaCliente=$tablaCliente . '<td align="center" >0</td>';
                        } else {
                                $tablaCliente=$tablaCliente . '<td align="center">' . $row["total"] . '</td>';
                                $cont = $i+1;
								$suma = $suma + $row["total"];
                                break;
                        }       
                }
        
        }
        for($i = $cont ; $i < count($cantidadMensajes) ; $i++ ){
                $tablaCliente=$tablaCliente . '<td align="center">0</td>';
                $bandera = 4;
        }
		if(strcasecmp($bandera, "0") != 0){
			$tablaCliente=$tablaCliente . '<td align="center">'. $suma .'</td>';
		}
        $tablaCliente=$tablaCliente . '</tr>';
        $cont = count($cantidadMensajes);
        $tablaCliente=$tablaCliente . '<tr><td align="center"><b>Totales</b></td>';
        $suma = 0;
        for($i = 0 ; $i < $cont ; $i++){
    	    $bandera = 2;
    	    $tablaCliente=$tablaCliente . '<td align="center">' . $cantidadMensajes["$i"] . '</td>';
    	    $suma = $suma + $cantidadMensajes["$i"];
        }
        if(strcasecmp($bandera, "0") != 0){
			$tablaCliente=$tablaCliente . '<td align="center">'. $suma .'</td>';
		}
	$tablaCliente=$tablaCliente .'</tr></table><p align="center">Cola total en modems:' . $ttotal .'</p>';
	
	echo $tablaCliente;

?>
        </p>
        
  <p align="center">Modems activos:
        <?=$modemsactivos?></p>

<table border="1" align="center" cellpadding="1" cellspacing="0" id="modens">
  <tr>
    <th ><strong>Modem<br />
    <select name="locationModem" id="locationModem" onChange="doSearch()" >
	 <option value=""  <?=($locationModem=='' ? "selected":"")?>>Todos</option>
     <option value="CL" <?=($locationModem=='CL' ? "selected":"")?>>C. Lido (CL)</option>
      <option value = "GC" <?=($locationModem=='GC' ? "selected":"")?>> Level 3 (GC)</option>
      <option value="DY" <?=($locationModem== 'DY' ? "selected":"")?>> Dayco H. (DY)</option>
        
    </select><br/></strong></th>
    <th ><strong>Status<br />
    <select name="estatusModems" id="estatusModems" onChange="doSearch()" >
	 <option value=""  <?=($estatusModems=='' ?"selected":"")?>>Todos</option>
     <option value="1" <?=($estatusModems=='1' ?"selected":"")?>> Activos (A)</option>
      <option value = "0" <?=($estatusModems=='0' ?"selected":"")?>> Inactivos (I) </option>
      <option value="2" <?=($estatusModems== '2' ?"selected":"")?>> Desactivados (D) </option>
      <option value="3" <?=($estatusModems== '3' ?"selected":"")?>> Recargar (R) </option>
        
    </select><br/>
    </strong>Sel 'A': <a href="javascript:marcarRadio(8);" title="seleccionar todos"><strong>8</strong></a>,<strong> </strong><a href="javascript:marcarRadio(16);" title="seleccionar todos"><strong>16</strong></a>, <a href="javascript:marcarRadio(24);" title="seleccionar todos"><strong> 24</strong></a>,  <a href="javascript:marcarRadio(todos());" title="seleccionar todos"><strong>all</strong></a></th>
    <th >Comentario</th>
    <th ><strong>Saldo BD</strong></th>
    <th ><strong>N# Mensajes</strong></th>
    <th >Plan<br/>
    <select name="planOperadora" id="planOperadora" onChange="doSearch()" >
     <option value= "" <?=($planOperadora=='' ? "selected":"")?>>Todos</option>
	<? $cont = 0;
		$arr_length = count($operadorasList);
  		$oper;
    while($cont< $arr_length){
              $oper = $operadorasList["$cont"];
                $cont = $cont + 1;
       ?>
    
     <option value = "<?=$oper;?>" <?=($planOperadora== $oper ?"selected":"")?>> <?=$oper;?></option>
     <? } ?>
   </select></th>
   <th ><strong>Mensajes <br />en cola</strong></th>
   <th > <strong>Tiempo <br />Inactivo (Seg)</strong><br/>
    <select name="tiemInac" id="tiemInac" onChange="doSearch()" >
      <option value= "" <?=($tiemInac=='' ? "selected":"")?>>Todos</option>
     <option value = "-1" <?=($tiemInac=='-1' ?"selected":"")?>> Inactivos (-1)</option>
     <option value="0" <?=($tiemInac=='0' ?"selected":"")?>> Activos (>0)</option>
   </select></th>  
    <th  ><strong>Selecionar <br />
    </strong><a href="javascript:marcar(8);" title="seleccionar todos"><strong>8</strong></a>, <a href="javascript:marcar(16);" title="seleccionar todos"><strong>16</strong></a>, <a href="javascript:marcar(24);" title="seleccionar todos"><strong>24</strong></a>, <a href="javascript:marcar(todos());" title="seleccionar todos"><strong>all</strong></a></th>
  
    <th ><strong>Respuesta modem</strong></th>
    <!--th >Saldo Modem</th-->
  </tr>


<?
$sql = "SELECT Modem, Location, ModemTypeID, ModemID, Active, Money, PrepaidPlanID, (SELECT PlanName FROM PrepaidPlans WHERE PrepaidPlans.PrepaidPlanID = ModemStatus.PrepaidPlanID) AS PrepaidPlans, MobileNumber, BillingDate, ExpirationDate, Comments, IP, (SELECT COUNT(*) FROM RejectedMessages WHERE OutDate > '".date("Y-m-d")." 00:00:00' AND RejectedMessages.DispatchedBy = ModemStatus.ModemID) AS MR FROM ModemStatus  ORDER BY ModemID ";
$query = mysql_query($sql,$conn);
while($row = mysql_fetch_array($query)){
	if(in_array($row["ModemID"],$_POST['sel'])){

                $modem = $row["Modem"];
                $modemid = $row["ModemID"];

                switch ($_POST['comandos']){
			case 1:
                        $ip = $row["IP"];
                        if($fp = fsockopen($ip,$modem,$errno,$errstr,15)){
                                fwrite($fp,"AT+CUSD=1,\"*123#\",15".chr(13));
                                usleep(5000000);
				$text = fread($fp,512);
				preg_match_all("/Su saldo es: Bs. ([0-9.]+) y ademas tiene bono de Bs. ([0-9.]+)/",$text,$arr,$sumita);
                                if(isset($arr[1][0])){
                                        $saldo = "El Saldo Actual es Bs. ".($arr[1][0]+$arr[2][0]);
                                }else{
                                        $saldo = $text;
                                }
                                fclose($fp);
	                }
                        break;
               
			case 2:
                        $ip = $row["IP"];
                        if($fp = fsockopen($ip,$modem,$errno,$errstr,15)){
                                fwrite($fp,"AT+CSQ".chr(13));
                                usleep(700000);
                                $estado = fread($fp,512);
                                fclose($fp);
			}else
				$text = "No se pudo consultar la señal del modem";
                        break;

              
			case 3:
                        $ip = $row["IP"];
                        if($fp = fsockopen($ip,$modem,$errno,$errstr,15)){
                                fwrite($fp,"AT+CFUN=0".chr(13));
                                usleep(700000);
                                $estado = fread($fp,512);
                                fclose($fp);
                        }
                        break;

               
			case 4:
                        $ip = $row["IP"];
                        if($fp = fsockopen($ip,$modem,$errno,$errstr,15)){
                                fwrite($fp,"AT+CFUN=1".chr(13));
                                usleep(700000);
                                $estado = fread($fp,512);
                                fclose($fp);
                        }
                        break;
                
			case 5:
                        $ip = $row["IP"];
                        if($fp = fsockopen($ip,$modem,$errno,$errstr,15)){
                                fwrite($fp,"AT+CGSN".chr(13));
                                usleep(700000);
                                $estado = fread($fp,512);
                                fclose($fp);
                        }
                        break;
                
			case 6:
	                $ip = $row["IP"];
                        if($fp = fsockopen($ip,$modem,$errno,$errstr,15)){
                                fwrite($fp,"AT&V".chr(13));
                                usleep(700000);
                                $estado = fread($fp,512);
                                fclose($fp);
                        }
                        break;
                
			case 7:
                        $ip = $row["IP"];
                        if($fp = fsockopen($ip,$modem,$errno,$errstr,15)){
                                fwrite($fp,"AT+WMBS=5,1".chr(13));
                                usleep(700000);
                                $estado = fread($fp,512);
                                fclose($fp);
                        }
                        break;
                
			case 8:
                        $ip = $row["IP"];
                        if($fp = fsockopen($ip,$modem,$errno,$errstr,15)){
                                fwrite($fp,"AT+WMBS=4,1".chr(13));
                                usleep(700000);
                                $estado = fread($fp,512);
                                fclose($fp);
                        }
                        break;
                }

 //  ******************************************************************
        }
	?>
    <tr class="<?='color'.$row["Active"];?>">
        <td>
	<?=$row["ModemID"].$row["Location"];
	//$disable = ($row["Active"]==2 || $row["PrepaidPlanID"]==3?'disabled="disabled"':'');
	$disable = ($row["Active"]==2?'disabled="disabled"':'');
	if($row["Active"]==1)
		$disableCheck = "disabled=\"disabled\"";
	?>
</td>   
     <td align="center">
     A:<input type="radio" name="activo<?=$row["ModemID"]?>" id="radio" value="1" <?=($row["Active"]==1?'checked="checked"':'')?> <?=$disable?> />
     I:<input type="radio" name="activo<?=$row["ModemID"]?>" id="radio" value="0" <?=($row["Active"]==0?'checked="checked"':'')?> <?=$disable?>/>
     D:<input type="radio" name="activo<?=$row["ModemID"]?>" id="radio" value="2" <?=($row["Active"]==2?'checked="checked"':'')?> <?=$disable?> />
	 R:<input type="radio" name="activo<?=$row["ModemID"]?>" id="radio" value="3" <?=($row["Active"]==3?'checked="checked"':'')?> <?=$disable?> />
	
</td>
<? 
	$disable = ($row["PrepaidPlanID"]==2?'readonly="readonly"':'');
?>
	<td><input name="comentario<?=$row["ModemID"]?>" type="text" id="comentario<?=$row["ModemID"]?>" value="<?=$row["Comments"]?>" size="15" maxlength="60" <?=$disable?>/> <input name="lipComentario<?=$row["ModemID"]?>" type="button" id="lipComentario<?=$row["ModemID"]?>" onClick="limpiar('comentario<?=$row["ModemID"]?>')" value="<<" <?=$disable?> /></td>
     <td><input name="saldo<?=$row["ModemID"]?>" id="saldo<?=$row["ModemID"]?>" type="text" value="<?=$row["Money"]?>" size="6" <?=$disable?>/></td>
	 
	<td><input name="mensajes<?=$row["ModemID"]?>" type="text" id="mensajes<?=$row["ModemID"]?>" value="" size="6"<?=$disable?>/></td>
 
      
      <td><?=$row["PrepaidPlans"]?></td>




        <!--<td><?=$row["BillingDate"]?></td>
        <td><?=$row["ExpirationDate"]?></td>-->
        <td><table border = "10"><tr><? $modem = $row["ModemID"];
	$sql = "select ServiceID, Count(*) as Total from Outbound ";
	$sql.= "where DispatchedBy = '$modem' and Dispatched = 0 ";
	$sql.= "GROUP BY ServiceID ORDER BY ServiceID ASC";
	$innerquery = mysql_query($sql,$conn);
	if(mysql_num_rows($innerquery) > 0){
		$subtotal=0;
		while($innerrow = mysql_fetch_array($innerquery)){?>
	<td>ID<?=$innerrow['ServiceID']?>=<?=$innerrow['Total']?></td>
	<? 		$subtotal+=$innerrow['Total'];
		} echo "<td>T=$subtotal</td>";
		//$ttotal+=$subtotal;
	}else{?>
	0
	<? }?>
	</tr></table></td>
	<td>
	<?
	$sql = "SELECT TIMESTAMPDIFF( 
		SECOND , MAX( OutDate ) , NOW( ) ) as Tiempo
		FROM Outbound
		WHERE DispatchedBy =  '".$modem."'
		GROUP BY DispatchedBy";
	$innerquery = mysql_query($sql,$conn);
	if(mysql_num_rows($innerquery) > 0){
		while($innerrow = mysql_fetch_array($innerquery)){
			if(trim($innerrow['Tiempo']) != ''){
				echo $innerrow['Tiempo'];
			}else{
				echo "-1";
			}
		}
	}else{
	
	
	?>
	-1
	<? }?>	
	
	</td>
	    <td align="center"><label>
	      <input type="checkbox" name="sel[]" id="sel[]" value="<?=$row["ModemID"]?>" <?=$disableCheck?>/>
	</label></td>
	<?=$disableCheck=''?>
        <!--<td><?=$row["MR"]?></td>-->
      <td><?=(in_array($row["ModemID"],$_POST['sel'])?$estado.$saldo.$reiniciar:"")?></td>
      <!-- td><input name="copiaSaldo<?=$row["ModemID"]?>" type="button" id="copiaSaldo<?=$row["ModemID"]?>" onClick="copiaValor('saldo<?=$row["ModemID"]?>','saldoMod<?=$row["ModemID"]?>')" value="<--" <?=$disable?> /><input name="saldoMod<?=$row["ModemID"]?>" type="text" disabled id="saldoMod<?=$row["ModemID"]?>" value = "" size="6" <?=$disable?>/></td-->
  	</tr>
    <?
}
?>
</table>
<p align="center">Modems activos:
        <?=$modemsactivos?></p>

<div align="center">
</div>
  <table border="1" align="center" cellpadding="1" cellspacing="0">
    <tr>
      <td align="center">&nbsp;</td>
      <td align="center">Digitel</td>

      <td align="center">Total</td>
    </tr>
    <tr>
      <td align="center" >Saldo  modems segun BD:</td>
      <td>BsF.
        <?
$sql = "SELECT SUM(Money) as Money FROM `ModemStatus` WHERE OperatorID = 1";
$query = mysql_query($sql,$conn);
if($row = mysql_fetch_array($query)){
	if(is_numeric($row["Money"]))
		$saldomo1 = $row["Money"];
	else
		$saldomo1 = 0;
	echo number_format($saldomo1,2,",",".");
}
?></td>
     <!-- <td>BsF.
        <?
$sql = "SELECT SUM(Money) as Money FROM `ModemStatus` WHERE OperatorID = 2";
$query = mysql_query($sql,$conn);
if($row = mysql_fetch_array($query)){
	if(is_numeric($row["Money"]))
		$saldomo2 = $row["Money"];
	else
		$saldomo2 = 0;
	echo number_format($saldomo2,2,",",".");
}
?></td>
      <td>BsF.
        <?
$sql = "SELECT SUM(Money) as Money FROM `ModemStatus` WHERE OperatorID = 3";
$query = mysql_query($sql,$conn);
if($row = mysql_fetch_array($query)){
	if(is_numeric($row["Money"]))
		$saldomo3 = $row["Money"];
	else
		$saldomo3 = 0;
	echo number_format($saldomo3,2,",",".");
}
?></td>-->
      <td>BsF.
        <?
$sql = "SELECT SUM(Money) as Money FROM `ModemStatus` ";
$query = mysql_query($sql,$conn);
if($row = mysql_fetch_array($query)){
	if(is_numeric($row["Money"]))
		$saldomo = $row["Money"];
	else
		$saldomo = 0;
	echo number_format($saldomo,2,",",".");
}
?></td>
    </tr>
    <tr>
      <td>Saldo restante en BD:</td>
      <td>BsF.
      <?
$sql = "SELECT SUM((SELECT Money FROM PrepaidCards WHERE PrepaidCards.CardID = InsertedCards.CardID)) as Money FROM `InsertedCards` WHERE Used = 0 and CardID IN (SELECT CardID FROM PrepaidCards WHERE OperatorID = 1)";
$query = mysql_query($sql,$conn);
if($row = mysql_fetch_array($query)){
	if(is_numeric($row["Money"]))
		$saldobd1 = $row["Money"];
	else
		$saldobd1 = 0;
	echo number_format($saldobd1,2,",",".");
}
?></td>
	  <!--<td>BsF.
      <?
$sql = "SELECT SUM((SELECT Money FROM PrepaidCards WHERE PrepaidCards.CardID = InsertedCards.CardID)) as Money FROM `InsertedCards` WHERE Used = 0 and CardID IN (SELECT CardID FROM PrepaidCards WHERE OperatorID = 2)";
$query = mysql_query($sql,$conn);
if($row = mysql_fetch_array($query)){
	if(is_numeric($row["Money"]))
		$saldobd2 = $row["Money"];
	else
		$saldobd2 = 0;
	echo number_format($saldobd2,2,",",".");
}
?></td>
      <td>BsF.
      <?
$sql = "SELECT SUM((SELECT Money FROM PrepaidCards WHERE PrepaidCards.CardID = InsertedCards.CardID)) as Money FROM `InsertedCards` WHERE Used = 0 and CardID IN (SELECT CardID FROM PrepaidCards WHERE OperatorID = 3)";
$query = mysql_query($sql,$conn);
if($row = mysql_fetch_array($query)){
	if(is_numeric($row["Money"]))
		$saldobd3 = $row["Money"];
	else
		$saldobd3 = 0;
	echo number_format($saldobd3,2,",",".");
}
?></td>-->
      <td>BsF.
      <?
$sql = "SELECT SUM((SELECT Money FROM PrepaidCards WHERE PrepaidCards.CardID = InsertedCards.CardID)) as Money FROM `InsertedCards` WHERE Used = 0";
$query = mysql_query($sql,$conn);
if($row = mysql_fetch_array($query)){
	if(is_numeric($row["Money"]))
		$saldobd = $row["Money"];
	else
		$saldobd = 0;
	echo number_format($saldobd,2,",",".");
}
?></td>
    </tr>
    <tr>
      <td>Saldo total por operadora:</td>
      <td>BsF.
      <?=number_format($saldomo1+$saldobd1,2,",",".");?></td>
      <!--<td>BsF.
      <?=number_format($saldomo2+$saldobd2,2,",",".");?></td>
      <td>BsF.
      <?=number_format($saldomo3+$saldobd3,2,",",".");?></td>-->
      <td>BsF.
      <?=number_format($saldomo+$saldobd,2,",",".");?></td>
    </tr>
  </table>
 

	<?=$tablaCliente;?>
	
 
</form>
<? include "menu.php" ?>
<? }else{
	header("Location: index.php");
}
?>
</body>
</html>
