core = 6.x

; Contrib
projects[] = drupal
projects[admin_menu][patch][] = "http://drupal.org/files/issues/admin_menu-6.x-1.5-admin_menu.inc_.patch"
projects[] = backup_migrate
projects[] = cck
projects[context][version] = "3.0-rc1"
projects[] = ctools
projects[] = date
projects[] = devel
projects[] = features
projects[] = filefield
projects[] = gmap
projects[] = google_analytics
projects[] = install_profile_api
projects[] = imageapi
projects[] = imagecache
projects[] = imagefield
projects[] = imce
projects[] = imce_wysiwyg
projects[jquery_update][version] = "2.0-alpha1"
projects[] = jquery_ui
projects[] = link
projects[] = location
projects[] = menu_block
projects[] = menu_breadcrumb
projects[] = pathauto
projects[] = porterstemmer
projects[] = securesite
projects[] = site_map
projects[] = taxonomy_redirect
projects[] = token
projects[] = video_filter
projects[] = views
projects[] = webform
projects[] = wysiwyg
projects[] = xmlsitemap


; Custom Modules
;; RE Filter - video filter add on
projects[re_filter][type] = "module"
projects[re_filter][download][type] = "svn"
projects[re_filter][download][url] = "https://reyebrow.unfuddle.com/svn/reyebrow_refilter"
projects[re_filter][download][username] = "svnuser"
projects[re_filter][download][password] = "2kqhmv"
projects[re_filter][subdir] = "custom"
projects[re_filter][directory_name] = "re_filter"

; Themes
;; Descartes
projects[descartes][type] = "theme"
projects[descartes][download][type] = "svn"
projects[descartes][download][url] = "https://reyebrow.unfuddle.com/svn/reyebrow_descartes"
projects[descartes][download][username] = "svnuser"
projects[descartes][download][password] = "2kqhmv"
projects[descartes][directory_name] = "descartes"

; Features
;; Events
projects[re_events][type] = "module"
projects[re_events][location] = "http://fserver.raisedeyebrowclients.com/fserver"
projects[re_events][subdir] = "custom/features"

;; News
projects[re_news][type] = "module"
projects[re_news][location] = "http://fserver.raisedeyebrowclients.com/fserver/"
projects[re_news][subdir] = "custom/features"

;; Resources
projects[re_resources][type] = "module"
projects[re_resources][location] = "http://fserver.raisedeyebrowclients.com/fserver"
projects[re_resources][subdir] = "custom/features"

;; Slideshow
projects[re_slideshow][type] = "module"
projects[re_slideshow][location] = "http://fserver.raisedeyebrowclients.com/fserver"
projects[re_slideshow][subdir] = "custom/features"

;; Blog
projects[re_blog][type] = "module"
projects[re_blog][location] = "http://fserver.raisedeyebrowclients.com/fserver"
projects[re_blog][subdir] = "custom/features"

;; Image Gallery
projects[re_image_gallery][type] = "module"
projects[re_image_gallery][location] = "http://fserver.raisedeyebrowclients.com/fserver"
projects[re_image_gallery][subdir] = "custom/features"

; Libraries
;; jQuery UI
libraries[jquery_ui][download][type] = "get"
libraries[jquery_ui][download][url] = "http://jquery-ui.googlecode.com/files/jquery-ui-1.7.3.zip"
libraries[jquery_ui][directory_name] = "jquery.ui"
libraries[jquery_ui][destination] = "modules/jquery_ui"

;; TinyMCE
libraries[tinymce][download][type] = "get"
libraries[tinymce][download][url] = "http://cdnetworks-us-1.dl.sourceforge.net/project/tinymce/TinyMCE/3.3.8/tinymce_3_3_8.zip"
libraries[tinymce][directory_name] = "tinymce"