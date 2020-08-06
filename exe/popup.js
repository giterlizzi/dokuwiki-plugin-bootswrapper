
jQuery(document).ready(function() {

jQuery('.help-btn').on('click', function(e) {
  jQuery('#help-modal .modal-body').load(jQuery(this).data('help'), function(){
    jQuery.getScript('../script.js');
  });
});

var $component = jQuery('#component'),
    $output    = jQuery('#output'),
    $preview   = jQuery('#preview');

$component.val(jQuery('ul.nav .active a').data('component'));

jQuery('ul.nav a').on('click', function() {

  $component.val(jQuery(this).data('component'));
  jQuery('.preview-box').removeClass('hide');

  jQuery(document).trigger('popup:reset');
  jQuery(document).trigger('popup:buildTag');

});

jQuery(document).on('popup:reset', function() {
  jQuery('form').each(function(){
    jQuery(this)[0].reset();
  });
  $output.val('');
  $preview.text('');
});

jQuery(document).on('popup:buildTag', function() {

  var component = $component.val(),
      tag       = [ '<', component ];

  jQuery('#tab-'+component+' .attribute').each(function() {

    var $attribute = jQuery(this),
        data       = $attribute.data();

    if (data.attributeType == 'boolean') {
      if ($attribute.find('input:checked').val()) {
        tag.push(' '+ data.attributeName + '="true"');
      }
    } else {
      if ($attribute.find('input,select').val()) {
        tag.push(' '+ data.attributeName + '="' + $attribute.find('input,select').val() + '"');
      }
    }

  });

  tag.push('></'+component+'>');

  $output.val(tag.join(''));
  $preview.text(tag.join(''));

});

jQuery('#btn-reset').on('click', function() {
  jQuery(document).trigger('popup:reset');
  jQuery(document).trigger('popup:buildTag');
});

jQuery('form input,form select').on('change', function() {
  jQuery(document).trigger('popup:buildTag');
});

jQuery('#btn-preview, #btn-insert').on('click', function() {

  jQuery(document).trigger('popup:buildTag');

  if (jQuery(this).attr('id') === 'btn-insert') {
    opener.insertAtCarret('wiki__text', $output.val());
    opener.focus();
  }

});

});