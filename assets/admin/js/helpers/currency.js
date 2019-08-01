function CurrencyHelper(){
    var $this = this;
    var exchange_values = [];

    this.setExchangeVaules = function(data){
        exchange_values = data;
    };

    this.format = function(number, currency, currency_display, round){
        number = $this.unformat(number);
        
        if( isNaN(number) ){
            return NaN;
        }


        if(currency_display == undefined){
            currency_display = true;
        }
        
        if(round == undefined || (round && currency != 'HUF')){
            round = false;
        }

        number = Math.round(number * 100) / 100;
        
        if(round){
            number = Math.round(number);
        }


        var num = number + "";
        num = num.split(".",2);
        var is_minus = 0;
        if( parseInt( num[0] ) < 0 ){
            num[0] = num[0].substring( 1, num[0].length );
            is_minus = 1;
        }
        var len = num[0].length;
        var place = new Array;
        for( var i=3; i<=len+2; i+=3 ){
            place[place.length] = num[0].substring( len-i, len-i+3 );
        }
        var value = "";
        for( var i=place.length-1; i>=0; i--){
            value += place[i]+" ";
        }
        value = value.replace(/,$/,"");
        value = value.trim();
        if(!round){
            if(num[1]){
                num[1] = num[1].substr(0,2);
                if(num[1].length == 1){
                    num[1] += '0';
                }
                value += ","+num[1];
            }else{
                value += ",00";
            }
        }
        if( is_minus ){
            value = '-' + value;
        }

        if(currency != undefined && currency_display){
            return value + ' ' + currency;   
        }else{
            return value;
        }
    };

    this.unformat = function(number){
        number = ("" + number).replace(/\./gi, ',');
        num = ("" + number).split(",",2);
        var value = 0;
        if(num[0]){
            value = num[0].replace(/\s/gi, '').trim();
        }
        if(num[1]){
            value += '.' + num[1]; 
        }
        return parseFloat(value);
    };


    this.exchange = function(price, currency, default_currency){
        if(default_currency == undefined){
            default_currency = 'HUF';
        }
        if(currency != default_currency){
            return parseFloat(price) * parseFloat(exchange_values[currency]);
        }else{
            return parseFloat(price);
        }
    };

    this.round = function(price, currency){
        price = parseFloat(price);
        if(currency == 'HUF'){
            price = Math.round(price);
        }else{
            price = Math.round(price * 100) / 100;
        }

        return price;
    };

    this.round5 = function(price, currency, payment_method){
        if(currency == 'HUF' && payment_method == 'készpénz'){
            price = Math.round(price / 5) * 5;
        }
        return price;
    };
}

var CurrencyHelper = new CurrencyHelper();
Vue.prototype.CurrencyHelper = CurrencyHelper;
