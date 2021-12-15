var el = document.getElementById('table-config');
var sortable = Sortable.create(el);

$(".form-record").submit(function(event) {
  var data = $(this).serialize();
  console.log(data);
  event.preventDefault();
});