jQuery(function(){

          jQuery('#role').change(function(){
            if ( 	jQuery(this).find("option:selected").attr('value') == 'kusch' )
            {
              jQuery("#kusch").show();
              jQuery("#dn").hide();
//    jQuery("#email").parent().parent().hide();
            }
            else
            {
              jQuery("#kusch").hide();
              jQuery("#email").parent().parent().hide();
              if ( 	jQuery(this).find("option:selected").attr('value') == 'dilnich' )
              jQuery("#dn").show();
              else
              {
                jQuery("#dn").hide();
                //      jQuery("#email").parent().parent().show();
              }
            }
          }
        )
      });
