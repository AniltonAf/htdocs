

var $ = jQuery.noConflict();

$(document).ready(function () {

  var datatable = $("#datatable");

  var bodyTable = datatable.find('tbody');

  var controller_url = "backend/reporte_alertas/controller";

  var controller_user = "backend/utilizador/controller";


  $.post(controller_user, { action: 'list' }, function (retorno) {

    let user_send = JSON.parse(retorno);
    let text = '<option value="">Todos</option>'
    for (let item of user_send) {
      text += '<option value="' + item.id + '">' + item.nome + '</option>';
    }
    $('select[name="user_id"').html(text)
  })

  $('input[name="data"]').daterangepicker({
    timePicker: true,
    timePicker24Hour: true,
    autoApply: false,
    startDate: moment().subtract(29, 'days'),
    endDate: moment(),
    locale: {
      format: 'YYYY-MM-DD hh:mm:ss',
      cancelLabel: 'Clear'
    },
    ranges: {
      'Hoje': [moment(), moment()],
      'Ontém': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
      'Ultimos 7 dias': [moment().subtract(6, 'days'), moment()],
      'Ultimos 30 dias': [moment().subtract(29, 'days'), moment()],
      'Este mês': [moment().startOf('month'), moment().endOf('month')],
      'Mês passado': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    }
  });

  $('form[name="filtro').on('submit', function () {
    var form = $(this);
    var button = form.find(':button');
    $.ajax({
      url: controller_url,
      type: 'POST',
      data: 'action=filtrar&' + form.serialize(),
      beforeSend: function () {
        button.attr('disabled', true);
      },
      success: function (res) {
        console.log(res)
        button.attr('disabled', false);
        datatable.DataTable().destroy()

        bodyTable.html(res);


        let table = datatable.DataTable({
          "responsive": true,
          "autoWidth": true,
          "processing": true,
          pageLength: 10,
          dom: 'Bfrtip',
          buttons: [
            'colvis', 'csv', 'excel', 'pdf', 'print'
          ]
        });
      }

    })
    return false;
  })
  //listar items
  getAll();

  function getAll() {
    $.post(controller_url, { action: 'list' }, function (retorno) {
     //console.log(retorno)
      datatable.DataTable().destroy()

      bodyTable.html(retorno);


      let table = datatable.DataTable({
        "responsive": true,
        "autoWidth": true,
        "processing": true,
        pageLength: 10,
        dom: 'Bfrtip',
        buttons: [
          'colvis', 'csv', 'excel', 'pdf', 'print'
        ]
      });


    })
  }


});
