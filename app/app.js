var app = angular.module('myApp', ['ngRoute', 'ngAnimate', 'toaster', 'infinite-scroll']);

app.config(['$routeProvider',
  function ($routeProvider) {
        $routeProvider.
        when('/login', {
            title: 'Login',
            templateUrl: 'partials/login.html',
            controller: 'authCtrl'
        })
            .when('/logout', {
                title: 'Logout',
                templateUrl: 'partials/login.html',
                controller: 'logoutCtrl'
            })
            .when('/signup', {
                title: 'Signup',
                templateUrl: 'partials/signup.html',
                controller: 'authCtrl'
            })
            .when('/dashboard', {
                title: 'Dashboard',
                templateUrl: 'partials/dashboard.html',
                controller: 'authCtrl'
            })
            .when('/changePassword', {
                title: 'ChangePassword',
                templateUrl: 'partials/changepassword.html',
                controller: 'authCtrl',
                role: '0'
            })
            .when('/editCompany', {
                title: 'EditCompany',
                templateUrl: 'partials/editCompany.html',
                controller: 'companyCtrl',
                role: '0'
            })
            .when('/catalog', {
                title: 'Catalog',
                templateUrl: 'partials/catalog.html',
                controller: 'catalogCtrl',
                role: '0'
            })
            .when('/addCatalog', {
                title: 'AddCatalog',
                templateUrl: 'partials/addCatalog.html',
                controller: 'catalogCtrl',
                role: '0'
            })
            .when('/', {
                title: 'Login',
                templateUrl: 'partials/login.html',
                controller: 'authCtrl',
                role: '0'
            })
            .otherwise({
                redirectTo: '/login'
            });
  }])
    .run(function ($rootScope, $location, Data) {
        $rootScope.$on("$routeChangeStart", function (event, next, current) {
            $rootScope.authenticated = false;
            Data.get('session').then(function (results) {
                if (results.userid) {
                    $rootScope.authenticated = true;
                    $rootScope.userid = results.userid;
                    $rootScope.name = results.name;
                    $rootScope.email = results.email;

                    if (next.$$route.originalPath && next.$$route.originalPath !== '/' && next.$$route.originalPath !== '/login') {

                        $location.path(next.$$route.originalPath);
                        
                    } else {

                        $location.path('/dashboard');
                    }

                } else {
                    var nextUrl = next.$$route.originalPath;
                    if (nextUrl == '/signup' || nextUrl == '/login') {

                    } else {
                        $location.path("/login");
                    }
                }
            });
        });
    });