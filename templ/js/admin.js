jQuery(function(){
jQuery('#role').change(function(){
       if ( 	jQuery(this).find("option:selected").attr('value') == 'kusch' )
  {
    jQuery("#kusch").show();
    jQuery("#dn").hide();
  }
  else
  {
    jQuery("#kusch").hide();
         if ( 	jQuery(this).find("option:selected").attr('value') == 'dilnich' )
      jQuery("#dn").show();
  else
      jQuery("#dn").hide();
  }
  }
  )
});
