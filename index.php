<!DOCTYPE html>
<!--[if IE 8 ]>
<html class="no-js ie8 loading" lang="en-US" ng-app="myApp">
<![endif]-->
<!--[if IE 9 ]>
<html class="no-js ie9 loading" lang="en-US" ng-app="myApp">
<![endif]-->
<!--[if gt IE 8]><!--> 
<html class="loadingx" lang="en-US" ng-app="myApp">
<!--<![endif]-->
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>AppMenu</title>
    <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Cabin%3A400%2C500%2C700&#038;ver=4.2.2' type='text/css' media='all' />
    <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Merriweather%3A400%2C300&#038;ver=4.2.2' type='text/css' media='all' />
    <link href="css/style.css" rel="stylesheet">
    <link href="css/toaster.css" rel="stylesheet">
  </head>
  <body class="page">

    <div id="page" class="hfeed site">

      <header id="masthead" class="site-header" role="banner">

        <div class="site-branding">

          <h1 class="site-title">
            <a href="#" title="AppMenu">APPMENU</a>
          </h1>
        
        </div>
        
        <div class="site-canvas">
          <a heref="#" class="site-navigation-btn"><span>Menu</span></a>
        </div>

      </header>

      <nav id="canvas" class="canvas-inner">
        <nav id="site-navigation" class="main-navigation" role="navigation">
          <div class="menu-main-menu-container">
            <ul id="menu-main-menu" class="menu">
              <li id="dashboard" class="menu-item">
                <a href="#/dashboard">DASHBOARD</a>
              </li>
              <li id="changePassword" class="menu-item">
                <a href="#/alterar-senha">ALTERAR SENHA</a>
              </li>
              <li id="company" class="menu-item">
                <a href="#/empresa">EMPRESA</a>
              </li>
              <li id="catalog" class="menu-item">
                <a href="#/catalogo">CATÁLOGO</a>
              </li>
              <li id="catalog" class="menu-item">
                <a href="#/categorias">CATEGORIAS</a>
              </li>
              <li id="catalog" class="menu-item">
                <a href="#/produtos">PRODUTOS</a>
              </li>
              <li id="logout" class="menu-item">
                <a href="#/logout">SAIR</a>
              </li>
            </ul>
          </div>
        </nav>
        <div class="site-canvas">
          <a heref="#" class="site-navigation-btn">
            <span>Menu</span>
          </a>
        </div>
      </nav>

    </div>

    <div data-ng-view id="content" class="site-content"></div>

    <div class="site-overlay"></div>
    
    <a class="scrollup" href="#">
      <i class="fa fa-caret-up"></i>
    </a>

  </body>

  <toaster-container toaster-options="{'time-out': 3000}"></toaster-container>

  <!-- LIBS -->
  
  <script src="js/jquery.js"></script>
  <script src="js/angular.min.js"></script>
  <script src="js/angular-masonry.js"></script>
  <script src="js/angular-route.min.js"></script>
  <script src="js/angular-animate.min.js"></script>
  <script src='js/masonry.min.js'></script>
  <script src="js/toaster.js"></script>
  <script src="js/environment.js"></script>
  
  <script src="app/app.js"></script>
  <script src="app/data.js"></script>
  <script src="app/directives.js"></script>
  
  <!-- CONTROLLERS -->
  
  <script src="app/authCtrl.js"></script>
  <script src="app/companyCtrl.js"></script>
  <script src="app/catalogCtrl.js"></script>
  <script src="app/categoriesCtrl.js"></script>
  <script src="app/productCtrl.js"></script>

</html>