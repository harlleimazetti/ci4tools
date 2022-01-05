export function notify(messages, type) {
  switch (type) {
    case 'info':
      $.notify(messages.join(), {type: 'info', align:"left", verticalAlign:"bottom"});
      break;
    case 'error':
      $.notify(messages.join(), {type: 'danger', align:"right", verticalAlign:"top"});
      break;
    default:
      $.notify(messages.join(), {type: 'info', align:"left", verticalAlign:"top"});
  }
}

export function highlightFieldsError(errors) {
  console.log(errors);
  $.each(errors, function(field, error) {
    $('#' + field).addClass('border-danger');
    $('#' + field).siblings('span').addClass('color-danger').html(error);
  });
}

export function unHighlightFieldsError() {
  $('input.border-danger').siblings('span').removeClass('color-danger').html('');
  $('input.border-danger').removeClass('border-danger');
}