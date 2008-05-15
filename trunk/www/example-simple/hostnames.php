<?php

require_once('../_include.php');

require_once((isset($SIMPLESAML_INCPREFIX)?$SIMPLESAML_INCPREFIX:'') . 'SimpleSAML/Utilities.php');
require_once((isset($SIMPLESAML_INCPREFIX)?$SIMPLESAML_INCPREFIX:'') . 'SimpleSAML/Session.php');
require_once((isset($SIMPLESAML_INCPREFIX)?$SIMPLESAML_INCPREFIX:'') . 'SimpleSAML/Metadata/MetaDataStorageHandler.php');
require_once((isset($SIMPLESAML_INCPREFIX)?$SIMPLESAML_INCPREFIX:'') . 'SimpleSAML/XML/SAML20/AuthnRequest.php');
require_once((isset($SIMPLESAML_INCPREFIX)?$SIMPLESAML_INCPREFIX:'') . 'SimpleSAML/XML/SAML20/AuthnResponse.php');
require_once((isset($SIMPLESAML_INCPREFIX)?$SIMPLESAML_INCPREFIX:'') . 'SimpleSAML/Bindings/SAML20/HTTPRedirect.php');
require_once((isset($SIMPLESAML_INCPREFIX)?$SIMPLESAML_INCPREFIX:'') . 'SimpleSAML/Bindings/SAML20/HTTPPost.php');
require_once((isset($SIMPLESAML_INCPREFIX)?$SIMPLESAML_INCPREFIX:'') . 'SimpleSAML/XHTML/Template.php');

/* Load simpleSAMLphp, configuration */
$config = SimpleSAML_Configuration::getInstance();
$session = SimpleSAML_Session::getInstance();

/* Check if valid local session exists.. */
if (!isset($session) || !$session->isValid('login-admin') ) {
	SimpleSAML_Utilities::redirect('/' . $config->getBaseURL() . 'auth/login-admin.php',
		array('RelayState' => SimpleSAML_Utilities::selfURL())
	);
}





$attributes = array();


$attributes['HTTP_HOST'] = array($_SERVER['HTTP_HOST']);
$attributes['HTTPS'] = array($_SERVER['HTTPS']);
$attributes['SERVER_PROTOCOL'] = array($_SERVER['SERVER_PROTOCOL']);
$attributes['SERVER_PORT'] = array($_SERVER['SERVER_PORT']);

$attributes['Utilities_getSelfHost()'] = array(SimpleSAML_Utilities::getSelfHost());
$attributes['Utilities_getSelfProtocol()'] = array(SimpleSAML_Utilities::getSelfProtocol());
$attributes['Utilities_selfURLhost()'] = array(SimpleSAML_Utilities::selfURLhost());
$attributes['Utilities_selfURLNoQuery()'] = array(SimpleSAML_Utilities::selfURLNoQuery());
$attributes['Utilities_getScriptName()'] = array(SimpleSAML_Utilities::getScriptName());
$attributes['Utilities_getSelfHostWithPath()'] = array(SimpleSAML_Utilities::getSelfHostWithPath());
$attributes['Utilities_getFirstPathElement()'] = array(SimpleSAML_Utilities::getFirstPathElement());
$attributes['Utilities_selfURL()'] = array(SimpleSAML_Utilities::selfURL());
$attributes['Utilities_getRequestURI()'] = array(SimpleSAML_Utilities::getRequestURI());





$et = new SimpleSAML_XHTML_Template($config, 'status.php');

$et->data['header'] = 'SimpleSAMLphp Diagnostics';
$et->data['remaining'] = 'na';
$et->data['attributes'] = $attributes;
$et->data['valid'] = 'na';
$et->data['logout'] = null;

$et->show();


?>