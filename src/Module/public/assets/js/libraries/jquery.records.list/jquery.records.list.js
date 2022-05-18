/*
await $('.records-list').each(async function (index, list) {
  var $recordList = $(list);
  var $recordListItemTemplate = $recordList.find('.records-list-item-template');
  $.ajax({
    url: $recordList.data('url') + '/search',
    type: 'post',
    dataType: 'json'
  }).then(function(data) {
    data.map(function (record) {
      var fields = Object.keys(record);
      var $recordsListItem = $recordListItemTemplate.clone();
      $recordListItemTemplate.remove();
      fields.map(function (field, index) {
        $recordsListItem.children().find(`[data-field='${field}']`).html(record[field]);
      });
      $recordList.append($recordsListItem);
    });
  });
});
*/

(function ( $ ) {
  $.fn.recordsList = function(options) {
    var settings = $.extend({
      recordsListItemTemplate: ".records-list-item-template",
    }, options );

    return this.each(function(index, list) {
      var $recordList = $(this);
      var $recordListItemTemplate = $recordList.find('.records-list-item-template');
      $.ajax({
        url: $recordList.data('url') + '/search',
        type: 'post',
        dataType: 'json'
      }).then(function(data) {
        data.map(function (record) {
          var fields = Object.keys(record);
          var $recordsListItem = $recordListItemTemplate.clone();
          $recordListItemTemplate.remove();
          fields.map(function (field, index) {
            $recordsListItem.children().find(`[data-field='${field}']`).html(record[field]);
          });
          $recordList.append($recordsListItem);
        });
      });
    });

  };

}( jQuery ));