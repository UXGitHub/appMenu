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

$app->post('/saveBusiness', function() use ($app) {
	$db = new DbHandler();
    $session = $db->getSession();
    $businessId = $session['businessid'];

	$params = json_decode($app->request->getBody());
	$name = $params->business->NAME;
	$cnpj = $params->business->CNPJ;
	$address = ifEmptySet($params->business->ADDRESS);
	$cep = ifEmptySet($params->business->CEP);
	$cityId = ifEmptySet($params->business->CITY_ID);
	$stateId = ifEmptySet($params->business->STATE_ID);
	$countryId = ifEmptySet($params->business->COUNTRY_ID);
	$phone1 = ifEmptySet($params->business->PHONE1);
	$phone2 = ifEmptySet($params->business->PHONE2);


	$existBusiness = $db->getOneRecord("SELECT NOME FROM EMPRESA WHERE CNPJ='$cnpj' AND IDEMPRESA = '$businessId'");

	if ($existBusiness) {
		var_dump($cityId); die;

		$sql = "UPDATE EMPRESA SET NOME = '$name', LOGRADOURO = '$address', CEP = '$cep', 
				MUNICIPIO_IDMUNICIPIO = '$cityId', ESTADO_IDESTADO = '$stateId', 
				PAIS_IDPAIS = '$countryId', TEL1 = '$phone1', TEL2 = '$phone2'
				WHERE IDEMPRESA = '$businessId' AND CNPJ = '$cnpj'";

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

function ifEmptySet($string) {
	if (empty($string)) {
		$string = null;
	}

	return $string;
}