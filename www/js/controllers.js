var myMonitorControllers = angular.module('myMonitorControllers', []);

myMonitorControllers.controller('MasterController', ['$document', '$rootScope', 'FB',
    function ($document, $rootScope, FB) {
        $rootScope.user = {connected: false, name: '', picture: ''};
        FB.getLoginStatus(function(response) {
            if (response.status === 'connected') {
                $rootScope.$apply(function() {
                    $rootScope.user.connected = true;
                });
                FB.api('/me', function(response) {
                    $rootScope.$apply(function() {
                        $rootScope.user.name = response.name;
                    });
                });
                FB.api("/me/picture?width=50&height=50",  function(response) {
                    $rootScope.$apply(function() {
                        $rootScope.user.picture = response.data.url;
                        console.log(response);
                    });
                });
            }
        });
    }]);


myMonitorControllers.controller('LogOutController', ['$rootScope', 'FB',
    function ($rootScope, FB) {
        $rootScope.user = {connected: false, name: '', picture: ''};
        FB.logout(function() {
            $rootScope.$apply(function() {
                $rootScope.user = {connected: false, name: '', picture: ''};
            });
        });
    }]);
