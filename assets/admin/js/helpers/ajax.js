
function API( base_url ) {
    this.baseURL = base_url;
    
    
    this.send = function( method , uri , params , callback ){
        $this.alert_message('<i class="fas fa-sync-alt fa-spin fa-3x "></i>');
        var request = $.ajax({
            method: method,
            url: $this.baseURL + uri,
            data: params,
            dataType: 'json',
        });
                
        request.done(function( response ){
            callback( response , request );
            $this.alert_message('');
        }).fail(function( response ){
            callback( response , request );
            $this.alert_message('');
        });
    };
    this.get = function( uri , params , callback ){
        $this.send( 'GET' , uri , params , callback );
    };
    this.post = function( uri , params , callback ){
        $this.send( 'POST' , uri , params , callback );
    };
    this.put = function( uri , params , callback ){
        $this.send( 'PUT' , uri , params , callback );
    };
    this.delete = function( uri , params , callback ){
        $this.send( 'DELETE' , uri , params , callback );
    };

    /*RAW*/

    this.raw_send = function( method , uri , params , callback ){
        $this.alert_message('<i class="fas fa-sync-alt fa-spin fa-3x "></i>');
        var request = $.ajax({
            method: method,
            url: $this.baseURL + uri,
            data: params,
            dataType: 'json',
            contentType: 'application/json',
        });
                
        request.done(function( response ){
            callback( response , request );
            $this.alert_message('');
        }).fail(function( response ){
            callback( response , request );
            $this.alert_message('');
        });
    };

    this.get_raw = function( uri , params , callback ){
        $this.raw_send( 'GET' , uri , params , callback );
    };
    this.post_raw = function( uri , params , callback ){
        $this.raw_send( 'POST' , uri , params , callback );
    };
    this.put_raw = function( uri , params , callback ){
        $this.raw_send( 'PUT' , uri , params , callback );
    };
    this.patch_raw = function( uri , params , callback ){
        $this.raw_send( 'PATCH' , uri , params , callback );
    };
    this.delete_raw = function( uri , params , callback ){
        $this.raw_send( 'DELETE' , uri , params , callback );
    };

    this.alert_message = function(message){
        if($('#alert_message').length <= 0){
            $('body').append('<div id="alert_message" data-count="0" style="display: none;"><div><i class="fas fa-sync-alt fa-spin fa-3x "></i></div></div>');
        }

        var am_count = parseInt($('#alert_message').attr('data-count'));
        if(message != ''){
            if(!$('#alert_message').hasClass('open')){
                $('#alert_message div').html(message);
                $('#alert_message').addClass('open').fadeIn({duration: 400, queue: false});
            }
            
            $('#alert_message').attr('data-count', ++am_count);
        }else{
            $('#alert_message').attr('data-count', --am_count);
            if(am_count <= 0){
                setTimeout(function(){
                    $('#alert_message').removeClass('open').fadeOut({duration: 1000, queue: false});
                }, 500);
            }
        }
    }
    this.formData_send = function( method , uri , params , callback ){
        $this.alert_message('<i class="fas fa-sync-alt fa-spin fa-3x "></i>');
        var request = $.ajax({
            method: method,
            url: $this.baseURL + uri,
            data: params,
            contentType: false,
            cache: false,
            processData:false,
        });
                
        request.done(function( response ){
            callback( response , request );
            $this.alert_message('');
        }).fail(function( response ){
            callback( response , request );
            $this.alert_message('');
        });
    };

    this.post_formData = function( uri , params , callback ){
        $this.formData_send( 'POST' , uri , params , callback );
    };
    this.delete_formData = function( uri , params , callback ){
        $this.formData_send( 'DELETE' , uri , params , callback );
    };

    this.alert_message = function(message){
        if($('#alert_message').length <= 0){
            $('body').append('<div id="alert_message" data-count="0" style="display: none;"><div><i class="fas fa-sync-alt fa-spin fa-3x "></i></div></div>');
        }

        var am_count = parseInt($('#alert_message').attr('data-count'));
        if(message != ''){
            if(!$('#alert_message').hasClass('open')){
                $('#alert_message div').html(message);
                $('#alert_message').addClass('open').fadeIn({duration: 400, queue: false});
            }
            
            $('#alert_message').attr('data-count', ++am_count);
        }else{
            $('#alert_message').attr('data-count', --am_count);
            if(am_count <= 0){
                setTimeout(function(){
                    $('#alert_message').removeClass('open').fadeOut({duration: 500, queue: false});
                }, 500);
            }
        }
    }
    
    var $this = this;
}

var API = new API(base_url + 'api');