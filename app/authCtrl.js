app.controller('authCtrl', function ($scope, $location, Data, $q) {
    //initially set those objects to null to avoid undefined error
    $scope.login = {};
    $scope.signup = {cnpj:'',companyName:'', country: '', state: '', city: '', name:'',email:'',password:'',password2:''};
    $scope.changepassword = {oldpassword:'',password:'',password2:''};
    
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

    $scope.openViewEditCompany = function() {
        $location.path('editCompany');
    };

    $scope.initView = function() {
        var promises = [];

        promises.push(Data.post('getCountries'));
        promises.push(Data.post('getStates'));
        promises.push(Data.post('getCities'));

        $q.all(promises).then(function(callback) {

            $scope.countries = callback[0];
            $scope.states = callback[1];
            $scope.cities = callback[2];

        });
    };

    $scope.initViewSignUp = function() {
        $scope.initView();
        $location.path('signup');
    };

    $scope.cleanOptions = function() {
        $scope.signup.state = {};
        $scope.signup.city = {};
    };

    $scope.cleanCity = function() {
        $scope.signup.city = {};
    };

    $scope.filterStates = function(state) {
        if ($scope.signup.country) {
            return state.IDPAIS === $scope.signup.country.IDPAIS;
        }
    };

    $scope.filterCities = function(city) {
        if ($scope.signup.state) {
            return city.IDESTADO === $scope.signup.state.IDESTADO;
        }
    };

});