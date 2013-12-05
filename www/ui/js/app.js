// Create AngularJS application
var myMonitor = angular.module('myMonitor', [
    'ngRoute',
    'myMonitorControllers'
], function($provide) {
    $provide.factory('FB', function($window) {
        return $window.FB;
    });
});

myMonitor.config(['$routeProvider',
    function($routeProvider) {
        $routeProvider.
            when('/', {
                templateUrl: '/ui/partials/welcome.php',
                controller: 'MasterController'
            }).
            when('/logout', {
                templateUrl: '/ui/partials/welcome.php',
                controller: 'LogOutController'
            }).
            otherwise({
                redirectTo: '/'
            });
    }]);

myMonitor.filter('parenthesis', function() {
    return function(value) {
        if (value == undefined)
            return '';

        return '(' + value + ')';
    }
});