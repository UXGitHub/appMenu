app.controller('catalogCtrl', function ($scope, Data, $q, $location) {

    $scope.catalog = {name: '', description: ''};
    $scope.checkedRows = [];
    $scope.positions = 20;

    $scope.getCatalogs = function() {
        
        Data.post('getCatalogs').then(function(catalogs) {
            
            $scope.allCatalogs = catalogs;
            $scope.catalogs = catalogs.slice(0, $scope.positions);

        });
    };

    $scope.initWindow = function() {

        $scope.getCatalogs();
    };

    $scope.addCatalog = function(catalog) {
        Data.post('addCatalog', {
            catalog: catalog
        }).then(function(results) {
            Data.toast(results);
            $location.path('catalog');
        });
    };

    $scope.editCatalog = function(catalog) {
        console.log(catalog);
    };

    $scope.openViewAddCatalog = function() {
        $location.path('addCatalog');
    };

    $scope.toogleCheckedRow = function(checked, row) {
        
        if (checked) {

            $scope.checkedRows.push(row);

        } else {

            var index = $scope.checkedRows.indexOf(row);
            $scope.checkedRows.splice(index, 1);
        }
    };

    $scope.removeSelectedCatalogs = function(catalogs) {
        console.log(catalogs);
    };

    $scope.loadMore = function() {
        if ($scope.allCatalogs) {
            $scope.positions = $scope.positions * 2;
            $scope.catalogs = $scope.allCatalogs.slice(0, $scope.positions);
        }

    };

    $scope.initWindow();


});