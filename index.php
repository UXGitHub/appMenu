<!DOCTYPE html>

<html lang="pt-br" ng-app="myApp">

  <head>

    <meta charset="utf-8">
    <title>AppMenu</title>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' >
    <link href="assets/plugins/font-awesome-4.3.0/css/font-awesome.min.css" rel="stylesheet" />
    <link href="assets/plugins/Waves-0.7.2/dist/waves.min.css" rel="stylesheet" />
    <link href="css/style.css" rel="stylesheet">

  </head>

  <body>
    
    <section>
      
      <header id="header" class="header">

        <div id="header-logo" class="header-logo">

          <a href="#" class="waves-effect waves-button waves-classic">
            <span>Modern</span>
          </a>

        </div>

        <div id="header-menu" class="header-menu">

          <a href="#" class="waves-effect waves-button waves-classic">
            <i class="fa fa-bars"></i>
          </a>

        </div>

      </header>

      <nav>
        
      </nav>

      <main data-ng-view ></main>

    </section>

  </body>

  <script src="js/jquery.js"></script>
  <script src="js/angular.min.js"></script>
  <script src="js/angular-masonry.js"></script>
  <script src="js/angular-route.min.js"></script>
  <script src="js/angular-animate.min.js"></script>
  <!--
  <script src='js/masonry.min.js'></script>
  <script src="js/toaster.js"></script>
  <script src="js/environment.js"></script>
  -->

  <!-- PLUGINS -->
  <script src="assets/plugins/Waves-0.7.2/dist/waves.min.js"></script>

  <!-- APP -->
  <script src="app/app.js"></script>
  <script src="app/data.js"></script>
  <script src="app/directives.js"></script>

  <script src="app/authCtrl.js"></script>
  <script src="app/companyCtrl.js"></script>
  <script src="app/catalogCtrl.js"></script>
  <script src="app/categoriesCtrl.js"></script>
  <script src="app/productCtrl.js"></script>

</html>