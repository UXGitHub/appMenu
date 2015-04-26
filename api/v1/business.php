<?php
$app->post('/getBusiness', function() use ($app) {
	$db = new DbHandler();
    $session = $db->getSession();

	$userId = $session['userid'];

	$user = $db->getOneRecord("SELECT EMPRESA_IDEMPRESA AS IDEMPRESA FROM USUARIO WHERE IDUSUARIO='$userId'");
	$businessId = $user['IDEMPRESA'];
	$business = $db->getOneRecord("SELECT EMPRESA.NOME AS NAME, CNPJ AS CNPJ, 
		LOGRADOURO AS ADDRESS, CEP AS CEP, MUNICIPIO.NOME AS CITY, ESTADO.NOME AS STATE, 
		PAIS.NOME AS COUNTRY, TEL1 AS PHONE1, TEL2 AS PHONE2 
		FROM EMPRESA 
		JOIN PAIS ON EMPRESA.PAIS_IDPAIS = PAIS.IDPAIS
		JOIN ESTADO ON EMPRESA.ESTADO_IDESTADO = ESTADO.IDESTADO
		JOIN MUNICIPIO ON EMPRESA.MUNICIPIO_IDMUNICIPIO = MUNICIPIO.IDMUNICIPIO
		WHERE IDEMPRESA='$businessId'");

	echoResponse(200, $business);
});

$app->post('/getCountries', function() {
	$db = new DbHandler();

	$countries = $db->executeQuery("SELECT NOME, SIGLA, IDPAIS FROM PAIS");

	echoResponse(200, $countries);
});

$app->post('/getStates', function() {
	$db = new DbHandler();

	$states = $db->executeQuery("SELECT NOME, SIGLA, IDESTADO, PAIS_IDPAIS AS IDPAIS FROM ESTADO");

	echoResponse(200, $states);
});

$app->post('/getCities', function() {
	$db = new DbHandler();

	$states = $db->executeQuery("SELECT NOME, SIGLA, IDMUNICIPIO, ESTADO_IDESTADO AS IDESTADO FROM MUNICIPIO");

	echoResponse(200, $states);
});