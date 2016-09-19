jQuery(document).ready(function() {

    if ( 	jQuery('#role').find("option:selected").attr('value') == 'kusch' )
    {
      jQuery("#kusch").show();
      jQuery("#dn").hide();
  //    jQuery("#email").parent().parent().hide();
    }
    else
    {
      jQuery("#kusch").hide();
  //    jQuery("#email").parent().parent().hide();
      if ( 	jQuery('#role').find("option:selected").attr('value') == 'dilnich' )
      jQuery("#dn").show();
      else
      {
        jQuery("#dn").hide();
        //      jQuery("#email").parent().parent().show();
      }
    }

          jQuery('#role').change(function(){
            jQuery("#email").show();
          //jQuery("#email").val("<?php echo wp_generate_password(8, false).'@'.wp_generate_password(2, false).'me.ua'; ?>");
            if ( 	jQuery(this).find("option:selected").attr('value') == 'kusch' )
            {
              jQuery("#kusch").show();
              jQuery("#dn").hide();
              jQuery("#raion").hide();

            }
            else
            {
              jQuery("#kusch").hide();
              jQuery("#raion").hide();
      //    jQuery("#email").parent().parent().hide();
              if ( 	jQuery(this).find("option:selected").attr('value') == 'dilnich' )
              jQuery("#dn").show();
              else
              {
                jQuery("#dn").hide();
                if ( 	jQuery(this).find("option:selected").attr('value') == 'raion' )
                jQuery("#raion").show();
                  //      jQuery("#email").parent().parent().show();
              }
            }
          }
        )
      });
