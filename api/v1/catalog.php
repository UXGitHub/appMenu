<?php

$app->post('/getCatalogs', function() use ($app) {

	$db = new DbHandler();

    $session = $db->getSession();

	$companyId = $session['companyid'];

	$catalogs = $db->executeQuery("select idcatalogo, nome, descricao from catalogo
		where empresa_idempresa = '$companyId' order by nome");

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
		'nome' => $params->catalog->name,
		'descricao' => $params->catalog->description,
		'empresa_idempresa' => $companyId,
	);

	$tableName = 'catalogo';
    $columnNames = array('nome', 'descricao', 'empresa_idempresa');
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

		$catalogId = $catalog->idcatalogo;
		
		$sql = "delete from catalogo where empresa_idempresa = '$companyId' and idcatalogo = '$catalogId'";

		$db->delete($sql);
	}

});