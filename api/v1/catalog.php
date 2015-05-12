<?php

$app->post('/getCatalogs', function() use ($app) {

	$db = new DbHandler();

    $session = $db->getSession();

	$companyId = $session['companyid'];

	$catalogs = $db->executeQuery("SELECT IDCATALOGO, NOME, DESCRICAO FROM catalogo
		WHERE EMPRESA_IDEMPRESA = '$companyId' ORDER BY NOME");

	if (empty($catalogs)) {

		$catalogs = array();
	}

	echoResponse(200, $catalogs);
});

$app->post('/addCatalog', function() use ($app) {

	$db = new DbHandler();

    $session = $db->getSession();

    $params = json_decode($app->request->getBody());
	$companyId = $session['companyid'];

	$catalog = array(
		'NOME' => $params->catalog->name,
		'DESCRICAO' => $params->catalog->description,
		'EMPRESA_IDEMPRESA' => $companyId,
	);

	$tableName = 'CATALOGO';
    $columnNames = array('NOME', 'DESCRICAO', 'EMPRESA_IDEMPRESA');
    $newCatalogRowId = $db->insertIntoTable($catalog, $columnNames, $tableName);

	$response["status"] = "success";
    $response["message"] = "Catálogo cadastrado com sucesso";

    echoResponse(200, $response);
});