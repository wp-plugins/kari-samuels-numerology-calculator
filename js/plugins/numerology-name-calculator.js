;(function ( $, window, document, undefined ) {

    "use strict";

    var pluginName = "numerologyNameCalculator",
        defaults = {
            conversionMatrix:  {
                1: ["a", "j", "s"],
                2: ["b", "k", "t"],
                3: ["c", "l", "u"],
                4: ["d", "m", "v"],
                5: ["e", "n", "w"],
                6: ["f", "o", "x"],
                7: ["g", "p", "y"],
                8: ["h", "q", "z"],
                9: ["i", "r"]
            },
            output: ".calculator-for-name-output h2",
            proof:  ".calculator-for-name-proof"
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
            var that = this;

            $(that.settings.proof).hide();

            this.$element.bind('input', function(){

                var obj = new Object();
                
                obj.magicalNumber = 0;
                obj.inputString = that.$element.find('input').first().val();
                
                obj.words = new Array();

                if(obj.inputString.length > 0){

                    var wordsArray = obj.inputString.split(" ");

                    for(var index in wordsArray){

                        var word = new Object();
                        word.word = wordsArray[index];

                        do {
                            word = that.convertStringToNumber( word );
                        } while (word.sum > 9 && !( word.sum == 22 || word.sum == 11) ) 

                        obj.words.push(word);
                    }

                    for(var index in obj.words){
                        obj.magicalNumber += obj.words[index].sum;
                    }

                    obj.magicalNumberCalculations = new Array();

                    while (obj.magicalNumber > 9 && !( obj.magicalNumber == 22 || obj.magicalNumber == 11) ) {                        
                        var digits = that.sumMagicNumberDigits(obj.magicalNumber);
                        obj.magicalNumber = digits.sum;
                        obj.magicalNumberCalculations.push(digits);
                    }

                }

                obj.proof = that.calculateProofs(obj);

                that.$element.find(that.settings.output).html(obj.magicalNumber);

                if(obj.inputString.length > 1){
                    that.$element.find(that.settings.proof).show();
                    that.$element.find(that.settings.proof + " div").html(obj.proof);
                } else {
                    that.$element.find(that.settings.proof).hide();
                }

            });

        },

        calculateProofs: function(obj){
            var o = "";

            if(obj.inputString.length < 2) return; 

            _.each(obj.words, function(w, i){

                if(w.word == "") return;
                
                o += "<p><strong>" + w.word + "</strong> = ";

                _.each(w.letter, function(l, j){

                    o += l.number + ( j < w.letter.length - 1 ? " + " : " = ");
                
                });

                if( w.sums.length > 0){
                    _.each(w.sums, function(s, k){
                       
                        o += (k < 1 ? s.largeSum + " and " : " and ");

                        _.each(s.digits, function(d, l){
                            o += d + ( l < s.digits.length - 1 ? " + " : " = ");
                        });

                        o += s.sum;

                    });
                } else {
                    o += w.sum;
                }

                o += "</p>";

            });

            o += "<p><strong>Destiny Number</strong> = ";

            if(obj.words.length > 1) {
                 _.each(obj.words, function(w, m){
                    o += w.sum + ( m < obj.words.length - 1 ? " + " : " = ");
                });                   
            }

            if(obj.magicalNumberCalculations.length > 0){

                _.each(obj.magicalNumberCalculations, function(magicalSum, z){
                   
                    o += (z < 1 ? magicalSum.largeSum + " and " : " and ");

                    _.each(magicalSum.digits, function(d, l){
                        o += d + ( l < magicalSum.digits.length - 1 ? " + " : " = ");
                    });


                });

            } 

            o += obj.magicalNumber;

            o += "</p>";
            
            return o;
        },

        convertStringToNumber: function( word ) {
            var charArray = word.word.toLowerCase().split('');
            word.letter = new Array();
            word.sum = 0;
            word.sums = new Array();

            for(var index in charArray){
                var letter = new Object();
                letter.letter = charArray[index];
                if( isNaN( parseInt( charArray[index] ) ) ){
                    letter.number = this.convertCharToInt( charArray[index] );
                } else {
                   letter.number = parseInt( charArray[index] );
                }
                word.sum += letter.number;
                word.letter.push(letter);
            }

            while (word.sum > 9 && !( word.sum == 22 || word.sum == 11) ) {
                var digits = this.sumMagicNumberDigits(word.sum);
                word.sum = digits.sum;
                word.sums.push(digits);
            }

            return word;
        },

        convertCharToInt: function ( char ) {
            var charConvertedToNumber = 0;

            for( var key in this.settings.conversionMatrix ){
                var value = this.settings.conversionMatrix[key];

                if( value.indexOf(char) > -1 ){
                    charConvertedToNumber = key;
                    break;
                }
            }

            return parseInt( charConvertedToNumber );
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