var myMonitorControllers = angular.module('myMonitorControllers', []);

myMonitorControllers.controller('MasterController', ['$document', '$http', '$rootScope', 'FB',
    function ($document, $http, $rootScope, FB) {
        $rootScope.user = {
            connected: false,
            name: '',
            picture: '',
            access_token: ''
        };
        FB.getLoginStatus(function(response) {
            if (response.status === 'connected') {
                console.log(response.authResponse);
                $rootScope.$apply(function() {
                    $rootScope.user.connected = true;
                    $rootScope.user.access_token = response.authResponse.accessToken;
                });
                FB.api('/me?fields=name,third_party_id', function(response) {
                    console.log(response);

                    // Get count of watchdogs
                    $http.get('/watchdogs/count/' + response.third_party_id + '?access_token=' + $rootScope.user.access_token)
                        .success(function(response) {
                            $rootScope.watchdogs = {count: response.data};
                        });

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
