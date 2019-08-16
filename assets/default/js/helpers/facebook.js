function facebook_login(scope){
    FB.login(function(response) {
        if (response.authResponse) {
         console.log('Welcome!  Fetching your information.... ');
         FB.api('/me', function(response) {
           console.log('Good to see you, ' + response.name + '.');
         });
        } else {
         console.log('User cancelled login or did not fully authorize.');
        }
    }, {scope: scope});
}

function facebook_share(){
	FB.ui({
	  method: 'share',
	  href: base_url,
	}, function(response){
		console.log(response);
	});
}

function facebook_share_custom(url, title, description, image) {
	FB.ui({
        method: 'share_open_graph',
        action_type: 'og.shares',
        action_properties: JSON.stringify({
            object: {
                'og:url': url,
                'og:title': title,
                'og:description': description,
                'og:image': base_url + image
            }
        })
    },
    function (response) {
    // Action after response
    })
}