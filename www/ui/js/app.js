// Create AngularJS application
var myMonitor = angular.module('myMonitor', [
    'ngRoute',
], function ($provide) {
    $provide.factory('FB', function ($window) {
        return $window.FB;
    });
});

myMonitor.config(['$routeProvider', '$httpProvider',
    function ($routeProvider, $httpProvider) {
        $httpProvider.withCredentials = true;

        $routeProvider.
            when('/', {
                templateUrl: '/ui/partials/welcome.php',
                controller: WelcomeController,
                resolve: MasterController.resolve
            }).
            when('/settings', {
                templateUrl: '/ui/partials/settings.php',
                controller: SettingsController,
                resolve: MasterController.resolve
            }).
            when('/watchdogs', {
                templateUrl: '/ui/partials/watchdogs.php',
                controller: WatchdogsController,
                resolve: MasterController.resolve
            }).
            when('/new', {
                templateUrl: '/ui/partials/new.php',
                controller: NewController,
                resolve: MasterController.resolve
            }).
            when('/power', {
                templateUrl: '/ui/partials/power.php',
                controller: PowerController,
                resolve: MasterController.resolve
            }).
            when('/privacy', {
                templateUrl: '/ui/partials/privacy.php',
                controller: PrivacyController,
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

myMonitor.factory('httpInterceptor', function ($q, $rootScope, $log) {

    var numLoadings = 0;

    return {
        request: function (config) {
            // Do not show the loader if we are polling a task
            if (!(config.method == 'GET' && config.url.indexOf('/tasks/') == 0)) {
                $rootScope.$broadcast("loader_show");
            }
            numLoadings++;

            return config || $q.when(config)

        },
        response: function (response) {
            if ((--numLoadings) === 0) {
                $rootScope.$broadcast("loader_hide");
            }
            return response || $q.when(response);

        },
        responseError: function (response) {
            if (!(--numLoadings)) {
                $rootScope.$broadcast("loader_hide");
            }
            return $q.reject(response);
        }
    };
})
.config(function ($httpProvider) {
    $httpProvider.interceptors.push('httpInterceptor');
})
.directive("loader", function ($rootScope) {
        return function ($scope, element, attrs) {
            $scope.$on("loader_show", function () {
                return element.show();
            });
            return $scope.$on("loader_hide", function () {
                return element.hide();
            });
        };
    }
);


myMonitor.filter('parenthesis', function () {
    return function (value) {
        if (value == undefined)
            return '';

        return '(' + value + ')';
    }
});

myMonitor.filter('unknown', function () {
    return function (value) {
        if (value < 0)
            return '-';

        return value;
    }
});

myMonitor.directive('accordionDirective', function () {
    return function (scope, element, attrs) {
        if (scope.$last) {
            $("#accordion").accordion();
        }
    };
});
