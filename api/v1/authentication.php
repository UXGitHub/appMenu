<?php 
$app->get('/session', function() {
    $db = new DbHandler();
    $session = $db->getSession();

    if (!isset($session['userid'])) {

        $session["userid"] = '';
        $session["email"] = '';
        $session["name"] = 'Convidado';
    }
    
    echoResponse(200, $session);
});

$app->post('/login', function() use ($app) {
    require_once 'passwordHash.php';
    $r = json_decode($app->request->getBody());
    verifyRequiredParams(array('email', 'password'),$r->customer);
    $response = array();
    $db = new DbHandler();
    $password = $r->customer->password;
    $email = $r->customer->email;
    $user = $db->getOneRecord("select idusuario, nome, senha, email, empresa_idempresa from usuario where email='$email'");
    if ($user != NULL) {
        if(passwordHash::check_password($user['senha'],$password)){
        $response['status'] = "success";
        $response['message'] = 'Logged in successfully.';
        $response['name'] = $user['nome'];
        $response['userid'] = $user['idusuario'];
        $response['email'] = $user['email'];
        if (!isset($_SESSION)) {
            session_start();
        }
        $_SESSION['userid'] = $user['idusuario'];
        $_SESSION['email'] = $email;
        $_SESSION['name'] = $user['nome'];
        $_SESSION['businessid'] = $user['empresa_idempresa'];

        } else {
            $response['status'] = "error";
            $response['message'] = 'Login failed. Incorrect credentials';
        }
    }else {
            $response['status'] = "error";
            $response['message'] = 'No such user is registered';
        }
    echoResponse(200, $response);
});
$app->post('/signUp', function() use ($app) {
    
    $response = array();

    $requestParams = json_decode($app->request->getBody());

    $nameBusiness = $requestParams->customer->nameBusiness;
    $cnpj = $requestParams->customer->cnpj;
    $name = $requestParams->customer->name;
    $email = $requestParams->customer->email;
    $password = $requestParams->customer->password;

    require_once 'passwordHash.php';

    $business = array(
        'nome' => $nameBusiness,
        'cnpj' => $cnpj,
        'logradouro' => 'FIXO',
        'cep' => '11111111',
        'municipio_idmunicipio' => 1,
        'estado_idestado' => 1,
        'pais_idpais' => 1
    );

    $user = array(
        'nome' => $name,
        'email' => $email,
        'senha' => passwordHash::hash($password),
        'empresa_idempresa'=> ''
    );

    $db = new DbHandler();

    $isUserExists = $db->getOneRecord("select nome from usuario where email='$email'");
    $isBusinessExists = $db->getOneRecord("select idempresa from empresa where cnpj='$cnpj'");

    if (!$isBusinessExists && !$isUserExists) {

        $tableName = 'empresa';
        $columnNames = array('nome', 'cnpj', 'logradouro', 'cep', 'municipio_idmunicipio', 'estado_idestado', 'pais_idpais');
        $insertBusiness = $db->insertIntoTable($business, $columnNames, $tableName);

        $newBusiness = $db->getOneRecord("select idempresa from empresa where cnpj='$cnpj'");

        $user['empresa_idempresa'] = $newBusiness['idempresa'];
        $tableName = 'usuario';
        $columnNames = array('nome', 'email', 'senha', 'empresa_idempresa');
        $insertUser = $db->insertIntoTable($user, $columnNames, $tableName);

        $response["status"] = "success";
        $response["message"] = "Cadastro realizado";
        echoResponse(200, $response);

    } else if ($isBusinessExists) {

        $response["status"] = "error";
        $response["message"] = "Empresa já cadastrada";
        echoResponse(201, $response);

    } else if ($isUserExists) {

        $response["status"] = "error";
        $response["message"] = "Responsável já cadastrado.";
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
    
    require_once 'passwordHash.php';

    $db = new DbHandler();
    $response = array();

    $requestParams = json_decode($app->request->getBody());
    $session = $db->getSession();

    $userid = $session['userid'];

    $oldPassword = $requestParams->password->oldpassword;
    $newPassword = $requestParams->password->password;

    $currentUser = $db->getOneRecord("select nome, senha from usuario where idusuario='$userid'");

    if(passwordHash::check_password($currentUser['senha'], $oldPassword)) {
        
        $newPasswordHash = passwordHash::hash($newPassword);

        $db->updateTable("update usuario set senha='$newPasswordHash' where idusuario = '$userid'");

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