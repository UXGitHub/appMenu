<?php

$app->post('/getCompany', function() use ($app) {

	$db = new DbHandler();

    $session = $db->getSession();

	$companyId = $session['companyid'];

	$company = $db->getOneRecord("SELECT EMPRESA.NOME AS NAME, CNPJ AS CNPJ, 
		LOGRADOURO AS ADDRESS, CEP AS CEP, MUNICIPIO.NOME AS CITY, ESTADO.NOME AS STATE, 
		PAIS.NOME AS COUNTRY, TEL1 AS PHONE1, TEL2 AS PHONE2 
		FROM EMPRESA 
		JOIN PAIS ON EMPRESA.PAIS_IDPAIS = PAIS.IDPAIS
		JOIN ESTADO ON EMPRESA.ESTADO_IDESTADO = ESTADO.IDESTADO
		JOIN MUNICIPIO ON EMPRESA.MUNICIPIO_IDMUNICIPIO = MUNICIPIO.IDMUNICIPIO
		WHERE IDEMPRESA = '$companyId'");

	echoResponse(200, $company);
});

$app->post('/saveCompany', function() use ($app) {

	$db = new DbHandler();
    $session = $db->getSession();
    $companyId = $session['companyid'];

	$params = json_decode($app->request->getBody());

	$name = $params->company->NAME;
	$cnpj = $params->company->CNPJ;
	$cityId = $params->company->CITY_ID;
	$stateId = $params->company->STATE_ID;
	$countryId = $params->company->COUNTRY_ID;
	$cep = (!isset($params->company->CEP)) ? NULL : $params->company->CEP;
	$address = (!isset($params->company->ADDRESS)) ? NULL : $params->company->ADDRESS;
	$phone1 = (!isset($params->company->PHONE1)) ? NULL : $params->company->PHONE1;
	$phone2 = (!isset($params->company->PHONE2)) ? NULL : $params->company->PHONE2;

	$existCompany = $db->getOneRecord("SELECT NOME FROM EMPRESA WHERE CNPJ = '$cnpj' AND IDEMPRESA = '$companyId'");

	if ($existCompany) {

		$sql = "UPDATE EMPRESA SET NOME = '$name', LOGRADOURO = '$address', CEP = '$cep', 
				MUNICIPIO_IDMUNICIPIO = '$cityId', ESTADO_IDESTADO = '$stateId', 
				PAIS_IDPAIS = '$countryId', TEL1 = '$phone1', TEL2 = '$phone2'
				WHERE IDEMPRESA = '$companyId' AND CNPJ = '$cnpj'";

		$db->updateTable($sql);

		$response["status"] = "success";
        $response["message"] = "Empresa atualizada";
        echoResponse(200, $response);

	} else {

		$response["status"] = "error";
        $response["message"] = "CNPJ Incorreto";
        echoResponse(201, $response);
	}
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