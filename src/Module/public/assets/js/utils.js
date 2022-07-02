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
    $('#' + field).siblings('span').find('.select2-selection').addClass('border-danger');
    $('#' + field).siblings('span.help-block').addClass('text-danger').html(error);
  });
}

export function unHighlightFieldsError() {
  $('input.border-danger').removeClass('border-danger');
  $('.select2-selection').removeClass('border-danger');
  $('span.help-block').removeClass('text-danger').html('');
}