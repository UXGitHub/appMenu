<?php

$app->post('/getCompany', function() use ($app) {

	$db = new DbHandler();

    $session = $db->getSession();

	$companyId = $session['companyid'];

	$company = $db->getOneRecord("select empresa.nome as name, cnpj as cnpj, 
		logradouro as address, cep as cep, municipio.nome as city, estado.nome as state, 
		pais.nome as country, tel1 as phone1, tel2 as phone2 
		from empresa 
		join pais on empresa.pais_idpais = pais.idpais
		join estado on empresa.estado_idestado = estado.idestado
		join municipio on empresa.municipio_idmunicipio = municipio.idmunicipio
		where idempresa = '$companyId'");

	echoResponse(200, $company);
});

$app->post('/saveCompany', function() use ($app) {

	$db = new DbHandler();
    $session = $db->getSession();
    $companyId = $session['companyid'];

	$params = json_decode($app->request->getBody());

	$name = $params->company->name;
	$cnpj = $params->company->cnpj;
	$cityId = $params->company->city_id;
	$stateId = $params->company->state_id;
	$countryId = $params->company->country_id;
	$cep = (!isset($params->company->cep)) ? NULL : $params->company->cep;
	$address = (!isset($params->company->address)) ? NULL : $params->company->address;
	$phone1 = (!isset($params->company->phone1)) ? NULL : $params->company->phone1;
	$phone2 = (!isset($params->company->phone2)) ? NULL : $params->company->phone2;

	$existCompany = $db->getOneRecord("select nome from empresa where cnpj = '$cnpj' and idempresa = '$companyId'");

	if ($existCompany) {

		$sql = "update empresa set nome = '$name', logradouro = '$address', cep = '$cep', 
				municipio_idmunicipio = '$cityId', estado_idestado = '$stateId', 
				pais_idpais = '$countryId', tel1 = '$phone1', tel2 = '$phone2'
				where idempresa = '$companyId' and cnpj = '$cnpj'";

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

	$countries = $db->executeQuery("select nome, sigla, idpais from pais");

	echoResponse(200, $countries);
});

$app->post('/getStates', function() {
	$db = new DbHandler();

	$states = $db->executeQuery("select nome, sigla, idestado, pais_idpais as idpais from estado");
	echoResponse(200, $states);
});

$app->post('/getCities', function() {
	$db = new DbHandler();

	$states = $db->executeQuery("select nome, sigla, idmunicipio, estado_idestado as idestado from municipio");

	echoResponse(200, $states);
});