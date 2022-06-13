import * as config from './config.js';

export const baseURL = config.baseURL;

export const cookies = Cookies;

export const server = axios.create({
  baseURL: baseURL,
  timeout: 1000,
  headers: {
    'x-api-key': config.apiKey,
    'x-client-type': config.clientType,
  }
});

const requestHandler = request => {
  // Token will be dynamic so we can use any app-specific way to always   
  // fetch the new token before making the call
  request.headers.Authorization = 'Bearer ' + cookies.get('token');
  return request;
};

const responseHandler = response => {
  if (response.status === 401) {
    window.location = baseURL + '/login';
  }
  return response;
};

const errorHandler = error => {
  return Promise.reject(error);
};

server.interceptors.request.use(
  (request) => requestHandler(request),
  (error) => errorHandler(error)
);

server.interceptors.response.use(
  (response) => responseHandler(response),
  (error) => errorHandler(error)
);

export const tableRecordsButtons = {
  new: function(table) {
    let buttonNew = {
      text: '<i class="fa fa-file mr-2"></i>Novo',
      className: 'btn btn-primary',
      action: function ( e, dt, node, config ) {
        //let url = `${tableRecordsUrl}/new`;
        let url = `${$(table).data('url')}/new`;
        $(location).attr('href', url);
      }
    }
    return buttonNew;
  },
  upload: function(table) {
    let buttonUpload = {
      text: '<i class="fa fa-upload mr-2"></i>Upload',
      className: 'btn btn-primary',
      action: function ( e, dt, node, config ) {
        $('#modal_arquivo').modal('show');
      }
    }
    return buttonUpload;
  },
  delete: function(table) {
    let buttonDelete = {
      text: '<i class="fa fa-times-circle mr-2"></i>Excluir',
      className: 'btn btn-danger',
      action: function ( e, dt, node, config ) {
        //let url = `${tableRecordsUrl}/delete`;
        let url = `${$(table).data('url')}/delete`;
      }
    }
    return buttonDelete;
  },
};

export async function initializeTableRecords(table, buttons) {
  return new Promise (async function(resolve, reject) {
    let tb;
    let tableID           = $(table).attr('id');
    let tableRecordsName  = $(table).data('tablename');
    let tableRecordsUrl   = $(table).data('url');

    async function getColumns(url) { 
      return await $.ajax({
        url: url,
        type: 'POST',
        dataType: 'json'
      });
    };
  
    tb = await $('.table-records').DataTable({
      responsive: true,
      processing: true,
      serverSide: true,
      stateSave: true,
      ajax: {
        url: tableRecordsUrl + '/searchDataTables',
        type: 'POST',
        dataType: 'json'
      },
      columns: await getColumns(tableRecordsUrl + '/dataTablesColumns'),
      language: {
        url: '/localisation/datatables_pt_br.json'
      },
      dom: "<'row mb-3'<'col-sm-12 col-md-4 d-flex align-items-center justify-content-start'B><'col-sm-12 col-md-4 d-flex align-items-center justify-content-start'f><'col-sm-12 col-md-4 d-flex align-items-center justify-content-end'l>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
      buttons: buttons
    });

    resolve (tb);
    reject (null);
  })
}

export function showLoadingDialog() {
  var dialog = bootbox.dialog({
    message: '<div class="spinner-border spinner-border-sm p-0 m-0" role="status"></div><span class="ml-2 mb-0 pb-0">Executando...</span>',
    centerVertical: true,
    closeButton: false,
    size: 'small',
    animate: false,
  });

  return dialog;
}

export function hideLoadingDialog(dialog) {
  dialog.modal('hide');
}