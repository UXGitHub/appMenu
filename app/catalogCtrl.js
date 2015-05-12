app.controller('catalogCtrl', function ($scope, Data, $q, $location) {

    $scope.catalog = {name: '', description: ''};
    $scope.checkedRows = [];

    //@todo create a full search
    $scope.getCatalogs = function() {
        
        Data.post('getCatalogs').then(function(catalogs) {
            
            $scope.catalogs = catalogs;
            $scope.itemsPerPage = 20;
            $scope.checkedRows = [];

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

    $scope.toogleCheckedRow = function(catalog) {
        
        if (catalog.checkedRow) {

            $scope.checkedRows.push(catalog);

        } else {

            var index = $scope.checkedRows.indexOf(catalog);
            $scope.checkedRows.splice(index, 1);
            delete catalog.checkedRow;
        }
    };

    $scope.removeSelectedCatalogs = function(catalogs) {

        Data.post('removeCatalogs', {catalogs : catalogs});
        
        catalogs.forEach(function(catalog) {

            var index = $scope.catalogs.indexOf(catalog);
            $scope.catalogs.splice(index, 1);

        });

        $scope.checkedRows = [];

        Data.toast({status: 'success', message: 'Catálogos excluídos com sucesso'});

    };

    $scope.loadMore = function() {
        if ($scope.allCatalogs) {
            var itemsPerPage = $scope.catalogs.length + $scope.itemsPerPage;
            $scope.catalogs = $scope.allCatalogs.slice(0, itemsPerPage);
        }

    };

    $scope.initWindow();

    $(window).on("scroll", function() {
        var scrollHeight = $(document).height();
        var scrollPosition = $(window).height() + $(window).scrollTop();
        if ((scrollHeight - scrollPosition) / scrollHeight < 0.030) {
            $scope.itemsPerPage += 20;
            $scope.$apply();
        }
    });

});