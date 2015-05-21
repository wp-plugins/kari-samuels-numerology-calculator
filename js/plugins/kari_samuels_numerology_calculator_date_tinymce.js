(function($) {
   tinymce.create('tinymce.plugins.kari_samuels_numerology_calculator_date', {
      init : function(ed, url) {
         ed.addButton('kari_samuels_numerology_calculator_date', {
            title : 'Kari Samuels Numerology Calculator for Dates',
            image : url + '../../../images/water.svg',
            onclick : function() {
               var width = $(window).width(), 
                  H = $(window).height(), 
                  W = ( 720 < width ) ? 720 : width;
               W = W - 8;
               H = H - 8;

               var params = {
                  "action" : "kari_samuels_numerology_calculator_date_action",
                  "width"  : W,
                  "height"  : H
               }

               tb_show( 'Kari Samuels Numerology Calculator for Dates', ajaxurl + '?' + $.param( params ) );

            }
         });
      },
      createControl : function(n, cm) {
         return null;
      },
      getInfo : function() {
         return {
            longname : "Kari Samuels Numerology Calculator for Dates",
            author : 'Gregory Lampa, BA, MEd, QTS',
            authorurl : 'http://www.wordpress-fix.co.uk',
            infourl : 'http://www.wordpress-fix.co.uk',
            version : "1.0"
         };
      }
   });

   tinymce.PluginManager.add('kari_samuels_numerology_calculator_date', tinymce.plugins.kari_samuels_numerology_calculator_date);

})(jQuery)