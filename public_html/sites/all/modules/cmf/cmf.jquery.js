if (Drupal.jsEnabled) {
  $(function() {
    //alert('cmf.jquery.js file active');

    $('#cmf-filter-form select, #cmf-filter-form input').change(function(){
      var id = $(this).attr('id');
      if(id.substring(0,13) == 'edit-created-'){
        if(id.substring(13,18) == 'after'){
          id = 'edit-filter-created-after';
        }else{
          id = 'edit-filter-created-before';
        }
      }else{
        id = id.replace('edit-','edit-filter-');
      }
      $('#'+id).click();
    });
    
  });

}