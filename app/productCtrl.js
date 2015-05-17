app.controller('productCtrl', function ($scope, $location, Data, $q) {

    $scope.addCatalog = function(catalog) {
        Data.post('addCatalog', {
            catalog: catalog
        }).then(function(results) {
            Data.toast(results);
            $location.path('catalog');
        });
    };

    $scope.createProduct = function() {
        $location.path('adicionar-produtos');
    };
});