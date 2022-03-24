export const baseURL = 'http://localhost:8080/sistema/';

export const server = axios.create({
  baseURL: baseURL,
  timeout: 1000,
  headers: {
    'X-Custom-Header': 'Harllei',
    'Token': 'Bearer kjsalf0q398kjlafkjas0r98q3ojflçsakdjfsjfsof0w9fksdf'
  }
});

export function initializeTableRecords() {
  let tables = [];

  $('.table-records').each(function (index, table) {
    let tableRecordsName  = $(table).data('tablename');
    let tableRecordsUrl   = $(table).data('url');

    console.log(tableRecordsUrl);
  
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
      text: '<i class="fal fa-times-circle mr-2"></i>Excluir',
      className: 'btn btn-danger',
      action: function ( e, dt, node, config ) {
        let url = `${tableRecordsUrl}/delete`;
        console.log(url);
      }
    }];
  
    tables[index] = $(table).dataTable({
      responsive: true,
      language: {
        url: '/localisation/datatables_pt_br.json'
      },
      dom: "<'row mb-3'<'col-sm-12 col-md-4 d-flex align-items-center justify-content-start'B><'col-sm-12 col-md-4 d-flex align-items-center justify-content-start'f><'col-sm-12 col-md-4 d-flex align-items-center justify-content-end'l>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
      buttons: tableRecordsButtons
    });
  });
}