function InputHelper(){
	var $this = this;
    var datas = {};
    var buttons = {};

    this.loadData = function(current_object, type, url, parameters, callback){
        datas[type] = undefined;
        API.get(
            url,
            parameters,
            function (response, xhr) {
                if (200 !== xhr.status) {
                    alert(xhr.responseJSON.status.message);
                } else {
                    if(response.data !== false){
                        datas[type] = response.data;
                    }else{
                        datas[type] = undefined;
                    }
                    current_object.$forceUpdate();
                    if(callback != undefined){
                        if(typeof callback == 'string'){
                            current_object[callback]();
                        }else if(typeof callback == 'function'){
                            callback();
                        }
                    }
                }
            }
            );
    };

    this.getData = function(type){
        if(datas[type] != undefined){
            return datas[type];
        }else{
            return undefined;
        }
    };
    
    this.clearData = function(type){
        if(datas[type] != undefined){
            datas[type] = undefined;
        }
    };

    this.updateData = function(base_data, data, url, callback){
        API.put_raw(
            url,
            JSON.stringify(data),
            function (response, xhr) {
                if (200 !== xhr.status) {
                    alert(xhr.responseJSON.status.message);
                } else {
                    for(var key in response.data){
                        base_data[key] = response.data[key];
                    }

                    if(callback != undefined){
                        if(typeof callback == 'string'){
                            current_object[callback]();
                        }else if(typeof callback == 'function'){
                            callback();
                        }
                    }
                }
            }
            );
    };

    this.postData = function(data, url, callback){
        API.post_raw(
            url,
            JSON.stringify(data),
            function (response, xhr) {
                if (200 !== xhr.status) {
                    alert(xhr.responseJSON.status.message);
                } else {
                    if(callback != undefined){
                        var data = response.data != undefined ? response.data : (response.responseJSON.data != undefined ? response.responseJSON.data : {});
                        if(typeof callback == 'string'){
                            current_object[callback](data);
                        }else if(typeof callback == 'function'){
                            callback(data);
                        }
                    }
                }
            }
            );
    };
    
    this.putData = function(data, url, callback){
        API.put_raw(
            url,
            JSON.stringify(data),
            function (response, xhr) {
                if (200 !== xhr.status) {
                    alert(xhr.responseJSON.status.message);
                } else {
                    if(callback != undefined){
                        var data = response.data != undefined ? response.data : response.responseJSON.data;
                        if(typeof callback == 'string'){
                            current_object[callback](data);
                        }else if(typeof callback == 'function'){
                            callback(data);
                        }
                    }
                }
            }
            );
    };


    this.removeData = function(url, params, callback){
        if(params == undefined){
            params = {};
        }
        if(url != undefined && this.confirm('remove')){
            API.delete_raw(url,
                JSON.stringify(params),
                function(response){
                    if(callback != undefined){
                        var data;
                        if(response.data != undefined){
                            var data = response.data;
                        }else if(response.responseJSON != undefined && response.responseJSON.data != undefined){
                            var data = response.responseJSON.data;
                        }
                        if(typeof callback == 'string'){
                            current_object[callback](data);
                        }else if(typeof callback == 'function'){
                            callback(data);
                        }
                    }
                });
        }
    };

    this.confirm = function(type){
        var question = '';
        if(type == 'remove'){
            question = 'Biztosan törölni szeretnéd?'
        }else if(type == 'create'){
            question = 'Biztosan létre szeretnéd hozni?'
        }else if(type == 'update'){
            question = 'Biztosan frissíteni szeretnéd?'
        }else if(type != ''){
            question = type;
        }
        if(question != '' && confirm(question)){
            return true;
        }else{
            return false;
        }
    }


    this.arrayRemove = function (array, index) {
        array.splice(index, 1);
    };

    this.arraySearch = function(array, id, item_name){
        var item = false;
        if(array != undefined){
            for(var i in array){
                if(array[i][item_name] == id){
                    item = array[i];
                    item.index = i;
                    break;
                }
            }
        }

        return item;
    };

    this.inArray = function(value, array){
        if(array != undefined && value != undefined){
            for(var i in array){
                if(array[i] == value){
                    return true;
                }
            }
        }

        return false;
    };

    this.nl2br = function (str) {
        if (typeof str === 'undefined' || str === null) {
            return '';
        }
        return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + '<br/>' + '$2');
    };

    this.setButton = function(type, url, parameters){
        buttons[type] = {
            url: url,
            parameters: parameters
        };
    }
    this.getButton = function(type){
        if(buttons[type] != undefined){
            if(buttons[type].url != undefined){
                return base_url + 'api/' + buttons[type].url + '?' + $.param(buttons[type].parameters);
            }else{
                return "#";
            }
        }else{
            return false;
        }
    };
}


var InputHelper = new InputHelper();
Vue.prototype.InputHelper = InputHelper;