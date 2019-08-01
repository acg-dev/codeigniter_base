function uploadFile(app_url){
	var $this = this;
	var app_url = app_url;
	var documents = {};
	var current_object = '';

	this.set = function(co){
    	current_object = co;
	};

	this.get = function(type){
		if(documents[type] != undefined){
			return documents[type];
		}else{
			return false;
		}
	};
	
	this.getLength = function(type){
		if(documents[type] != undefined && documents[type]){
			return documents[type].length;
		}else{
			return 0;
		}
	};

	this.download = function(type_id, type, array){
        API.get('/download/' + type_id + '/' + type + '/list',
                {},
                function(response){
                    if(array != undefined && array == true){
                        if(documents[type] == undefined){
                            documents[type] = new Array();
                        }
                        for(var i = 0 in response.data){
                            documents[type].push(response.data[i]);
                        }
                    }else{
                        documents[type] = response.data;
                    }

                    current_object.$forceUpdate();
            });
    };

    this.upload = function(type_id, type, path, callback){
        
        if(type_id != undefined && type != undefined && path != undefined){
          
            var formData = new FormData();
            formData.append('file', $('#document-upload-input')[0].files[0]);
            API.post_formData(
                '/upload-file/' + type_id + '/' + type + '/' + path,
                formData,
                function(response, xhr){
                    if (200 !== xhr.status) {
                        alert(xhr.responseJSON.status.message);
                    } else {
                        $('#document-upload-input').removeAttr('data-type');
                        $('#document-upload-input').removeAttr('data-type-id');
                        $('#document-upload-input').attr('data-path');
                        $('#document-upload-input').val('');
                        documents[type] = response.data;
                        current_object.$forceUpdate();
                        if(callback != undefined && callback != 'undefined'){
                            callback = JSON.parse(callback);
                            if(callback.function != undefined && callback.args != undefined && typeof callback.function == 'string'){
                                current_object[callback.function](callback.args);
                            }
                        }
                    }
                }
            );
        }else{
            alert('Hiba történt!');
        }
    };

    this.add = function(type_id, type, path, callback){
		if(type_id != undefined && type != undefined){
    		$('#document-upload-input').attr('data-type', type);
    		$('#document-upload-input').attr('data-type-id', type_id);
    		$('#document-upload-input').attr('data-path', path);
            $('#document-upload-input').attr('data-callback', String(callback));
    		$('#document-upload-input').click();
    	}
    };

    this.change = function(co){
    	$this.upload($('#document-upload-input').attr('data-type-id'), $('#document-upload-input').attr('data-type'), $('#document-upload-input').attr('data-path'), $('#document-upload-input').attr('data-callback'));
    };

    this.change_group = function(){
        if($('#document-upload-input-group').attr('data-url') != undefined){
            var formData = new FormData();
            for(var i = 0 in $('#document-upload-input-group')[0].files){
                formData.append('file['+ i +']', $('#document-upload-input-group')[0].files[i]);
            }
            API.post_formData(
                $('#document-upload-input-group').attr('data-url'),
                formData,
                function(response, xhr){
                    if (200 !== xhr.status) {
                        alert(xhr.responseJSON.status.message);
                    } else {
                        $('#document-upload-input-group').removeAttr('data-url');
                        $('#document-upload-input-group').val('');
                        current_object.loadData();
                    }
                }
            );
        }
    };

    this.downloadFile = function(id){
    	return app_url + 'download-file/' + id;
    };

    this.remove = function(id, type){
    	if(id != undefined && confirm('Biztosan törölni szeretnéd?')){
            API.delete('/remove-file/' + id,
                {},
                function(response){
	                documents[type] = response.data;
	                current_object.$forceUpdate();
            });
        }
    };
};


Vue.prototype.uploadFile = new uploadFile(app_url);