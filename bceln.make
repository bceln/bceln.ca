

; Core

core = 7.x
api = 2
projects[drupal] = 7.38


; Modules

projects[admin_menu] = 3.0-rc5
projects[admin_views] = 1.5
projects[auto_nodetitle] = 1.0
projects[backup_migrate] = 2.8
projects[better_formats] = 1.0-beta1
projects[boxes] = 1.2
projects[captcha] = 1.3
projects[cck] = 2.x-dev

;projects[cck_select_other] = 1.1+3-dev
projects[cck_select_other][type] = module
projects[cck_select_other][download][type] = file
projects[cck_select_other][download][url] = http://cgit.drupalcode.org/cck_select_other/snapshot/538b368e798526e1d888e307a8ad937cd6294c8f.tar.gz

projects[chosen] = 2.0-beta4
projects[ckeditor] = 1.16
projects[cmf] = 1.x-dev
projects[content_access] = 1.2-beta2
projects[context] = 3.6

;projects[context_reaction_theme] = 1.x-dev
projects[context_reaction_theme][type] = module
projects[context_reaction_theme][download][type] = file
projects[context_reaction_theme][download][url] = http://cgit.drupalcode.org/context_reaction_theme/snapshot/9e119e080b3f61df50c9190ba69fea5f9b141579.tar.gz

projects[ctools] = 1.7
projects[custom_search] = 1.18
projects[date] = 2.9
projects[devel] = 1.5
projects[disable_term_node_listings] = 1.2
projects[ds] = 2.11
projects[editablefields] = 1.0-alpha2
projects[editableviews] = 1.0-beta10
projects[email_registration] = 1.2
projects[entity] = 1.6
projects[entityreference] = 1.1
projects[environment_indicator] = 2.7
projects[features] = 2.3
projects[feeds] = 2.0-alpha8
projects[feeds_node_helper] = 1.4
projects[feeds_ridmap] = 1.x-dev
projects[feeds_tamper] = 1.0-beta5
projects[field_collection] = 1.0-beta8
projects[field_group] = 1.4
projects[field_permissions] = 1.0-beta2
projects[getid3] = 1.0
projects[gmap] = 2.9
projects[google_analytics] = 1.4
projects[imagefield_crop] = 1.1
projects[imce] = 1.9
projects[imce_wysiwyg] = 1.0
projects[invisimail] = 1.2
projects[job_scheduler] = 2.0-alpha3
projects[jquery_update] = 2.6
projects[libraries] = 2.2
projects[link] = 1.3
projects[location] = 3.6
projects[location_feeds] = 1.6
projects[login_destination] = 1.1
projects[menu_block] = 2.5
projects[menu_trail_by_path] = 2.0
projects[metatag] = 1.4
projects[migrate] = 2.8
projects[migrate_extras] = 2.5
projects[module_filter] = 2.0
projects[multiselect] = 1.10
projects[node_clone] = 1.0-rc2
projects[og] = 2.2

;projects[pagepreview] = 1.x-dev
projects[pagepreview][type] = module
projects[pagepreview][download][type] = file
projects[pagepreview][download][url] = http://cgit.drupalcode.org/pagepreview/snapshot/0591998ca2884bd45014af914785a96e51c2aa87.tar.gz

projects[panels] = 3.4
projects[pathauto] = 1.2
projects[print] = 1.3
projects[profile2] = 1.3
projects[redirect] = 1.0-rc3
projects[references] = 2.1
projects[responsive_menus] = 1.5
projects[rules] = 2.9
projects[securesite] = 2.0-beta3
projects[semanticviews] = 1.0-rc2

;projects[signup] = 1.x-dev
projects[signup][type] = module
projects[signup][download][type] = file
projects[signup][download][url] = http://cgit.drupalcode.org/signup/snapshot/e5acdd339467c5bacda28f63d5e809627cc6bdc2.tar.gz

projects[site_map] = 1.2
projects[smtp] = 1.2
projects[token] = 1.6
projects[uuid] = 1.0-alpha6
projects[video_filter] = 3.1
projects[views] = 3.11
projects[views_block_area] = 1.1
projects[views_bulk_operations] = 3.3
projects[views_php] = 1.0-alpha1
projects[webform] = 3.24
projects[wysiwyg] = 2.2
projects[xmlsitemap] = 2.2


; Themes

projects[bootstrap] = 3.0
projects[multipurpose_zymphonies_theme] = 1.0
projects[omega] = 4.4
projects[startupgrowth_lite] = 1.0


; Libraries

; TinyMCE 3.3.8
libraries[tinymce][download][type] = get
libraries[tinymce][download][url] = https://github.com/tinymce/tinymce/archive/3.3.8.zip

; Zurb Foundation 3.2.5
libraries[foundation][download][type] = get
libraries[foundation][download][url] = http://foundation5.zurb.com/cdn/releases/foundation-3.2.5.zip

; Amazon S3 PHP Class 0.5.0-dev
libraries[s3-php5-curl][download][type] = get
libraries[s3-php5-curl][download][url] = https://github.com/tpyo/amazon-s3-php-class/archive/390ea1a454456d27784fa01264d34ed13c57a95a.zip

; league/csv 7.1.2 (Composer library)
libraries[league_csv][download][type] = get
libraries[league_csv][download][url] = https://github.com/thephpleague/csv/archive/7.1.2.zip
