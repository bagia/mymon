FB.init({
    appId      : '607819265939652',
    status     : true, // check login status
    cookie     : true, // enable cookies to allow the server to access the session
    xfbml      : true  // parse XFBML
});

FB.Event.subscribe('auth.login', function() {
    window.location = '/';
});