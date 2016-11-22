<?session_start();
//Temporal
$usuario = $_SESSION['login'];

$ABSPATH = dirname(__FILE__).'/';
include_once($ABSPATH.'adminmodems/cargainicialm.php');
if(isset($_SESSION['login'])){
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
	
	$tablaFinal = '<table name="tabla" id="tabla" border="1" align="center"><tr>';
	
	foreach($tabla as $campo => $valores){
		$tablaFinal = $tablaFinal."<th>$campo</th>";
		$elementos = count($valores) - 1;
	}
	
	$tablaFinal = $tablaFinal.'<th>check</th><th>Respuesta</th></tr>';
	
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
	
	$tablaFinal = $tablaFinal . $body . "</table>";
	
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

