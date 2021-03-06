<?session_start();
//Copia del documento admmodems.php

include '../lib/conn.php';

$usuario = $_SESSION['login'];

$ABSPATH = dirname(__FILE__).'/';
include_once($ABSPATH.'adminmodems/cargainicialm.php');

$planOperadora="";
$estatusModems= "";
if(isset($_SESSION['login'])){
	
	if($_POST["estatusModems"] != null){
		$estatusModems= $_POST["estatusModems"];
	}
	if($_POST["planOperadora"] != null){
		$planOperadora= $_POST["planOperadora"];	
	}

	
	//Lista de Planes asignados
	$operadorasList = array(); 
    $sql = "SELECT  b.PlanName as PlanName FROM `ModemStatus` as a,  `PrepaidPlans` as  b  WHERE a.`PrepaidPlanID`= b.`PrepaidPlanID` group by b.PlanName";
	$query = mysql_query($sql,$conn);
    $cont = 0;
    while($row = mysql_fetch_array($query)){
        $operadorasList["$cont"] = $row["PlanName"];
        $cont = $cont + 1;
    }
?>
<html>
<head>
<title>Administraci&oacute;n de Modems</title>
<link rel="stylesheet" type="text/css" href="unplugged.css" />
<script>
var check = false;
function selectall(formName){
	var form = document.getElementById(formName);
    if(form!=null){
        var elements;
        var cantidadElements;
        var checkeado = false;
        var i;
        var element;
        elements = form.getElementsByTagName('input');
        cantidadElements = elements.length;
        check = !check;
        for(i=0;i<cantidadElements;i++){
            element = elements[i];
            if(element.type.toLowerCase()=='checkbox'){
                element.checked = check;//chekear todos los check del formulario
            } 
        }        
    }
}
</script>

<script>
	var tabla = 'tabla';
	var filtro1 = 'estatusModems';
	var filtro2 = 'planOperadora';
	var columFil1 = 4;
	var columFil2 = 5;
	function doSearch()
	{
			var tableReg = document.getElementById(tabla);
			var searchText1 = document.getElementById(filtro1).value.toLowerCase();
			var searchText2 = document.getElementById(filtro2).value.toLowerCase();
			var cellsOfRow="";
			var found=false;
			var compareWith="";
 			var compareWith2="";
			var posLoc;
			var statusM="";
 			
			//tranformo los datos que me da el filtro
			switch(searchText1)
			{
				case "0":
					statusM = "inactivo";
					break;
				case "1":
					statusM = "activo";
					break;
				case "2":
					statusM = "desactivado";
					break;
				case "3":
					statusM = "recargar";
					break;
				default:
					statusM = "";
			}
			// Recorremos todas las filas con contenido de la tabla
			for (var i = 1; i < tableReg.rows.length; i++)
			{
				cellsOfRow = tableReg.rows[i].getElementsByTagName('td');
				found = false;
				// Recorremos todas las celdas
				if(!found)
				{	
			
					compareWith = cellsOfRow[columFil1].innerHTML.toLowerCase();
					compareWith2 = cellsOfRow[columFil2].innerHTML.toLowerCase();
				
			
					if ((statusM.indexOf(compareWith)== 0 || statusM == "") && (compareWith2.indexOf(searchText2) == 0 || searchText2 == ""))
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


</script>



</head>
<body>
<?include_once('./menu.php');?>
<center>
<div style="width:70%; text-align:left;">
<h1 align="center">Administracion de Modems</h1>
<?


//
$resp = '';

if(isset($_SESSION['respSess'])){
	$resp = $_SESSION['respSess'];
	unset($_SESSION['respSess']);
}

	if(is_string($resp) && strcasecmp($resp, '') != 0){
?>
<div id="respuesta" name="respuesta" class="aviso">
<?=$resp?>
</div>
<?
		$resp = '';
	}


	$tabla = cargaTablaModems();
	
	foreach($tabla as $campo => $valores){
		$elementos = count($valores) - 1;
	}
	
	$tablaFinal = '';
	
	$body = '';
	

	for($i = 0; $i <= $elementos; $i++){
		$checks = '<td><input id="cb[]" name="cb[]" type="checkbox" value="[id]"/>';
		$body = $body.'<tr class="color[c]">';
		foreach($tabla as $campo => $valores){
			$body = $body. "<td>".$valores[$i]."</td>";
			if(strcasecmp($campo, config::nombreCampoIdModem) == 0){
				$idModem = $valores[$i];
			}elseif(strcasecmp($campo, config::nombreEstadoScript) == 0){
				$estadoScript = $valores[$i];
			}
		}
		
		if(strcasecmp($estadoScript, 'activo') == 0){
			$color = '1';
		}else{
			$color = '2';			
		}
		
		$body = str_replace('[c]', $color, $body);
		
		$checks = str_replace('[id]', $idModem, $checks);
		
		$respModem = $resp[$idModem];
			
		if($respModem == NULL){
			$body = $body.$checks.'<td>*</td></tr>';
		}else{
			$body = $body.$checks.'<td>'.$respModem.'</td></tr>';
		}
	}
	
	$tablaFinal = $body . "</table>";
?>


<form name="form1" id="form1" method="get" action="adminmodems/startStopRestart.php" >
<input type="hidden" name="pathpadre" id="pathpadre" value=<?=$ABSPATH?> />
<div align="center">
	<input type="submit" name="<?=config::idBotonModems?>" id="<?=config::idBotonModems?>" value=" Start " />
	<input type="submit" name="<?=config::idBotonModems?>" id="<?=config::idBotonModems?>" value=" Stop " />
	<input type="submit" name="<?=config::idBotonModems?>" id="<?=config::idBotonModems?>" value=" Restart " />
	<input type="button" name="all" id="all" value=" Select all "  onclick="javascript:selectall('form1');"/>
</div>
<br/>

<table name="tabla" id="tabla" border="1" align="center" cellpadding="1" cellspacing="0">
<tr>
	<th ><strong>Id modem<br/></strong></th>
	<th ><strong>COM<br/></strong></th>
	<th ><strong>Ubicaci&oacute;n<br/></strong></th>
	<th ><strong>Estado Script<br/></strong></th>
	<th ><strong>Estado Modem<br/></strong>
		<select name="estatusModems" id="estatusModems" onChange="doSearch()" >
			<option value=""  <?=($estatusModems=='' ?"selected":"")?>>Todos</option>
			<option value ="0" <?=($estatusModems=='0' ?"selected":"")?>>Inactivo</option>
			<option value="1" <?=($estatusModems=='1' ?"selected":"")?>>Activo</option>
			<option value="2" <?=($estatusModems== '2' ?"selected":"")?>>Desactivado</option>
			<option value="3" <?=($estatusModems== '3' ?"selected":"")?>>Recargar</option>
		</select>
	</th>
	<th><strong>Plan<br/></strong>
    <select name="planOperadora" id="planOperadora" onChange="doSearch()" >
		<option value= "" <?=($planOperadora=='' ? "selected":"")?>>Todos</option>
		<?
			$cont = 0;
			$arr_length = count($operadorasList);
			$oper;
			while($cont< $arr_length){
				$oper = $operadorasList["$cont"];
				$cont = $cont + 1;
		?>
		
		<option value = "<?=$oper;?>" <?=($planOperadora== $oper ?"selected":"")?>> <?=$oper;?></option>
     <? } ?>
	 
   </select>
	<th ><strong>Comentario<br/></strong></th>
	<th ><strong>Id Operadora<br/></strong></th>
	<th ><strong>Check<br/></strong></th>
	<th ><strong>Respuesta<br/></strong></th>
	
</tr>

<?=$tablaFinal?>
<br/>
<div align="center">
	<input type="submit" name="<?=config::idBotonModems?>" id="<?=config::idBotonModems?>" value=" Start " />
	<input type="submit" name="<?=config::idBotonModems?>" id="<?=config::idBotonModems?>" value=" Stop " />
	<input type="submit" name="<?=config::idBotonModems?>" id="<?=config::idBotonModems?>" value=" Restart " />
	<input type="button" name="all" id="all" value=" Select all "  onclick="javascript:selectall('form1');"/>
</div>
</form>
</div>
</center>
<?include_once('menu.php');?>
</body>
</html>
<?}else{
	header("Location: index.php");
}
?>