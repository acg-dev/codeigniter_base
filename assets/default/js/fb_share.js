function share_facebook(){
	FB.ui({
	  method: 'share',
	  href: base_url,
	}, function(response){
		console.log(response);
	});
}

function share_custom_facebook(url, title, description, image) {
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