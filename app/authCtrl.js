app.controller('authCtrl', function ($scope, $rootScope, $routeParams, $location, $http, Data) {
    //initially set those objects to null to avoid undefined error
    $scope.login = {};
    $scope.signup = {};
    $scope.doLogin = function (customer) {
        Data.post('login', {
            customer: customer
        }).then(function (results) {
            Data.toast(results);
            if (results.status == "success") {
                $location.path('dashboard');
            }
        });
    };
    $scope.signup = {cnpj:'',nameBusiness:'',name:'',email:'',password:'',password2:''};
    $scope.signUp = function (customer) {
        
        Data.post('signUp', {
            customer: customer
        }).then(function (results) {
            Data.toast(results);
            if (results.status == "success") {
                $location.path('dashboard');
            }
        });
    };
    $scope.logout = function () {
        Data.get('logout').then(function (results) {
            Data.toast(results);
            $location.path('login');
        });
    };
    $scope.changepassword = {oldpassword:'',password:'',password2:''};
    $scope.openViewChangePassword = function() {
        $location.path('changePassword');
    };
    $scope.changePassword = function (objPassword) {
        Data.post('changePassword', {
            password: objPassword
        }).then(function(results) {
            Data.toast(results);
            if (results.status == "success") {
                $location.path('dashboard');
            }
        });
    };

    $scope.business = {name: '', cnpj: '', address: '', cep: '', city: '', state: '', country: ''};
    $scope.openEditBusiness = function() {
        $location.path('editBusiness');
    };
});