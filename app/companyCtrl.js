app.controller('companyCtrl', function ($scope, Data, $q, $location) {

    $scope.initWindow = function() {
        var promises = [];

        promises.push(Data.post('getCompany'));
        promises.push(Data.post('getCountries'));
        promises.push(Data.post('getStates'));
        promises.push(Data.post('getCities'));

        $q.all(promises).then(function(callback) {

            $scope.company = callback[0];
            $scope.countries = callback[1];
            $scope.states = callback[2];
            $scope.cities = callback[3];
            
            setCountry();
            setState();
            setCity();

        });
    };

    $scope.initWindow();

    $scope.cleanOptions = function() {
        $scope.myState = {};
        $scope.myCity = {};
    };

    $scope.cleanCity = function() {
        $scope.myCity = {};
    };

    $scope.filterStates = function(state) {
        return state.idpais === $scope.myCountry.idpais;        
    };

    $scope.filterCities = function(city) {
        return city.idestado === $scope.myState.idestado;
    };

    function setCountry() {
        var currentCountry = $scope.countries.filter(function(country) {
            return country.nome === $scope.company.country
        });

        $scope.myCountry = currentCountry[0];
    }

    function setState() {
        var currentState = $scope.states.filter(function(state) {
            return state.nome === $scope.company.state
        });

        $scope.myState = currentState[0];
    }

    function setCity() {
        var currentCity = $scope.cities.filter(function(city) {
            return city.nome === $scope.company.city
        });

        $scope.myCity = currentCity[0];
    }


    $scope.saveCompany = function(company) {

        company.country = $scope.myCountry.nome;
        company.country_id = $scope.myCountry.idpais;

        company.state = $scope.myState.nome;
        company.state_id = $scope.myState.idestado;

        company.city = $scope.myCity.nome;
        company.city_id = $scope.myCity.idmunicipio;

        console.log(company);

        Data.post('/saveCompany', {
            company: company
        }).then(function(results) {
            Data.toast(results);
            if (results.status == "success") {
                $location.path('dashboard');
            }
        });
    };

});