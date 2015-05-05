<?php

$app->post('/getCatalogs', function() use ($app) {

	$db = new DbHandler();

    $session = $db->getSession();

	$companyId = $session['companyid'];

	$catalogs = $db->executeQuery("SELECT IDCATALOGO, NOME, DESCRICAO FROM CATALOGO
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

$app->post('/removeCatalogs', function() use ($app) {

	$catalogs = json_decode($app->request->getBody());
	$db = new DbHandler();
    $session = $db->getSession();
	$companyId = $session['companyid'];

	foreach ($catalogs->catalogs as $catalog) {
		// var_dump($catalog);
		$catalogId = $catalog->IDCATALOGO;
		
		$sql = "DELETE FROM CATALOGO WHERE EMPRESA_IDEMPRESA = '$companyId' AND IDCATALOGO = '$catalogId'";

		$db->delete($sql);
	}

});