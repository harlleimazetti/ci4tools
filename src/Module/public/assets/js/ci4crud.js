export const baseURL = 'http://localhost/danms/appweb/';

export const cookies = Cookies;

export const server = axios.create({
  baseURL: baseURL,
  timeout: 1000,
  headers: {
    'x-api-key': '',
    'x-client-type': 'appweb',
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

export function initializeTableRecords() {
  let tables = [];

  $('.table-records').each(async function (index, table) {
    let tableRecordsName  = $(table).data('tablename');
    let tableRecordsUrl   = $(table).data('url');

    function getColumns(url) { 
      return $.ajax({
        url: url,
        type: 'POST',
        dataType: 'json'
      });
    };

    var columns = await getColumns(tableRecordsUrl + '/dataTablesColumns');
    
    console.log(tableRecordsUrl);
    console.log(columns);

    let tableRecordsButtons = [{
      text: '<i class="fal fa-file mr-2"></i>Novo',
      className: 'btn btn-primary',
      action: function ( e, dt, node, config ) {
        let url = `${tableRecordsUrl}/new`;
        console.log(url);
        $(location).attr('href', url);
      }
    },
    {
      text: '<i class="fal fa-upload mr-2"></i>Upload',
      className: 'btn btn-primary',
      action: function ( e, dt, node, config ) {
        $('#modal_arquivo').modal('show');
      }
    },
    {
      text: '<i class="fal fa-times-circle mr-2"></i>Excluir',
      className: 'btn btn-danger',
      action: function ( e, dt, node, config ) {
        let url = `${tableRecordsUrl}/delete`;
        console.log(url);
      }
    }];
  
    tables[index] = $(table).dataTable({
      responsive: true,
      serverSide: true,
      ajax: {
        url: tableRecordsUrl + '/searchDataTables',
        type: 'POST'
      },
      columns: columns,
      language: {
        url: '/localisation/datatables_pt_br.json'
      },
      dom: "<'row mb-3'<'col-sm-12 col-md-4 d-flex align-items-center justify-content-start'B><'col-sm-12 col-md-4 d-flex align-items-center justify-content-start'f><'col-sm-12 col-md-4 d-flex align-items-center justify-content-end'l>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
      buttons: tableRecordsButtons
    });
  });
}