var el = document.getElementById('table-config');
var sortable = Sortable.create(el);

$(".form-record").submit(function(event) {
  var data = $(this).serializeJSON({checkboxUncheckedValue: "false"});
  console.log(data);
  $.post($(this).attr('action'), data, function(result) {
    console.log(result);
  });
  event.preventDefault();
});