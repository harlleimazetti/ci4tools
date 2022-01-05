import { initializeTableRecords, serverAdmin } from './ci4crud.js';
import { notify, unHighlightFieldsError, highlightFieldsError} from './utils.js';

$(document).ready(function() {

  var el = document.getElementById('table-config');
  var sortable = Sortable.create(el);

  $(".form-record").submit(function(event) {
    var data = $(this).serializeJSON({checkboxUncheckedValue: "false"});
    console.log(data);
    $.post($(this).attr('action'), data, function(result) {
      console.log(result);
      if (result.success === true) {
        notify(result.messages, 'info');
      } else {
        notify(result.messages, 'error');
      }
    });
    event.preventDefault();
  });
 
  $(function() {
    $('.select2').select2();
  })

  var tableRecords = initializeTableRecords();

  //console.log(tableRecords);
  
  /*
  $(".form-record").submit(function(event) {
    event.preventDefault();

    unHighlightFieldsError();

    var url = $(this).attr('action');
    //var formData = new FormData(this);
    var formData = $(this).serializeJSON({checkboxUncheckedValue: "false"});

    console.log(formData);

    serverAdmin.post(url, formData)
      .then(response => {
        console.log(response);
        notify(response.data.messages, 'info');
      })
      .catch(error => {
        if (error.response) {
          // The request was made and the server responded with a status code
          // that falls out of the range of 2xx
          console.log(error.response.data);
          console.log(error.response.status);
          console.log(error.response.headers);
          notify(error.response.data.messages.error.messages, 'error');
          highlightFieldsError(error.response.data.messages.error.errors);
        } else if (error.request) {
          // The request was made but no response was received
          // `error.request` is an instance of XMLHttpRequest in the browser and an instance of
          // http.ClientRequest in node.js
          console.log(error.request);
        } else {
          // Something happened in setting up the request that triggered an Error
          console.log('Error', error.message);
        }
      });

    return false;
  });
  */
  /*
  $('.file-upload').on('click', function() {
    //console.log('clicou');
    //$('#file-upload-status').hide();
    //$('#file-upload-progress .progress-bar').css('width', '0%');
    //$('#file-upload-progress').show();
  });

  $('.file-upload').fileupload({
    dataType: 'json',
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
    /*
    progressall: function (e, data) {
      var progress = parseInt(data.loaded / data.total * 100, 10);
      $('#file-upload-progress .progress-bar').css('width', progress + '%');
    },
    */
    /*
    stop: function (e) {
      $('#file-upload-status').html(' <i class="fa fa-check"></i> Concluído').show();
      $('#file-upload-progress').hide();
      //atualiza_tabela_registros();
    },
    done: function (e, data) {
      response = data.result;
      if (response.status == 'ok') {
        toastr.info(response.mensagem);
      } else {
        toastr.error(response.mensagem);
      }
    }
  });
  */
});