app.controller('categoriesCtrl', function ($scope, Data, $location) {

    $scope.category = {name: ''};
    
    $scope.initWindow = function() {

        Data.post('getCategories').then(function(categories) {

            $scope.categories = categories;

        });

    };

    $scope.createCategory = function() {
        
        $location.path('adicionar-categorias');

    };

    $scope.saveCategory = function(category) {

        Data.post('saveCategory', {
            category: category
        }).then(function(results) {
            Data.toast(results);
            $location.path('categorias');
        })
    };

    $scope.removeCategory = function(category) {

        Data.post('removeCategory', {
            category: category
        }).then(function(results) {
            $scope.categories = results.categories;
            Data.toast(results);
        });

    };

});