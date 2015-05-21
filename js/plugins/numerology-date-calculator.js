;(function ( $, window, document, undefined ) {

    "use strict";

    var pluginName = "numerologyDateCalculator",
        defaults = {
            output: ".calculator-for-dates-output h2",
            proof:  ".calculator-for-dates-proof"
        };

    function Plugin ( element, options ) {
        this.element = element;
        this.$element = $(element);

        this.settings = $.extend( {}, defaults, options );

        this._defaults = defaults;
        this._name = pluginName;
        this.init();
    }

    $.extend(Plugin.prototype, {
        init: function () {
            var that = this,
                $selectDay = this.$element.find('.selectDay'),
                $selectMonth = this.$element.find('.selectMonth'),
                $selectYear = this.$element.find('.selectYear');

            this.$element.find(that.settings.proof).hide();

            this.$element.find('select').on('change', function() {
                
                console.log('message');

                var obj = new Object();
                obj.magicalNumber = 0;
                obj.numbers = new Array();

                _.each([$selectDay.val(), $selectMonth.val(), $selectYear.val()], function(num){
                    var number = new Object();
                    number.number = num;
                    obj.numbers.push(number);
                });

                obj = that.calculateMagicalNumber( obj );
                obj.proof = that.calculateProofs(obj);

                that.$element.find(that.settings.output).html(obj.magicalNumber);

                that.$element.find(that.settings.proof).show();
                that.$element.find(that.settings.proof + " div").html(obj.proof);

            
            });

        },
        calculateMagicalNumber: function(obj){
            var that = this;

            _.each(obj.numbers, function(n,i){
                
                n.magicalNumber = n.number;
                n.sums = new Array();
                
                while (n.magicalNumber > 9 && !( n.magicalNumber == 22 || n.magicalNumber == 11) ) {
                    var digits = that.sumMagicNumberDigits(n.magicalNumber);
                    n.magicalNumber = digits.sum;
                    n.sums.push(digits);
                }

                obj.numbers[i] = n;
            
            });

            return obj;

        },

        sumMagicNumberDigits: function ( number ){
            var charArray = number.toString().split(''),
                magicalNumber = 0,
                digits = new Object();
                digits.largeSum = number;

            digits.digits = charArray;

            for(var index in charArray){
                magicalNumber += parseInt( charArray[index] );
            }
            
            digits.sum = magicalNumber;

            return digits;
        },

        calculateProofs: function(obj){
            var o = "",
            that = this;

            _.each(obj.numbers, function(n, i){
                
                o += "<p><strong>" + n.number + "</strong> = ";

                if( n.sums.length > 0){
                    _.each(n.sums, function(s, k){

                        o += (k < 1 ? "" : " and ");

                        _.each(s.digits, function(d, l){
                            o += d + ( l < s.digits.length - 1 ? " + " : " = ");
                        });

                        o += s.sum;

                    });
                } else {
                    o += n.magicalNumber;
                }

                o += "</p>";

            });

            o += "<strong>Life Path Number</strong> = ";
            
            
            _.each(obj.numbers, function(n, i){
                o += n.magicalNumber + ( i < obj.numbers.length - 1 ? " + " : " = ");
                obj.magicalNumber += parseInt( n.magicalNumber );
            });                   
       
            obj.magicalNumberCalculations = new Array();

            while (obj.magicalNumber > 9 && !( obj.magicalNumber == 22 || obj.magicalNumber == 11) ) {
                var digits = that.sumMagicNumberDigits(obj.magicalNumber);
                obj.magicalNumber = digits.sum;
                obj.magicalNumberCalculations.push(digits);
            }
            
            if(obj.magicalNumberCalculations.length > 0){
            
                _.each(obj.magicalNumberCalculations, function(magicalSum, z){
                   
                    o += magicalSum.largeSum + " and ";
            
                    _.each(magicalSum.digits, function(d, l){
                        o += d + ( l < magicalSum.digits.length - 1 ? " + " : " = ");
                    });
            
            
                });
            
            } 
            
            o += obj.magicalNumber;
                    
            return o;
        }

    });

    $.fn[ pluginName ] = function ( options ) {
        return this.each(function() {
            if ( !$.data( this, "plugin_" + pluginName ) ) {
                $.data( this, "plugin_" + pluginName, new Plugin( this, options ) );
            }
        });
    };

})( jQuery, window, document );