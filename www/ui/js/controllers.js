function MasterController($document, $http, $rootScope, FB) {
}

MasterController.resolve = {
    user: function ($rootScope, $http, $rootScope, $q) {
        var deferred = $q.defer();

        if ($rootScope.user.connected) {
            deferred.resolve($rootScope.user);
            return deferred.promise;
        }

        // Set User as not connected
        $rootScope.user = {
            connected: false,
            third_party_id: '',
            name: '',
            picture: '',
            access_token: ''
        };

        // Check if the user is logged in
        FB.getLoginStatus(function (response) {
            if (response.status === 'connected') {

                // Update UI
                $rootScope.user.connected = true;
                $rootScope.user.access_token = response.authResponse.accessToken;

                // Get the name and the third party id of the user
                FB.api('/me?fields=name,third_party_id', function (response) {

                    $rootScope.user.name = response.name;
                    $rootScope.user.third_party_id = response.third_party_id;

                    // Get the profile picture
                    FB.api("/me/picture?width=50&height=50", function (response) {
                        $rootScope.user.picture = response.data.url;

                        // Get count of watchdogs
                        $http.get('/watchdogs/count/' + $rootScope.user.third_party_id + '?access_token=' + $rootScope.user.access_token)
                            .success(function (response) {
                                $rootScope.watchdogs_count = response.data;
                                deferred.resolve($rootScope.user);
                            });

                    });
                });
            } else {
                // Not connected to Facebook
                // Still returning the empty user
                deferred.resolve($rootScope.user);
            }
        });
        return deferred.promise;
    }
};

function WelcomeController() {
}

function WatchdogsController($scope, $rootScope, $http, FB) {
    if ($rootScope.user.connected) {
        var query = '/watchdogs/list/' + $rootScope.user.third_party_id + '?access_token=' + $rootScope.user.access_token;
        console.log(query);
        $http.get(query)
            .success(function (response) {
                $scope.watchdogs = response;
            });
    }
}

function LogoutController($rootScope, FB) {
    $rootScope.user = {connected: false, name: '', picture: ''};
    FB.logout(function () {
        $rootScope.$apply(function () {
            $rootScope.user = {connected: false, name: '', picture: ''};
        });
    });
}
