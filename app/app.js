var app = angular.module('myApp', ['ngRoute', 'ngAnimate', 'toaster', 'wu.masonry']);

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
                controller: 'authCtrl'
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
            .when('/alterar-senha', {
                title: 'ChangePassword',
                templateUrl: 'partials/change-password.html',
                controller: 'authCtrl',
                role: '0'
            })
            .when('/empresa', {
                title: 'Company',
                templateUrl: 'partials/company.html',
                controller: 'companyCtrl',
                role: '0'
            })
            .when('/catalogo', {
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
            .when('/categorias', {
                title: 'Categories',
                templateUrl: 'partials/categories.html',
                controller: 'categoriesCtrl',
                role: '0'
            })
            .when('/adicionar-categorias', {
                title: 'AddCategories',
                templateUrl: 'partials/addCategories.html',
                controller: 'categoriesCtrl',
                role: '0'
            })
            .when('/produtos', {
                title: 'Products',
                templateUrl: 'partials/products.html',
                controller: 'productCtrl',
                role: '0'
            })
            .when('/adicionar-produtos', {
                title: 'AddProducts',
                templateUrl: 'partials/addProducts.html',
                controller: 'productCtrl',
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

                    if (next.$$route.originalPath && 
                        next.$$route.originalPath !== '/' && 
                        next.$$route.originalPath !== '/login') {

                        $location.path(next.$$route.originalPath);
                        
                    } else {

                        $location.path('/dashboard');
                    }

                    if(next.$$route.originalPath && 
                        next.$$route.originalPath == '/logout') {

                        Data.get('logout').then(function (results) {
                            Data.toast(results);
                            $location.path('login');
                        });

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