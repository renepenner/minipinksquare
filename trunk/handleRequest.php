<?php
include 'config.php';

$functions = array(
	'getContentClass'		=> array('class' => 'Data',		'method' => 'getContentClass',			'params' => array("id")),
	'getAllContentClass'	=> array('class' =>	'Data',		'method' => 'getAllContentClass',		'params' => array()),
	'addContentClass'		=> array('class' => 'Data',		'method' => 'addContentClass',			'params' => array('name')),
	'delContentClass'		=> array('class' => 'Data',		'method' => 'delContentClass',			'params' => array('id'))
);

$key = $_REQUEST['method'];
try {  
	if( array_key_exists( $key, $functions)) {
		
		$function	= $functions[$key];
		
		$obj		= new $function['class'];
	    $m			= array(&$obj, $function['method']);
			      
	    // checkt ob alle benötigen Parameter mitgeliefert werden
	    foreach($function['params'] as $parm){
	    	if(!isset($_REQUEST[$parm])){
	    		throw new Exception("Missing Parameter $parm for $key");
	    	}
	    	$params .= ", '".$_REQUEST[$parm]."'";
	    }
		
	    // checkt ob es die Methode in der Klasse gibt
	    if(!method_exists($obj, $function['method'])){
	    	throw new Exception("missing method ".$function['method']." in class ".$function['class']."");	
	    }
	    	   
	    eval('$result = call_user_func($m'.$params.');');

    	echo json_encode($result->toArray());
	    
	}else{
		throw new Exception('call a undefind function');
	}
}
catch (Exception $e )
{    	
	 echo json_encode(array('error' => true, 'msg' => $e->getMessage()));
}
?>