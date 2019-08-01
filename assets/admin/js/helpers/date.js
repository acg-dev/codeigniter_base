function DateHelper(){
	this.currentDate = function (){
		var date = new Date();
		return date;
	}
	this.setDate = function (date1){
		date1 = date1.split('-');
		var date = new Date(date1[0], date1[1] - 1, date1[2]);
		return date;
	}

	this.changeDate = function (date){
		var m = date.match(/(\d{4})([\.\-\/\s]*)(\d{2})([\.\-\/\s]*)(\d{2})([\.\-\/\s]*)/);
		if(m != null){
			return m[1] + '-' + m[3] + '-' + m[5];
		}else{
			this.getDate();
		}
	}

	this.getDate = function (date){
		if(date == undefined){
			var date = new Date();
		}

		var dd = date.getDate();
		var mm = date.getMonth()+1;
		var yyyy = date.getFullYear();

		if(dd<10) {
		    dd = '0'+dd
		} 

		if(mm<10) {
		    mm = '0'+mm
		} 

		today = yyyy + '-' + mm + '-' + dd;
		
		return today;
	};

	this.currentAddDays = function(days, date) {
		if(date == undefined){
			var date = new Date();
		}
		
		date.setDate(date.getDate() + Number(days));
		return this.getDate(date);
	};

	this.dateDiff = function(date1, date2){
		var date1 = new Date(date1);
            var date2 = new Date(date2);
            var timeDiff = (date2.getTime() - date1.getTime());
            return diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24)); 
        };
}

var DateHelper = new DateHelper();
Vue.prototype.DateHelper = DateHelper;