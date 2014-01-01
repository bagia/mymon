function MasterController($document, $http, $rootScope, FB) {
}

function setProgressOfTask(task_id, progress, $rootScope) {
    angular.forEach($rootScope.background_tasks, function(value, key) {
        if (value.task_id == task_id) {
            $rootScope.background_tasks[key].progress = progress;
        }
    });
}

function followTask(task_id, $http, $timeout, $rootScope, success_callback, error_callback, refresh) {
    if (refresh == undefined) {
        refresh = 0;
    }

    $timeout(function(){
        var query = '/tasks/' + encodeURIComponent(task_id);
        console.log(query);
        $http.get(query).success(function(response) {
            setProgressOfTask(task_id, response.progress, $rootScope);
            if (success_callback != undefined) {
                success_callback(response);
            }
            followTask(task_id, $http, $timeout, $rootScope, success_callback, error_callback, 5000);
        }).error(function(error) {
            setProgressOfTask(task_id, -1, $rootScope);
            if (error_callback != undefined) {
                error_callback(error);
            }
            console.log(error);
        });
    }, refresh);
}

MasterController.resolve = {
    user: function ($rootScope, $http, $rootScope, $q, $timeout) {
        var deferred = $q.defer();

        if ($rootScope.user != undefined && $rootScope.user.connected) {
            deferred.resolve($rootScope.user);
            return deferred.promise;
        }

        // Set User as not connected
        $rootScope.user = {
            id: -1,
            connected: false,
            name: '',
            picture: ''
        };
        $rootScope.background_tasks = new Array();

        // Check if the user is logged in
        FB.getLoginStatus(function (response) {
            if (response.status === 'connected') {
                // Update UI
                $rootScope.user.connected = true;

                // Get the name and the third party id of the user
                FB.api('/me?fields=id,name', function (response) {

                    $rootScope.user.id = response.id;
                    $rootScope.user.name = response.name;
                    console.log(response);

                    // Get the profile picture
                    FB.api("/me/picture?width=50&height=50", function (response) {
                        $rootScope.user.picture = response.data.url;

                        // Get count of watchdogs
                        $http.get('/watchdogs/count')
                            .success(function (response) {
                                $rootScope.watchdogs_count = response.data;

                                $http.get('/tasks/list')
                                    .success(function(response) {
                                        console.log(response);
                                        angular.forEach(response, function(task) {
                                            task.progress = -1;
                                            $rootScope.background_tasks.push(task);
                                            followTask(task.task_id, $http, $timeout, $rootScope);
                                        });
                                        deferred.resolve($rootScope.user);
                                    });

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
        var query = '/watchdogs/' + id;
        console.log(query);
        $http.delete(query)
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
        var query = '/watchdogs/list';
        console.log(query);
        $http.get(query)
            .success(function (response) {
                $scope.watchdogs = response;
            });
    }
}

function PowerController($rootScope, $scope, $http, $timeout) {
    $scope.notify_user = 0;

    $scope.submit = function () {
        $('#submit_button').attr('disabled', 'disabled');
        $( "#progressbar" ).progressbar({
            value: 0
        });

        var data = {link: this.link};
        if (this.notify_user > 0) {
            data.notify_user = $rootScope.user.id;
        } else {
            data.notify_user = 0;
        }
        var query = '/watchdogs/power';
        console.log(query);
        console.log(data);

        $http.post(query, data).
            success(function(response){
                console.log(response);

                var task_id = response.task_id;
                var task = {task_id: response.task_id, progress:0, name: 'Deployment'};
                $rootScope.background_tasks.push(task);
                followTask(task.task_id, $http, $timeout, $rootScope, function (response) {
                    $( "#progressbar" ).progressbar({
                        value: response.progress
                    });
                });

            }).error(function(data){
                console.log(data);
            });
    };
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
        var query = '/watchdogs';
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
