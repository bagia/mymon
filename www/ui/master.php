<!DOCTYPE html>
<html lang="en" ng-app="myMonitor">
<head>
    <meta charset="<?php echo $ENCODING; ?>"/>
    <title>My Monitor</title>
    <base href="<?php echo $SCHEME.'://'.$HOST.':'.$PORT.$BASE.'/'; ?>"/>
    <link rel="stylesheet" href="ui/css/base.css" type="text/css"/>
    <link rel="stylesheet" href="ui/css/theme.css" type="text/css"/>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.3/angular.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.3/angular-route.js"></script>
    <script src="https://connect.facebook.net/en_US/all.js"></script>
    <script src="/ui/js/facebook.js"></script>
    <script src="/ui/js/controllers.js"></script>
    <script src="/ui/js/app.js"></script>
    <script>
        $(function() {
            $("#menu").menu();
            $(".ui-menu").click(function(){
                $("#menu").hide();
            });
            $( "#avatar" ).click(function(){
                $("#menu").toggle();
            });
        });
    </script>
</head>
<body ng-controller="MasterController">
<div id="topbar">
    <ul id="navigation-menu">
        <li><a href="#/">Home</a></li>
        <li><a href="#/faq">FAQ</a></li>
        <li><a href="#/privacy">Privacy policy</a></li>
    </ul>
    <div id="loader" loader>
        <img src="/ui/img/loader.gif" class="ajax-loader" />
    </div>
    <div id="user">
        <div ng-show="user.connected" id="mywatchdogs">
            <a href="#/watchdogs">My watchdogs</a>
            <div ng-repeat="task in background_tasks">
                <div ng-hide="task.progress<0">{{task.name}}: {{task.progress | unknown}}%</div>
            </div>
        </div>
        <div id="avatar">
            <!-- Begin Facebook -->
            <div id="fb-root"></div>
            <div class="fb-login-button" data-max-rows="1" data-show-faces="false" data-scope="publish_actions"  ng-hide="user.connected"></div>
            <img ng-show="user.connected" ng-src="{{user.picture}}" />
            <div ng-show="user.connected" id="name">{{user.name}}</div>
            <!-- End Facebook -->
        </div>
        <ul id="menu">
            <li><a href="#/settings">Settings</a></li>
            <li><a href="#/logout">Log out</a></li>
        </ul>
    </div>
</div>
<div class="header center">
    <p>My Monitor</p>
</div>
<div ng-view></div>

<div class="footer center">
    <p>The code of this website is licensed under the terms of the GPL v3<br/>
        Copyright &copy; 2013-2014 Undisclosed creators</p>
</div>
</body>
</html>
