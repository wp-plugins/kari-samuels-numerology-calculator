(function( $ ) {
	'use strict';

    // Numerology Name Calculator Scripts
    if ($.fn.numerologyNameCalculator) {
        $(".calculator-for-names").numerologyNameCalculator();
    }

    // Numerology Date Calculator Scripts
    if ($.fn.numerologyDateCalculator) {
        $(".calculator-for-dates").numerologyDateCalculator();
    }

    $( ".calculator-for-dates-datepicker" ).datepicker({
        showOn: "both", 
        buttonText: "<i class='fa fa-calendar'></i>",
        onSelect: function(dateText, inst) {
            var date = new Date(dateText),
                day =  date.getDate(),
                month = date.getMonth(),
                year = date.getFullYear(),
                $this = $(this);

            $this.siblings('.selectDay').val(day).change();
            $this.siblings('.selectMonth').val(month + 1).change();
            $this.siblings('.selectYear').val(year).change();

        }
    });


})( jQuery );
