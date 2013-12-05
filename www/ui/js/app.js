// Create AngularJS application
var myMonitor = angular.module('myMonitor', [
    'ngRoute',
], function ($provide) {
    $provide.factory('FB', function ($window) {
        return $window.FB;
    });
});

myMonitor.config(['$routeProvider',
    function ($routeProvider) {
        $routeProvider.
            when('/', {
                templateUrl: '/ui/partials/welcome.php',
                controller: WelcomeController,
                resolve: MasterController.resolve
            }).
            when('/watchdogs', {
                templateUrl: '/ui/partials/watchdogs.php',
                controller: WatchdogsController,
                resolve: MasterController.resolve
            }).
            when('/logout', {
                templateUrl: '/ui/partials/welcome.php',
                controller: LogoutController
            }).
            otherwise({
                redirectTo: '/'
            });
    }]);

myMonitor.filter('parenthesis', function () {
    return function (value) {
        if (value == undefined)
            return '';

        return '(' + value + ')';
    }
});

myMonitor.directive('accordionDirective', function () {
    return function (scope, element, attrs) {
        if (scope.$last) {
            $("#accordion").accordion();
        }
    };
})