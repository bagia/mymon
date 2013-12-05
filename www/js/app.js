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
                templateUrl: '/ui/partials/welcome.html',
                controller: 'MasterController'
            }).
            when('/logout', {
                templateUrl: '/ui/partials/welcome.html',
                controller: 'LogOutController'
            }).
            otherwise({
                redirectTo: '/'
            });
    }]);