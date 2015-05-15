<!DOCTYPE html>
<html lang="en" ng-app="myApp">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>AppMenu</title>
    <link href="css/style.css" rel="stylesheet">
    <link href="css/toaster.css" rel="stylesheet">
  </head>
  <body>

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

    <div class="container">
      <div data-ng-view="" id="ng-view"></div>
    </div>

    <div class="site-overlay"></div>
    
    <a class="scrollup" href="#">
      <i class="fa fa-caret-up"></i>
    </a>

  </body>

  <toaster-container toaster-options="{'time-out': 3000}"></toaster-container>

  <!-- Libs -->
  
  <script src="js/jquery.js"></script>
  <script src="js/angular.min.js"></script>
  <script src="js/angular-route.min.js"></script>
  <script src="js/angular-animate.min.js"></script>
  <script src="js/toaster.js"></script>
  <script src="js/environment.js"></script>
  
  <script src="app/app.js"></script>
  <script src="app/data.js"></script>
  <script src="app/directives.js"></script>
  
  <!-- CONTROLLERS -->
  
  <script src="app/authCtrl.js"></script>
  <script src="app/companyCtrl.js"></script>
  <script src="app/catalogCtrl.js"></script>

</html>