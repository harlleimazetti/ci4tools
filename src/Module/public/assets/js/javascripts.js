import {
  initializeTableRecords,
  tableRecordsButtons,
  server,
  cookies,
  baseURL,
  showLoadingDialog,
  hideLoadingDialog
} from './ci4crud.js';

import {
  notify,
  unHighlightFieldsError,
  highlightFieldsError
} from './utils.js';

$(document).ready(async function() {

  (function ( $ ) {
    $.fn.recordsList = function(options) {
      var settings = $.extend({
        template: ".records-list-item-template",
        form: ".records-list-form",
        itemsContainer: ".records-list-items-container",
        prevElement: '.records-list-prev',
        nextElement: '.records-list-next',
        refreshElement: '.records-list-refresh',
      }, options );

      String.prototype.interpolate = function(params) {
        const names = Object.keys(params);
        const vals = Object.values(params);
        return new Function(...names, `return \`${this}\`;`)(...vals);
      }

      function QueryStringToJSON(qs) {            
        var pairs = qs.slice(1).split('&');
        
        var result = {};
        pairs.forEach(function(pair) {
            pair = pair.split('=');
            result[pair[0]] = decodeURIComponent(pair[1] || '');
        });
    
        return JSON.parse(JSON.stringify(result));
      }

      return this.each(function(index, list) {
        var $this = $(this);

        var $recordList = $(list);

        var $recordListContainer = $recordList.find(settings.itemsContainer);
        var $recordListForm = $recordList.find(settings.form);
        var $recordListItemTemplate = $recordList.find(settings.template);
        var $recordListItem = $recordListItemTemplate.clone();
        var $htmlTemplate = $recordListItem.prop('outerHTML');

        var $prevButton = $recordList.find(settings.prevElement);
        var $nextButton = $recordList.find(settings.nextElement);
        var $refreshButton = $recordList.find(settings.refreshElement);

        $recordListItemTemplate.remove();

        $this.on('prev', function() {
          console.log('Prev');
          $prevButton.trigger('click');
        })

        $this.on('next', function() {
          console.log('Next');
          $nextButton.trigger('click');
        })

        $this.on('refresh', function() {
          console.log('PrevRefresh');
          $refreshButton.trigger('click');
        })

        $prevButton.on('click', function () {
          var $page = $recordListForm.find('#page').val();
          $page--;
          $page < 0 ? $page = 0 : $page;
          $recordList.data('page', $page);
          $recordListForm.find('#page').val($page);
          var params = $recordListForm.serialize();
          var filters = $recordListForm.find('.records-filter').serializeArray();
          console.log('Prev', params);
          console.log('Prev', filters);
          refreshRecordList(params, filters);
        })

        $nextButton.on('click', function () {
          var $page = $recordListForm.find('#page').val();
          $page++;
          var $max_page = $recordListForm.find('#max_page').val();
          $page > $max_page ? $page = $max_page : $page;
          $recordList.data('page', $page);
          $recordListForm.find('#page').val($page);
          var params = $recordListForm.serialize();
          var filters = $recordListForm.find('.records-filter').serializeArray();
          console.log('Next', params);
          console.log('Next', filters);
          refreshRecordList(params, filters);
        })

        $refreshButton.on('click', function () {
          var $page = $recordListForm.find('#page').val();
          var $max_page = $recordListForm.find('#max_page').val();
          $page > $max_page ? $page = $max_page : $page;
          $recordList.data('page', $page);
          $recordListForm.find('#page').val($page);
          var params = $recordListForm.serialize();
          var filters = $recordListForm.find('.records-filter').serializeArray();
          console.log('Refresh', params);
          console.log('Params', filters);
          refreshRecordList(params, filters);
        })

        function refreshRecordList(params, filters) {
          //var loadingDialog = showLoadingDialog();
          params = QueryStringToJSON(params);
          $.ajax({
            url: $recordList.data('url') + '/search',
            type: 'post',
            dataType: 'json',
            data: {...params, filters }
          }).then(function(data) {
            $recordListContainer.empty();
            data.map(function (record) {
              $recordListItem = $htmlTemplate.interpolate({record});
              $recordListContainer.append($recordListItem);
            });
            //hideLoadingDialog(loadingDialog);
          });
        }
      });
  
    };
  
  }( jQuery ));

  $(function() {
    $('.select2').select2();
  })

  let tableRecords = [];

  await $('.table-records').each(async function (index, table) {
    initializeTableRecords(table, [tableRecordsButtons.new(table), tableRecordsButtons.delete(table)])
      .then ((tableRecord) => {
        tableRecords[index] = tableRecord;
      })
  });

  var lists = await $('.records-list').recordsList({
    template: ".records-list-item-template",
  });

  //$(lists).trigger('refresh');

  await $('#image-upload').each(async function (index, table) {
    $.uploadPreview({
      input_field: "#image-upload",   // Default: .image-upload
      preview_box: "#image-preview",  // Default: .image-preview
      label_field: "#image-label",    // Default: .image-label
      label_default: "Selecionar imagem",   // Default: Choose File
      label_selected: "Alterar imagem",  // Default: Change File
      no_label: false                 // Default: false
    });
  })

  /*
  $("#btn-login").click(function(event) {
    event.preventDefault();
    $("#form-login").trigger("submit");
  })
  */

  $("#form-login").submit(function(event) {
    event.preventDefault();
    console.log('submit login');

    unHighlightFieldsError();

    var url = $(this).attr('action');
    var formData = new FormData(this);
    var dataForm = $(this).serialize();

    console.log(url);

    $.ajax({
      url: url,
      type: 'post',
      dataType: 'json',
      data: dataForm
    }).done(function(response,textStatus, jqXHR){
      console.log(response);
      notify(response.message, 'info');
      cookies.set('token', response.token);
      window.location.href = baseURL + 'sistema/dashboard';
    }).fail(function(jqXHR, textStatus, errorThrown){
      //code to handle error here.
      console.log(jqXHR);
      console.log(textStatus);
      console.log(errorThrown);
      notify(jqXHR.responseJSON.message, 'error');
      highlightFieldsError(jqXHR.errors);
    }).always(function(jqXHR, textStatus, errorThrown){
      //this code will always execute regardless
      //of whether the done or error method executes
    });

    return false;

    server.post(url, formData)
      .then(response => {
        console.log(response);
        notify(response.data.message, 'info');
        cookies.set('token', response.data.token);
        window.location.href = baseURL + 'sistema/dashboard';
      })
      .catch(error => {
        if (error.response) {
          // The request was made and the server responded with a status code
          // that falls out of the range of 2xx
          console.log(error.response.data);
          console.log(error.response.status);
          console.log(error.response.headers);
          notify(error.response.data.message, 'error');
          highlightFieldsError(error.response.data.errors);
        } else if (error.request) {
          // The request was made but no response was received
          // `error.request` is an instance of XMLHttpRequest in the browser and an instance of
          // http.ClientRequest in node.js
          console.log('Error request')
          console.log(error.request);
        } else {
          // Something happened in setting up the request that triggered an Error
          console.log('General Error')
          console.log('Error', error.message);
        }
      });

    return false;
  });

  $(document).on("click",".btn-record-delete", function() {
    var recordId = $(this).data('id');
    var url = $(this).closest('.table-records').data('url');
    var dialog = bootbox.dialog({
      title: 'Excluir registro(s)',
      message: '<div class="alert alert-danger" role="alert"><p class="m-0"><strong>ATENÇÃO!</strong> O registro e todos os dados relacionados a ele serão definitivamente excluídos. Não é possível desfazer essa ação.</p></div>',
      size: 'default',
      buttons: {
        cancel: {
          label: "Cancelar",
          className: 'btn-default',
          callback: function() {
            console.log('Cancel Delete');
          }
        },
        ok:{
          label: "Excluir registro(s)",
          className: 'btn-danger',
          callback: async function() {
            console.log('Delete Record ID: ' + recordId);
            console.log('URL: ' + url);
            await recordDelete(recordId, url + '/erase');
          }
        }
      }
    });
  });

  function recordDelete(id, url) {
    var loadingDialog = showLoadingDialog();
    $.ajax({
      url: url,
      type: 'post',
      dataType: 'json',
      data: {id: id}
    }).done(function(response, textStatus, jqXHR){
      console.log(response);
      notify(response.messages, 'info');
    }).fail(function(jqXHR, textStatus, errorThrown){
      //code to handle error here.
      console.log(jqXHR);
      console.log(textStatus);
      console.log(errorThrown);
      notify(jqXHR.responseJSON.messages, 'error');
      highlightFieldsError(jqXHR.errors);
    }).always(async function(jqXHR, textStatus, errorThrown){
      //this code will always execute regardless
      //of whether the done or error method executes
      await refreshPageState();
      hideLoadingDialog(loadingDialog);
    });
  }

  function refreshPageState() {
    console.log('Refresh Datatables');
    tableRecords.map((tableRecord) => {
      tableRecord.ajax.reload( null, false );
    })
  }

  $(".form-record").submit(function(event)
  {
    console.log('Submit Form Record');
    event.preventDefault();
    unHighlightFieldsError();
    var loadingDialog = showLoadingDialog();

    var url = $(this).attr('action');
    var formData = new FormData(this);
    var dataForm = $(this).serialize();

    $.ajax({
      url: url,
      type: 'post',
      //dataType: 'json',
      data: formData,
      processData: false,
      contentType: false,
    }).done(function(response, textStatus, jqXHR){
      console.log(response);
      $('#id').val(response.record.id);
      notify(response.messages, 'info');
    }).fail(function(jqXHR, textStatus, errorThrown){
      console.log(jqXHR);
      console.log(textStatus);
      console.log(errorThrown);
      notify(jqXHR.responseJSON.messages.error.messages, 'error');
      highlightFieldsError(jqXHR.responseJSON.messages.error.errors);
    }).always(function(jqXHR, textStatus, errorThrown){
      hideLoadingDialog(loadingDialog);
    });

    return false;
  });

  $(".form-ajax").submit(function(event)
  {
    console.log('Submit Ajax Form');
    event.preventDefault();
    unHighlightFieldsError();
    var loadingDialog = showLoadingDialog();

    var url = $(this).attr('action');
    var formData = new FormData(this);
    var dataForm = $(this).serialize();

    $.ajax({
      url: url,
      type: 'post',
      //dataType: 'json',
      data: formData,
      processData: false,
      contentType: false,
    }).done(function(response, textStatus, jqXHR){
      console.log(response);
      notify(response.messages, 'info');
    }).fail(function(jqXHR, textStatus, errorThrown){
      console.log(jqXHR);
      console.log(textStatus);
      console.log(errorThrown);
      notify(jqXHR.responseJSON.messages, 'error');
      highlightFieldsError(jqXHR.responseJSON.errors);
    }).always(function(jqXHR, textStatus, errorThrown){
      hideLoadingDialog(loadingDialog);
    });

    return false;

    server.post(url, formData)
      .then(response => {
        console.log(response);
        notify(response.data.messages, 'info');
      })
      .catch(error => {
        if (error.response) {
          // The request was made and the server responded with a status code
          // that falls out of the range of 2xx
          console.log(error.response.data);
          notify(error.response.data.messages, 'error');
          highlightFieldsError(error.response.data.errors);
        } else if (error.request) {
          // The request was made but no response was received
          // `error.request` is an instance of XMLHttpRequest in the browser and an instance of
          // http.ClientRequest in node.js
          console.log(error.request);
        } else {
          // Something happened in setting up the request that triggered an Error
          console.log('Error', error.message);
        }
      })
      .finally(() => {
        hideLoadingDialog(loadingDialog);
      });
    return false;
  });
  
  $('.file-upload').on('click', function() {
    //console.log('clicou');
    //$('#file-upload-progress').hide();
    //$('#file-upload-list').show();
    /*
    $('.file-upload-status').html('Selecione o(s) arquivo(s)').show();
    $('.file-upload-progress .progress-bar').css('width', '0%');
    $('.file-upload-progress').show();
    */
  });

  $('.file-upload').fileupload({
    dataType: 'json',
    /*
    add: function(e, data) {
      var html = '<div class="progress progress-sm mt-1"><div class="progress-bar bg-warning-50" role="progressbar" style="width: 0%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div></div>'
      data.context = $('<span class="file"></span>')
        //.append($(html).text(data.files[0].name))
        .append($(html))
        .appendTo(document.getElementById('file-upload-list'));
      data.submit();
    },
    progress: function(e, data) {
      var progress = parseInt((data.loaded / data.total) * 100, 10);
      data.context.find('.progress').find('.progress-bar').css('width', progress + '%');
    },
    */
    add: function(e, data) {
      //$('.file-upload-status').html('Selecione o(s) arquivo(s)').show();
      $('.file-upload-progress .progress-bar').css('width', '0%');
      $('.file-upload-progress').show();
      data.submit();
    },
    progressall: function (e, data) {
      var progress = parseInt(data.loaded / data.total * 100, 10);
      $('.file-upload-progress .file-upload-status').html('Transferindo (' + progress + '%)').show();
      $('.file-upload-progress .progress-bar').css('width', progress + '%');
    },
    stop: function (e) {
      $('.file-upload-progress .file-upload-status-icon').html('<i class="fa fa-check fs-xl"></i>').show();
      $('.file-upload-progress .file-upload-status').html('Concluído').show();
      $('.file-upload-progress').delay(3000).fadeOut();
      notify('Transferência completa', 'info');
      //$('.file-upload-progress .progress-bar').hide();
      //atualiza_tabela_registros();
    },
    done: function (e, data) {
      console.log(data.jqXHR.responseJSON);
      var response = data.jqXHR.responseJSON;
      //notify(response.messages, 'info');
    },
    error: function (jqXHR, textStatus, errorThrown) {
      var response = jqXHR.responseJSON;
      console.log(response);
      notify(response.messages, 'error');
    }
  });

  $('.js-thead-colors a').on('click', function() {
    var theadColor = $(this).attr("data-bg");
    console.log(theadColor);
    $('#dt-basic-example thead').removeClassPrefix('bg-').addClass(theadColor);
  });

  $('.js-tbody-colors a').on('click', function() {
    var theadColor = $(this).attr("data-bg");
    console.log(theadColor);
    $('#dt-basic-example').removeClassPrefix('bg-').addClass(theadColor);
  });

});