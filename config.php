<?php
$pathUtilidades = dirname(__FILE__).'/'.config::pathUtilidades;
//INCLUDES******************
include_once($pathUtilidades.'logWriter.php');
include_once($pathUtilidades.'errorHandler.php');
include_once($pathUtilidades.'exceptionHandler.php');
include_once($pathUtilidades.'configUtilidades.php');
include_once($pathUtilidades.'funcionesUtilidades.php');
include_once($pathUtilidades.'manejoBd.php');
include_once($pathUtilidades.'manejoArchivos.php');


//PROPIEDADES GENERALES*****
set_error_handler('errorHandler');
set_exception_handler('exceptionHandler');
date_default_timezone_set('America/Caracas');

//VARIABLES******************

class config{

	const nombreAplicacion='Despachadores Web Des';
	const pathUtilidades='../utilidades/';
	//const logPathAcceso='/var/log/unplugged/kannelModems/acceso/';
	//const logPathError='/var/log/unplugged/kannelModems/error/';
	//const logPathMonitor='/var/log/unplugged/kannelModems/monitor/';
	const logPathAcceso='/var/log/unpluggedLogs/despachadores/desarrollo/acceso/';
	const logPathError='/var/log/unpluggedLogs/despachadores/desarrollo/error/';
	const logPathMonitor='/var/log/unpluggedLogs/despachadores/desarrollo/monitor/';
	const fileName='';
	const fileExt='log';
	
	
	// adminmodems/ ----------------------------------------------------
	
	//const nombreScriptModems = 'modem.php';
	const nombreScriptModems = 'modem.php|modemMovilnet.php';
/*	
	const idBdHost = 100;
	const bdUser='root';
	const bdPass='MyUnplugged2008';
	const bdName='modems_mt';
	
*/
	const idBdHost = 100;
	const bdUser='root';
	const bdPass='BDDesarrollo2008';
	const bdName='modems_mt';

	
	public static function tablaTransformaciones(){
		return array(	'Estado del Modem' =>	array(	0 => 'Inactivo', 
														1 => 'Activo', 
														2 => 'Desactivado',
														3 => 'Recargar',
														100 => 'Desconocido'),
						
						
						'Plan' => 				array(	1 => 'Sin Plan Digitel',
														2 => 'SMS Ilimitado',
														3 => 'Sin Plan Movistar',
														4 => 'Escribe Pegado',
														5 => 'Sin Plan Movilnet',
														6 => 'Mensajes de texto ilimitados Movilnet'),
														
						'Ubicacion' => 			array(	'TE'=>'Torre Europa',
														'GC'=>'Global Crossing',
														'BM'=>'Babarian Motors',
														'DY'=>'Dayco Host', 
														'TB'=>'Transbanca',
														'CL'=>'Centro Lido',
														100 => 'Desconocido')
														
					);
	}
	
	const posiEstadoScript = 3;
	const nombreEstadoScript = 'Estado del Script';
	const nombreCampoIdModem = 'Id Modem';
	//const queryTabla = "SELECT ModemID as 'Id Modem', SUBSTRING(Location, 5, 5) as 'COM', SUBSTRING(Location, 1, 2) as 'Ubicacion', Active as 'Estado del Modem', Comments as 'Comentario' FROM ModemStatus ORDER BY  `ModemStatus`.`ModemID` ASC";
	const queryTabla = "SELECT ModemID as 'Id Modem', SUBSTRING(Location, 5, 5) as 'COM', SUBSTRING(Location, 1, 2) as 'Ubicacion', Active as 'Estado del Modem', PrepaidPlanID as 'Plan', Comments as 'Comentario', OperatorID as 'Id Operadora' FROM ModemStatus ORDER BY  ModemStatus.ModemID ASC";
	//const queryTabla = "SELECT ModemID as 'Id Modem', SUBSTRING(Location, 5, 5) as 'COM', SUBSTRING(Location, 1, 2) as 'Ubicacion', Active as 'Estado del Modem', Comments as 'Comentario', (SELECT Name FROM Operator WHERE Operator.OperatorID = ModemStatus.OperatorID) 'Nmb Operadora' FROM ModemStatus ORDER BY  `ModemStatus`.`ModemID` ASC";
	
	const idBotonModems = 'boton';
	const pathFileScript = '/etc/init.d/modems';
	const pathRespModems = './salidasModems/';
	
	public static function tablaScripOperador(){
		return array(	1 => '/var/www/modems/modem.php',
						3 => '/var/www/modems/modemMovilnet.php'
					);
	}
	
	const queryTablaOperadoras = "SELECT ModemID, OperatorID FROM ModemStatus WHERE ModemID in ";
	
	//contingencia ----------------------------------------------------------------------------------------------------------------
	
	const separadorClientes = "<br/><br/>";
	
	const valorOkUS = 'true';
	
	//const idBanesco = '135';
	//const idBFC = '198';
	//const idActivo = '233';
	//const idAdverWeb = '219';
	//const idAFA = '232';
	//const idBicentenario = '237';
	//const idMotoresTrinidad = '238';
	//const idTSV = '236';
	
	//DEsarrollo
	public static function arrayUrlUs(){
		return array(	'banesco' => 'http://190.216.246.164:8081/UnpluggedServices/ServicioAdministracion.jws', 
						'bfc' => 'http://190.216.246.164:8081/UnpluggedServicesBFC/ServicioAdministracion.jws', 
						'activo' => 'http://190.216.246.164:8081/UnpluggedServicesActivo/ServicioAdministracion.jws', 
						'adverweb' => 'http://190.216.246.164:8081/serviciosAdverWeb/ServicioAdministracion.jws'
					);
	}
	//Desarrollo
	public static function arrayUrlDe(){
		return array(	'activo' => 'http://192.168.4.4:8085/despachadorUnplugged/ServicioAdministracion.jws'
					);
	}
	//Produccion
	/*public static function arrayUrlUs(){
		return array(	'banesco' => 'http://190.216.246.165:8080/UnpluggedServices/ServicioAdministracion.jws', 
						'bfc' => 'http://190.216.246.162:8080/UnpluggedServicesBFC/ServicioAdministracion.jws', 
						'activo' => 'http://190.216.246.162:8080/UnpluggedServicesActivo/ServicioAdministracion.jws', 
						'adverweb' => 'http://190.216.246.162:8080/serviciosAdverWeb/ServicioAdministracion.jws'
					);
	}*/
	//Produccion
	/*public static function arrayUrlDe(){
		return array(	'activo' => 'http://192.168.4.3:8085/despachadorUnplugged/ServicioAdministracion.jws'
					);
	}*/

	//Clientes 
	public static function idCliente(){
		return array(	'Bancaribe' => '253',
				'Banco Activo' => '233',
				'Banesco' => '135', 
				'BFC' => '198', 
				'Mi Banco' => '248',
				'TodoTicket' => '186',
				);
	}	
	/*public static function arrayUrls(){
		return array(	'banescoUs' => 'http://190.216.246.164:8081/UnpluggedServices/ServicioAdministracion.jws', 
						'bfcUs' => 'http://190.216.246.164:8081/UnpluggedServicesBFC/ServicioAdministracion.jws', 
						'activoUs' => 'http://190.216.246.164:8081/UnpluggedServicesActivo/ServicioAdministracion.jws', 
						'adverwebUs' => 'http://190.216.246.164:8081/serviciosAdverWeb/ServicioAdministracion.jws',
						'activoDe' => 'http://190.216.246.164:8081/despachadorUnplugged/ServicioAdministracion.jws'
					);
	}*/
		
	/*const urlBanesco = 'http://190.216.246.164:8081/UnpluggedServices/ServicioAdministracion.jws';
	const urlBFC = 'http://190.216.246.164:8081/UnpluggedServicesBFC/ServicioAdministracion.jws';
	const urlActivo = 'http://190.216.246.164:8081/UnpluggedServicesActivo/ServicioAdministracion.jws';
	const urlAdverWeb = 'http://190.216.246.164:8081/serviciosAdverWeb/ServicioAdministracion.jws';*/

	
	//const urlBanesco = 'http://190.216.246.165:8080/UnpluggedServices/ServicioAdministracion.jws';
	//const urlBFC = 'http://190.216.246.162:8080/UnpluggedServicesBFC/ServicioAdministracion.jws';
	//const urlActivo = 'http://190.216.246.162:8080/UnpluggedServicesActivo/ServicioAdministracion.jws';
	//const urlAdverWeb = 'http://190.216.246.162:8080/serviciosAdverWeb/ServicioAdministracion.jws';
	
	
	public static function  parametrosServicio(){
		return array('cache_wsdl' => WSDL_CACHE_NONE);
	}
	
	const claveNomFuncion = 'method';
	const claveNomAtributo = 'key';
	const claveNomValor = 'value';
		
	const configOperatorKannel = 'configOperatorKannel';
		
	//const gwNameKannel = 'kannel';
	
	/*const idOpeDigitel = '1';
	const idOpeMovistar = '2';*/
	
	public static function puDataInicial(){
                return array('method' => 'getConfig');
    }
    public static function puReload(){
                return array('method' => 'reloadConfig');
    }
    public static function puSetParameter($campo, $valor){
                return array(	'method' => 'setConfig', 
								'key' => $campo, 
								'value' => $valor);
    }
	
		
	public static function puGenericDes(){
		return array(	'method' => 'setConfig', 
						'key' => 'urlDespachadores', 
						'value' => 'http://190.216.246.164');
	}
	public static function puIpKannelDes(){
		return array(	'method' => 'setConfig', 
						'key' => 'mtGateway', 
						'value' => 'http://190.216.246.164:13013/cgi-bin/sendsms');
	}
	public static function puIpDespachadoresDes(){
		return array(	'method' => 'setConfig', 
						'key' => 'webServicemt', 
						'value' => 'http://190.216.246.164/gateway/server.php');
	}
	public static function puIpRoutoDes(){
		return array(	'method' => 'setConfig', 
						'key' => '', 
						'value' => '');
	}
	
	public static function puGenericProd(){
		return array(	'method' => 'setConfig', 
						'key' => 'urlDespachadores', 
						'value' => 'http://190.216.246.163');
	}	
	public static function puIpKannelProd(){
		return array(	'method' => 'setConfig', 
						'key' => 'mtGateway', 
						'value' => 'http://190.216.246.163:13013/cgi-bin/sendsms');
	}
	public static function puIpDespachadoresProd(){
		return array(	'method' => 'setConfig', 
						'key' => 'webServicemt', 
						'value' => 'http://190.216.246.163/server.php');
	}
	public static function puIpRoutoProd(){
		return array(	'method' => 'setConfig', 
						'key' => '', 
						'value' => 'http://190.216.246.164:1310/cgi-bin/sendsms');
	}
	
	const methodAddKannel = 'addKannel';
	const methodRemoveKannel = 'removeKannel';
	const npIdCliente = 'idCliente';
	const npIdOperadora = 'idOperadora';

	/*
	 * Recibe el xml y la variable que se modificara
	 * */
	/*public static function parseRespService($strXml, $valueName){
		
		$query = '//key[@name="'.$valueName.'"]';
		
		$doc = new DOMDocument();
		$doc->loadXML($strXml);
		$xp = new domxpath($doc);
		$node = $xp->query($query);	
		$value = $node->item(0)->nodeValue;
		
		return $value;
	}*/
	
	// Adm. Monitores (Suiches)/ ---------------------------------------
	
	public static function monitores(){
		return array(	'kannelSelfManage' => array('/var/www/kannelSelfManage/', array('ln', 'suiche')),
						'monitorModems' => array('/var/www/monitorModems/', array('suiche')),
						'reenvioAccessKannel' => array('/var/www/reenvioAccessKannel/', array('suiche'))
		);
	}
	
	const valorEncendido = 'ON';
	const valorApagado = 'OFF';
	
	const fileSuiche = 'suiche';
	const fileLn = 'ln';



	// Token Tic Connector (TTC)/ ---------------------------------------

	const wsdl = 'http://localhost:8081/TokenTicEmpresarial/services/ServicioAutenticacion?wsdl';
	
	const resincronizarAplicacion = 'resincronizarAplicacion';
	const resincronizarCanal = 'resincronizarCanal';
	const sincronizarAplicacion = 'sincronizarAplicacion';
	const sincronizarCanal = 'sincronizarCanal';
	const validarOtp = 'validarOtp';
	
	// Busca Logs Despachadores ---------------------------------------
	
	const lineasLogs = 100;
	const maxLineasLogs = 1000;
	
	/*public static function arrayUrls(){
		return array('despActivo' => 'http://192.168.4.3:8085/despachadorUnplugged/ServicioAdministracion.jws', 
					 'usBanesco' => 'http://190.216.246.165:8080/UnpluggedServices/ServicioAdministracion.jws');
	}*/
	
	public static function arrayAppPuente(){
		return array('despActivo');
	}
	/*public static function arrayAppPuente(){
		return array('activo');
	}*/
	
	public static function puLogs($tl, $cl){
		return array(	'method' => 'getLog', 
						'tipoLog' => $tl, 
						'cantLineas' => $cl);
	}
	
	//const xmlPath = '/respuesta/lineas/linea';

	const xmlLogPath = 'lineas/linea';
	
	const separadorLogs = '<br/>';
	
	//Adm. US ---------------------------------------
	
	const listaIdCli = 'idClientsList';
	const separadorLIC = ' ';
	const listaNmbCli = 'nameClientList';
	const separadorLNC = '|';
	
	const nmbCodigo = 'codigo';
	const nmbDescripcion = 'descripcion';
	const nmbDdetalle = 'detalle';
	
	
	/*const showThreads = 'showThreads';
	const getAmountSentences = 'getAmountSentences';
	const emptyQueueSentences = 'emptyQueueSentences';
	const detenerDemonios = 'detenerDemonios';
	const iniciarDemonios = 'iniciarDemonios';
	const getCollectionIdSMS = 'getCollectionIdSMS';
	const cleanCollectionIdSMS = 'cleanCollectionIdSMS';*/
	
	const labelSetThreads = 'setThreads';
	const labelControlReenvioQuery = 'controlReenvioQuery';
	const labelGetCollectionIdSMS = 'getCollectionIdSMS';
	
	public static function varUtilidades(){
		return array(	 'Mostrar Hilos' => 'showThreads0', 
						'Obtener Cantidad de Sentencias' => 'getAmountSentences0', 
						'Vaciar Cola de Sentendcias' => 'emptyQueueSentences0', 
						'Detener Demonios' => 'detenerDemonios0', 
						'Iniciar Demonios' => 'iniciarDemonios0', 
						'Obtener Arreglo de Id SMS' => 'getCollectionIdSMS0', 
						'Vaciar Arreglo de Id SMS' => 'cleanCollectionIdSMS0', 
						'Establecer Cantidad de Hilos' => 'setThreads1', 
						'Control Reenvio SMS' => 'controlReenvioSMS2', 
						'Control Reenvio Query' => 'controlReenvioQuery2'
					);
	}
	
	

	public static function justMethod($metodo){//mejorar nombre
		return array('method' => "$metodo");
	}

	public static function setThreads($amount){
		return array('method' => 'setThreads', 
					 'amount' => "$amount"
					);
	}

	public static function addKannel($idCliente, $idOperadora){
		return array('method' => 'addKannel', 
					 'idCliente' => "$idCliente", 
					 'idOperadora' => "$idOperadora"
					);
	}

	public static function removeKannel($idCliente, $idOperadora){
		return array('method' => 'removeKannel', 
					 'idCliente' => "$idCliente", 
					 'idOperadora' => "$idOperadora"
					);
	}

	public static function controlReenvioQuery($estatus){
		return array('method' => 'controlReenvioQuery', 
					 'estatus' => "$estatus", 
					);
	}

	public static function addRouto($idCliente, $idOperadora){
		return array('method' => 'addRouto', 
					 'idCliente' => "$idCliente", 
					 'idOperadora' => "$idOperadora"
					);
	}

	public static function removeRouto($idCliente, $idOperadora){
		return array('method' => 'removeRouto', 
					 'idCliente' => "$idCliente", 
					 'idOperadora' => "$idOperadora"
					);
	}

	public static function controlReenvioSMS($estatus){
		return array('method' => 'controlReenvioSMS', 
					 'estatus' => "$estatus"
					);
	}
	
	const xpathKey = 'config/key';
	const xpathKBA = '.';
	const nmbAttributo = 'name';
	const posValor = 0;
	
	const xpathCola = 'colaID/cola';
	const nmbAttributoCola = 'idCliente';
	
	
	const idOpeDigitel = '1';
	const idOpeMovistar = '2';
	
	public static function arrayOperadora(){
		return array('digitel' => '1', 
					 'movistar' => '2',
					 'movilnet' => '3'

					);
	}
		
	const xpathKeyByAtt = '//key[@name="#"]';	
	const xpathCodigo = '/respuesta/codigo';
	const xpathDescripcion = '/respuesta/descripcion';
	const xpathDetalle = '/respuesta/detalle';
}

?>
