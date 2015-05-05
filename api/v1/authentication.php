<?php 
$app->get('/session', function() {

    $db = new DbHandler();

    $session = $db->getSession();

    if (!isset($session['userid'])) {

        $session = array();

    }
    
    echoResponse(200, $session);
});

$app->post('/login', function() use ($app) {

    $params = json_decode($app->request->getBody());
    $response = array();
    $db = new DbHandler();

    $password = $params->customer->password;
    $email = $params->customer->email;

    $user = $db->getOneRecord("SELECT IDUSUARIO, NOME, SENHA, EMAIL, EMPRESA_IDEMPRESA FROM usuario WHERE EMAIL = '$email'");

    if ($user) {

        if (passwordHash::check_password($user['SENHA'], $password)) {
            
            $db->initSession();

            $response['status']    = "success";
            $response['message']   = 'Logged in successfully.';
            $response['name']      = $_SESSION['name']      = $user['NOME'];
            $response['userid']    = $_SESSION['userid']    = $user['IDUSUARIO'];
            $response['email']     = $_SESSION['email']     = $user['EMAIL'];
            $response['companyid'] = $_SESSION['companyid'] = $user['EMPRESA_IDEMPRESA'];

        } else {

            $response['status'] = "error";
            $response['message'] = 'Login failed. Incorrect credentials';

        }

    } else {

        $response['status'] = "error";
        $response['message'] = 'No such user is registered';

    }

    echoResponse(200, $response);
});

$app->post('/signUp', function() use ($app) {
    
    $response = array();

    $requestParams = json_decode($app->request->getBody());

    $email = $requestParams->customer->email;
    $cnpj = $requestParams->customer->cnpj;

    $company = array(
        'NOME' => $requestParams->customer->companyName,
        'CNPJ' => $cnpj,
        'MUNICIPIO_IDMUNICIPIO' => $requestParams->customer->city->IDMUNICIPIO,
        'ESTADO_IDESTADO' => $requestParams->customer->state->IDESTADO,
        'PAIS_IDPAIS' => $requestParams->customer->country->IDPAIS,
    );

    $user = array(
        'NOME' => $requestParams->customer->name,
        'EMAIL' => $email,
        'SENHA' => passwordHash::hash($requestParams->customer->password),
        'EMPRESA_IDEMPRESA'=> ''
    );

    $db = new DbHandler();

    $isUserExists = $db->getOneRecord("SELECT NOME FROM usuario WHERE EMAIL = '$email'");
    $isBusinessExists = $db->getOneRecord("SELECT IDEMPRESA FROM EMPRESA WHERE CNPJ = '$cnpj'");

    if (!$isBusinessExists && !$isUserExists) {

        $tableName = 'EMPRESA';
        $columnNames = array('NOME', 'CNPJ', 'MUNICIPIO_IDMUNICIPIO', 'ESTADO_IDESTADO', 'PAIS_IDPAIS');
        $newCompanyRowId = $db->insertIntoTable($company, $columnNames, $tableName);

        $newBusiness = $db->getOneRecord("SELECT IDEMPRESA FROM EMPRESA WHERE CNPJ = '$cnpj'");

        $user['EMPRESA_IDEMPRESA'] = $newBusiness['IDEMPRESA'];
        $tableName = 'USUARIO';
        $columnNames = array('NOME', 'EMAIL', 'SENHA', 'EMPRESA_IDEMPRESA');
        $newUserRowId = $db->insertIntoTable($user, $columnNames, $tableName);

        $response["status"] = "success";
        $response["message"] = "Cadastro realizado";
        echoResponse(200, $response);

    } else if ($isBusinessExists) {

        $response["status"] = "error";
        $response["message"] = "Empresa já cadastrada";
        echoResponse(201, $response);

    } else if ($isUserExists) {

        $response["status"] = "error";
        $response["message"] = "Responsável já cadastrado";
        echoResponse(201, $response);

    } else {

        $response["status"] = "error";
        $response["message"] = "Empresa e responsável já cadastrados";
        echoResponse(201, $response);

    }
});

$app->get('/logout', function() {

    $db = new DbHandler();

    $session = $db->destroySession();
    
    $response["status"] = "info";
    $response["message"] = "Logged out successfully";

    echoResponse(200, $response);
});

$app->post('/changePassword', function() use ($app) {

    $db = new DbHandler();
    $response = array();

    $requestParams = json_decode($app->request->getBody());
    $session = $db->getSession();

    $userid = $session['userid'];

    $oldPassword = $requestParams->password->oldpassword;
    $newPassword = $requestParams->password->password;

    $currentUser = $db->getOneRecord("SELECT NOME, SENHA FROM usuario WHERE IDUSUARIO = '$userid'");

    if (passwordHash::check_password($currentUser['SENHA'], $oldPassword)) {
        
        $newPasswordHash = passwordHash::hash($newPassword);

        $db->updateTable("UPDATE usuario SET SENHA = '$newPasswordHash' WHERE IDUSUARIO = '$userid'");

        $response["status"] = "success";
        $response["message"] = "Senha alterada";
        echoResponse(200, $response);

    } else {

        $response["status"] = "error";
        $response["message"] = "Senha atual incorreta";
        echoResponse(201, $response);

    }
});

?>