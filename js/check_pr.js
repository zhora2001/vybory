jQuery(function(){
// jQuery('#uname').change(function(){
//  jQuery(".btnsubmit").hide();
// });
  var form = jQuery(this),
                btn = form.find('.btnsubmit');

          btn.click(function(){


            form.find('.rfield').each(function(){
              var pmc = jQuery(this);
              if(pmc.val() == '')
              pmc.addClass('.empty_field');
              else
              pmc.removeClass('.emty_field');
            });
          return false;
          }
        )
      });
