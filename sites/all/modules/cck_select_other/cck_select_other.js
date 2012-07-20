
/**
 *  cck_select_other javascript file 
 */

var cckSelectOther = {};

Drupal.behaviors.cckSelectOther = function (context) {

  var field_str = new String(Drupal.settings.CCKSelectOther.field);
  var fields = new Array();
  fields = field_str.split(',');

  // i is our index
  for (i in fields) {
    var field = fields[i].replace(/_/g, '-');

    // @todo selectId and inputId may be modified, as seen in flexifield
    var selectId = 'edit-field-' + field + '-select-other-list';
    var inputId = 'edit-field-' + field + '-select-other-text-input-wrapper';
    var value = $('#' + selectId + ' option:selected').val();

    // if value == other then display as block else don't display
    $('#' + inputId).css('display', (value == "other") ? 'block' : 'none');

    $.browser.msie == true ? $('#' + selectId).click(cckSelectOther.switchField) : $(this).change(cckSelectOther.switchField);
  }

}

cckSelectOther.switchField = function () {
  var field_str = new String(Drupal.settings.CCKSelectOther.field);
  var fields = new Array();
  fields = field_str.split(',');

  for (i in fields) {
    var field = fields[i].replace(/_/g, '-');

    // @todo selectId and inputId may be modified, as seen in flexifield
    var selectId = 'edit-field-' + field + '-select-other-list';
    var inputId = 'edit-field-' + field + '-select-other-text-input-wrapper';
    var value = $('#' + selectId + ' option:selected').val();

    // if value == other then display as block else don't display
    $('#' + inputId).css('display', (value == "other") ? 'block' : 'none');
  }
}
