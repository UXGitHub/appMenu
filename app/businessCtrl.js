app.controller('businessCtrl', function ($scope, Data, $q) {
    
    $scope.initWindow();

    $scope.initWindow = function() {
        var promises = [];

        promises.push(Data.post('getBusiness'));
        promises.push(Data.post('getCountries'));
        promises.push(Data.post('getStates'));
        promises.push(Data.post('getCities'));

        $q.all(promises).then(function(callback) {

            $scope.business = callback[0];
            $scope.countries = callback[1];
            $scope.states = callback[2];
            $scope.cities = callback[3];

            if ($scope.business.COUNTRY) {

                setCountry();
            }

            if ($scope.business.STATE) {

                setState();
            }

            if ($scope.business.CITY) {

                setCity();
            }

        })
    };

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
            return country.NOME === $scope.business.COUNTRY
        });

        $scope.myCountry = currentCountry[0];
    }

    function setState() {
        var currentState = $scope.states.filter(function(state) {
            return state.NOME === $scope.business.STATE
        });

        $scope.myState = currentState[0];
    }

    function setCity() {
        var currentCity = $scope.cities.filter(function(city) {
            return city.NOME === $scope.business.CITY
        });

        $scope.myCity = currentCity[0];
    }


    $scope.saveBusiness = function(business) {

        business.COUNTRY = $scope.myCountry.NOME;
        business.COUNTRY_ID = $scope.myCountry.IDPAIS;

        business.STATE = $scope.myState.NOME;
        business.STATE_ID = $scope.myState.IDESTADO;

        business.CITY = $scope.myCity.NOME;
        business.CITY_ID = $scope.myCity.IDMUNICIPIO;
    };

});