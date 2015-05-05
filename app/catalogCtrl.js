app.controller('catalogCtrl', function ($scope, Data, $q, $location) {

    $scope.catalog = {name: '', description: ''};
    $scope.checkedRows = [];
    $scope.positions = 20;

    $scope.getCatalogs = function() {
        
        Data.post('getCatalogs').then(function(catalogs) {
            
            $scope.allCatalogs = catalogs;
            $scope.catalogs = catalogs.slice(0, $scope.positions);
$scope.items = [
    {
        "id": 0,
        "picture": "http://placehold.it/32x32",
        "age": 31,
        "name": "Mathews Goff"
    },
    {
        "id": 1,
        "picture": "http://placehold.it/32x32",
        "age": 36,
        "name": "Collins Alston"
    },
    {
        "id": 2,
        "picture": "http://placehold.it/32x32",
        "age": 27,
        "name": "Jasmine Rollins"
    },
    {
        "id": 3,
        "picture": "http://placehold.it/32x32",
        "age": 32,
        "name": "Julie Jefferson"
    },
    {
        "id": 4,
        "picture": "http://placehold.it/32x32",
        "age": 23,
        "name": "Wilder King"
    },
    {
        "id": 5,
        "picture": "http://placehold.it/32x32",
        "age": 23,
        "name": "Stanley Moore"
    },
    {
        "id": 6,
        "picture": "http://placehold.it/32x32",
        "age": 36,
        "name": "Reynolds Bishop"
    },
    {
        "id": 7,
        "picture": "http://placehold.it/32x32",
        "age": 26,
        "name": "Bryant Flowers"
    },
    {
        "id": 8,
        "picture": "http://placehold.it/32x32",
        "age": 38,
        "name": "Jenifer Martinez"
    },
    {
        "id": 9,
        "picture": "http://placehold.it/32x32",
        "age": 40,
        "name": "Mcguire Pittman"
    },
    {
        "id": 10,
        "picture": "http://placehold.it/32x32",
        "age": 34,
        "name": "Valdez Hyde"
    },
    {
        "id": 11,
        "picture": "http://placehold.it/32x32",
        "age": 34,
        "name": "Marla Mayo"
    },
    {
        "id": 12,
        "picture": "http://placehold.it/32x32",
        "age": 30,
        "name": "Brown Ortega"
    },
    {
        "id": 13,
        "picture": "http://placehold.it/32x32",
        "age": 32,
        "name": "Jeannette William"
    },
    {
        "id": 14,
        "picture": "http://placehold.it/32x32",
        "age": 30,
        "name": "Bridges Ashley"
    },
    {
        "id": 15,
        "picture": "http://placehold.it/32x32",
        "age": 33,
        "name": "Latasha Hewitt"
    },
    {
        "id": 16,
        "picture": "http://placehold.it/32x32",
        "age": 35,
        "name": "Alma Sawyer"
    },
    {
        "id": 17,
        "picture": "http://placehold.it/32x32",
        "age": 21,
        "name": "Liz Mcbride"
    },
    {
        "id": 18,
        "picture": "http://placehold.it/32x32",
        "age": 26,
        "name": "Mcintosh Chandler"
    },
    {
        "id": 19,
        "picture": "http://placehold.it/32x32",
        "age": 20,
        "name": "Alford Hartman"
    },
    {
        "id": 20,
        "picture": "http://placehold.it/32x32",
        "age": 29,
        "name": "Tiffany Green"
    },
    {
        "id": 21,
        "picture": "http://placehold.it/32x32",
        "age": 38,
        "name": "Stafford Riggs"
    },
    {
        "id": 22,
        "picture": "http://placehold.it/32x32",
        "age": 40,
        "name": "Elinor Chambers"
    },
    {
        "id": 23,
        "picture": "http://placehold.it/32x32",
        "age": 27,
        "name": "Carly Howard"
    },
    {
        "id": 24,
        "picture": "http://placehold.it/32x32",
        "age": 27,
        "name": "Rosalind Sanchez"
    },
    {
        "id": 25,
        "picture": "http://placehold.it/32x32",
        "age": 28,
        "name": "Jaclyn Shelton"
    },
    {
        "id": 26,
        "picture": "http://placehold.it/32x32",
        "age": 25,
        "name": "Hughes Phelps"
    },
    {
        "id": 27,
        "picture": "http://placehold.it/32x32",
        "age": 36,
        "name": "Rosetta Barrett"
    },
    {
        "id": 28,
        "picture": "http://placehold.it/32x32",
        "age": 29,
        "name": "Jarvis Wong"
    },
    {
        "id": 29,
        "picture": "http://placehold.it/32x32",
        "age": 23,
        "name": "Kerri Pennington"
    }
];

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