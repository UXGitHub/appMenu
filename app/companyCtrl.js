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
        return state.IDPAIS === $scope.myCountry.IDPAIS;        
    };

    $scope.filterCities = function(city) {
        return city.IDESTADO === $scope.myState.IDESTADO;
    };

    function setCountry() {
        var currentCountry = $scope.countries.filter(function(country) {
            return country.NOME === $scope.company.COUNTRY
        });

        $scope.myCountry = currentCountry[0];
    }

    function setState() {
        var currentState = $scope.states.filter(function(state) {
            return state.NOME === $scope.company.STATE
        });

        $scope.myState = currentState[0];
    }

    function setCity() {
        var currentCity = $scope.cities.filter(function(city) {
            return city.NOME === $scope.company.CITY
        });

        $scope.myCity = currentCity[0];
    }


    $scope.saveCompany = function(company) {

        company.COUNTRY = $scope.myCountry.NOME;
        company.COUNTRY_ID = $scope.myCountry.IDPAIS;

        company.STATE = $scope.myState.NOME;
        company.STATE_ID = $scope.myState.IDESTADO;

        company.CITY = $scope.myCity.NOME;
        company.CITY_ID = $scope.myCity.IDMUNICIPIO;

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