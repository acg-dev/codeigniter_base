var home_vm = new Vue({
    el: '#cookie-police',
    data: {},
    watch: {},
    mounted: function () {
    },
    updated: function() {},
    methods:{
    	send: function(){
    		this.InputHelper.updateData({'role': true}, 'cookie', function(response){
                if(response.status == true){
    			     $('#cookie-police').fadeOut();
                }
    		});
    	}
    }
});