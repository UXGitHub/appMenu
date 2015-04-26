<!DOCTYPE html>
<html lang="en" ng-app="myApp">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>AppMenu</title>
    <!-- <link href="css/style.css" rel="stylesheet"> -->
    <link href="css/toaster.css" rel="stylesheet">
  </head>
  <body>
  <div id="background"></div>
    <div>
      <div class="container">
        <div data-ng-view="" id="ng-view"></div>
      </div>
  </body>
  <toaster-container toaster-options="{'time-out': 3000}"></toaster-container>
  <!-- Libs -->
  <script src="js/angular.min.js"></script>
  <script src="js/angular-route.min.js"></script>
  <script src="js/angular-animate.min.js" ></script>
  <script src="js/toaster.js"></script>
  <script src="app/app.js"></script>
  <script src="app/data.js"></script>
  <script src="app/directives.js"></script>
  <!-- CONTROLLERS -->
  <script src="app/authCtrl.js"></script>
  <script src="app/businessCtrl.js"></script>
</html>