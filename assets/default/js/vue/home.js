var home_vm = new Vue({
    el: '#main',
    data: {},
    watch: {},
    mounted: function () {
    },
    updated: function() {},
    methods:{
    	home: function(){
    		this.InputHelper.loadData(this, 'home', 'home', {}, function(response){
    			if(response){
    				alert('OK');
    			}else{
    				alert('FAIL');
    			}
    		});
    	}
    }
});