function MasterController($document, $http, $rootScope, FB) {
}

MasterController.resolve = {
    user: function ($rootScope, $http, $rootScope, $q) {
        var deferred = $q.defer();

        if ($rootScope.user != undefined && $rootScope.user.connected) {
            deferred.resolve($rootScope.user);
            return deferred.promise;
        }

        // Set User as not connected
        $rootScope.user = {
            id: -1,
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
                FB.api('/me?fields=id,name,third_party_id', function (response) {

                    $rootScope.user.id = response.id;
                    $rootScope.user.name = response.name;
                    $rootScope.user.third_party_id = response.third_party_id;
                    console.log(response);

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
    $scope.delete = function(id) {
        var query = '/watchdogs/delete/' + $rootScope.user.third_party_id + '/' + id + '?access_token=' + $rootScope.user.access_token;
        console.log(query);
        $http.get(query)
            .success(function (response) {
                console.log(response);
                if (response.data > 0) {
                    $('#wd-' + id).prev().fadeOut();
                    $('#wd-' + id).fadeOut();
                    $rootScope.watchdogs_count--;
                } else {
                    alert('Failed to delete.');
                }
            });
    }

    if ($rootScope.user.connected) {
        var query = '/watchdogs/list/' + $rootScope.user.third_party_id + '?access_token=' + $rootScope.user.access_token;
        console.log(query);
        $http.get(query)
            .success(function (response) {
                $scope.watchdogs = response;
            });
    }
}

function NewController($rootScope, $scope, $http, FB) {
    $scope.notify_user = 0;

    $scope.submit = function () {
        $('#submit_button').attr('disabled', 'disabled');
        $( "#progressbar" ).progressbar({
            value: 0
        });

        var data = 'name=' + this.name;
        if (this.notify_user > 0) {
            data  += '&notify_user=' + $rootScope.user.id;
        }
        var query = '/watchdogs/new/' + $rootScope.user.third_party_id + '?access_token=' + $rootScope.user.access_token;
        console.log(data);
        var link = this.link;

        $http({
            url: query,
            method: "POST",
            data: data,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function(response){
                $( "#progressbar" ).progressbar({
                    value: 50
                });
                $('#submit_button').removeAttr('disabled');

                var image = window.location.origin + "/img/" + response.image;
                console.log(link);
                console.log(image);
                FB.api(
                    "/me/feed",
                    "POST",
                    {
                        "link": link,
                        "picture": image,
                        "privacy": {"value": "SELF"}
                    },
                    function (response) {
                        $( "#progressbar" ).progressbar({
                            value: 100
                        });
                        $rootScope.$apply(function(){
                            $rootScope.watchdogs_count++;
                        });

                        if (response && !response.error) {

                        } else {
                            console.log(response);
                        }
                    }
                );
        }).error(function(data){
                console.log(data);
            });
    };
}

function LogoutController($rootScope, FB) {
    $rootScope.user = {connected: false, name: '', picture: ''};
    FB.logout(function () {
        $rootScope.$apply(function () {
            $rootScope.user = {connected: false, name: '', picture: ''};
        });
    });
}

function PrivacyController() {
}
