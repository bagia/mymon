FB.init({
    appId      : '<?php echo $FACEBOOK_APPID; ?>',
    status     : true, // check login status
    cookie     : true, // enable cookies to allow the server to access the session
    xfbml      : true  // parse XFBML
});

FB.Event.subscribe('auth.login', function() {
    window.location = '/';
});