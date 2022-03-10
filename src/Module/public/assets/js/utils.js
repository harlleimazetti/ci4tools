export function notify(messages, type) {
  switch (type) {
    case 'info':
      toastr.info(messages);;
      break;
    case 'error':
      toastr.error(messages);
      break;
    default:
      toastr.info(messages);
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