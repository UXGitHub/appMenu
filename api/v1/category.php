<?php

$app->post('/getCategories', function() use ($app) {

	$categories = getCategories();

	if (empty($categories)) {

		$categories = array();
	}

	echoResponse(200, $categories);
});

$app->post('/saveCategory', function() use ($app) {

	$db = new DbHandler();

    $session = $db->getSession();

    $params = json_decode($app->request->getBody());

	$companyId = $session['companyid'];

	$category = array(
		'nome' => $params->category->name,
		//'empresa_idempresa' => $companyId,
	);

	$tableName = 'categoria';
	// empresa_idempresa como segundo parâmetro e descometar linha acima
    $columnNames = array('nome');
    $newcategoryRowId = $db->insertIntoTable($category, $columnNames, $tableName);

	$response["status"] = "success";
    $response["message"] = "Categoria cadastrada com sucesso";

    echoResponse(200, $response);
});

$app->post('/removeCategory', function() use ($app) {

	$params = json_decode($app->request->getBody(), false);

	$db = new DbHandler();

	// $session = $db->getSession();

	// $companyId = $session['companyid'];

	$categoryId = $params->category->idcategoria;

	/**
	 * Adicionar cláusula where empresa_idempresa = '$companyId'
	 * Descomentar linhas acima
	 */
	$sql = "delete from categoria where idcategoria = '$categoryId'";

	$db->delete($sql);

	$response["status"] = "success";
    $response["message"] = "Categoria excluída com sucesso";
    $response["categories"] = getCategories();

	echoResponse(200, $response);

});

function getCategories() {

	$db = new DbHandler();

    $session = $db->getSession();

	$companyId = $session['companyid'];

	/**
	 * Adicionar cláusula where após arrumar modelagem no banco
	 * where empresa_idempresa = '$companyId'
	 */
	return $db->executeQuery("select idcategoria, nome from categoria order by nome");
}