app.directive('focus', function() {
    return function(scope, element) {
        element[0].focus();
    }      
});

app.directive('passwordMatch', [function () {
    return {
        restrict: 'A',
        scope:true,
        require: 'ngModel',
        link: function (scope, elem , attrs,control) {
            var checker = function () {
 
                //get the value of the first password
                var e1 = scope.$eval(attrs.ngModel); 
 
                //get the value of the other password  
                var e2 = scope.$eval(attrs.passwordMatch);
                if(e2!=null)
                return e1 == e2;
            };
            scope.$watch(checker, function (n) {
 
                //set the form control to valid if both 
                //passwords are the same, else invalid
                control.$setValidity("passwordNoMatch", n);
            });
        }
    };
}]);

app.directive('passwordNoMatch', [function () {
    return {
        restrict: 'A',
        scope:true,
        require: 'ngModel',
        link: function (scope, elem , attrs,control) {
            var checker = function () {
 
                //get the value of the first password
                var e1 = scope.$eval(attrs.passwordNoMatch); 
 
                //get the value of the other password  
                var e2 = scope.$eval(attrs.ngModel);
                if(e2!=null)
                return e1 !== e2;
            };
            scope.$watch(checker, function (n) {
 
                //set the form control to valid if both 
                //passwords are the same, else invalid
                control.$setValidity("passwordMatch", n);
            });
        }
    };
}]);


app.directive('masonry', function($timeout) {
    return function(scope, element, attrs) {

        if (scope.$last){
            $timeout(function () {
                var parent = element.parent();
                var masonry = new Masonry(parent[0], {
                    itemSelector: '.masonry-item',
                    isAnimated: true,
                    animationOptions: {
                        duration: 750,
                        easing: 'linear',
                        queue: false
                    },
                    transitionDuration : "0.4s",
                    isResizable: false
                });
            });
        }
    };
});