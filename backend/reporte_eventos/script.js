

var $ = jQuery.noConflict();

$(document).ready(function () {

  var datatable = $("#datatable");

  var bodyTable = datatable.find('tbody');

  var controller_url = "backend/reporte_eventos/controller";

  var controller_gerador = "backend/gerador/controller";


  $.post(controller_gerador, { action: 'getAll' }, function (retorno) {
    
    let geradores = JSON.parse(retorno);
    let text = '<option value="">Todos</option>'
    for (let item of geradores) {
      text += '<option value="' + item.id + '">' + item.descricao + '</option>';
    }
    $('select[name="gerador_id"').html(text)
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
