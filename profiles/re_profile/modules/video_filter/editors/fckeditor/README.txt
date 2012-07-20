
##############################################
## ONLY if you use fckeditor WITHOUT wysiwyg ##
##############################################

Installation:

Do the following steps to add Video filter button to the FCKeditor toolbar:

   1. Open /drupal/modules/fckeditor/fckeditor.config.js

   2. Add this BEFORE the first "FCKConfig.ToolbarSets" array.
     
      var video_filter_basePath = '/' // Change this if you have drupal installed in a subdir

      var video_filter_url_fckeditor = 'admin/video_filter/dashboard/fckeditor'; // DO NOT CHANGE
      FCKConfig.Plugins.Add( 'video_filter', null, video_filter_basePath + 'sites/all/modules/video_filter/editors/fckeditor/') ; // DO NOT CHANGE

   3. Add button to the toolbar. The button name is: video_filter
      For example if you have a toolbar with an array of buttons defined as follows:

      ['video_filter','Unlink','Anchor'],

      simply add the button somewhere in the array:

      ['video_filter','Link','Unlink','Anchor'],

      (remember about single quotes).