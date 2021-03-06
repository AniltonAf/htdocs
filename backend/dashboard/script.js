var $ = jQuery.noConflict();

$(document).ready(function () {

  var datatable = $("#datatable");

  var bodyTable = datatable.find('tbody');

  var controller_url = "backend/dashboard/controller";

  //listar items
  setInterval(function () {
    getAll();
    chart_estado();
    


  }, 2000);
  initMqtt();
  getMap();

  getlast5();
  chart_top_10();


  $('#modalAdd').on('click', '#btnAdd', function () {
    var id_grupo = $(this).attr('data-id')
    var modal = $('#modalUser');
    var body = modal.find('.modal-body');

    $.post(controller_url, { action: 'addUserForm', id_grupo: id_grupo }, function (response) {
      body.html(response);
      modal.modal({ backdrop: false });
    })
  })

  function initMqtt() {
    $.post(controller_url, { action: 'get_server' }, function (retorno) {

      let response = JSON.parse(retorno)

      if (response.status) {

        let server = response.server


        client = new Paho.MQTT.Client(server.server_mqtt, Number(server.port_ws), server.id_cliente + microtime(true));
        client.onConnectionLost = onConnectionLost;
        client.onMessageArrived = onMessageArrived;

        client.connect({ timeout: 1, onSuccess: onConnect, onFailure: onFailure, userName: server.username, password: server.password });



        function onConnect() {
          client.subscribe(server.id_cliente, 2)
          console.log('conectou')
        }

        function onFailure() {
          console.log('falhou')
        }

        function onConnectionLost(responseObject) {
          if (responseObject.errorCode !== 0) {
            console.log("onConnectionLost:" + responseObject.errorMessage);
          }
        }

        function onMessageArrived(message) {

          let corpo_message = $('.direct-chat-messages')

          let old_message = corpo_message.html();

          response = JSON.parse(message.payloadString)



          $.post(controller_url, { action: 'get_gerador', id: response.id_gerador }, function (res) {
            let retorno = JSON.parse(res);

            let status = response.servidor_status

            if (retorno.status && retorno.gerador) {
              let gerador = retorno.gerador

              let new_message = '';

              let message_corpo = false;

              console.log(response)

              if (response.gerador_status == 1) {
                new_message = messageCorpo('Gerador ON', gerador.descricao, retorno.time, 'success');
                alertson();
              }

              if (!response.rede_publica && !response.gerador_status && !response.power_edificio) {
                new_message = messageCorpo('Retorno de energia da rede, gerador OFF', gerador.descricao, retorno.time, '#808080');
                alertson();
              }

              if (response.rede_publica && response.gerador_status && !response.power_edificio) {
                new_message = messageCorpo('Corte de energia, gerador ON e agencia com energia', gerador.descricao, retorno.time, 'success');
                alertson();

              }

              if (response.low_fuel) {
                new_message = messageCorpo('Gerdor com baixo nivel de combustivel', gerador.descricao, retorno.time, 'danger');
                alertson();

              }

              if (response.avariado) {
                new_message = messageCorpo('Gerdor alguma avaria não identificada', gerador.descricao, retorno.time, 'danger');
                alertson();
              }

              if (response.qua_aut_trans) {
                new_message = messageCorpo('Agencia sem energia e com avaria no QTA', gerador.descricao, retorno.time, 'danger');
                alertson();


                if (response.gerador_status == 0) {
                  new_message = messageCorpo('Gerador OFF', gerador.descricao, retorno.time, '#808080');
                  alertson();

                }

              }


              corpo_message.html(new_message + old_message)
            }

          })


          console.log("onMessageArrived:" + message.payloadString);
        }
      }
    })
  }



  function messageCorpo(mensagem, descricao, time, status) {
    return `
			<div class="direct-chat-msg ">
			<div class="direct-chat-text bg-`+ status + `" >
				<span class="direct-chat-name float-left">`+ descricao + ` em  ` + time + `</span><br>
				`+ mensagem + `
			</div>
			</div>
		`;
  }


  function getAll() {
    $.post(controller_url, { action: 'count_estado' }, function (retorno) {
      response = JSON.parse(retorno);
      $('.gerador_on').html(response.gerador_status.on)
      $('.gerador_off').html(response.gerador_status.off)
      $('.gerador_avariado').html(response.gerador_avariado.on)
      $('.rede_publica_on').html(response.rede_publica.on)
      $('.rede_publica_off').html(response.rede_publica.off)
      $('.qua_aut_trans_on').html(response.qua_aut_trans.on)
      $('.qua_aut_trans_off').html(response.qua_aut_trans.off)
      $('.low_fuel_on').html(response.low_fuel.on)
      $('.low_fuel_off').html(response.low_fuel.off)

    })
  }


  function getlast5() {
    $.post(controller_url, { action: 'last5' }, function (res) {

      let historico = JSON.parse(res);

      historico.reverse()

      historico.forEach((item) => {

        let new_message = '';

        let corpo_message = $('.direct-chat-messages')

        let old_message = corpo_message.html();


        if (item.gerador_status == 1) {
          new_message = messageCorpo('Gerador ON ', item.descricao, item.create_h_ut, 'success');

        }

        if (!item.rede_publica && !item.gerador_status && !item.power_edificio) {
          new_message = messageCorpo('Retorno de energia da rede, gerador OFF ', item.descricao, item.create_h_ut, '#808080');

        }

        if (item.rede_publica && item.gerador_status && !item.power_edificio) {
          new_message = messageCorpo('Corte de energia, gerador ON e agencia com energia', item.descricao, item.create_h_ut, 'success');

        }

        if (item.low_fuel) {
          new_message = messageCorpo('Gerdor com baixo nivel de combustivel', item.descricao, item.create_h_ut, 'danger');

        }

        if (item.avariado) {
          new_message = messageCorpo('Gerdor alguma avaria não identificada', item.descricao, item.create_h_ut, 'danger');
        }

        if (item.qua_aut_trans) {
          new_message = messageCorpo('Agencia sem energia e com avaria no QTA', item.descricao, item.create_h_ut, 'danger');


        }
        if (item.gerador_status == 0) {
          new_message = messageCorpo('Gerador OFF', item.descricao, item.create_h_ut, '#808080');

        }


        corpo_message.html(new_message + old_message)
      })

    })
  }

  function getMap() {
    $.post(controller_url, { action: 'get_geradores' }, function (retorno) {
      var response = JSON.parse(retorno)

      mapboxgl.accessToken = 'pk.eyJ1IjoiaXZhbmlsZG9lZSIsImEiOiJja2hmYWwxcWkwYWptMnhwYzk2c3lmNWJxIn0.MG7-GSqPrk3JCepjLMSB9Q';
      var map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v11',//'mapbox://styles/mapbox/satellite-v8',streets
        center: [-24.24721217421829, 15.905888745235975],
        zoom: 7
      });

      var points = {
        'type': 'FeatureCollection',
        'features': response.data
      }

      map.on('click', 'marker', function (e) {
     
      })

      map.on('load', function () {
        map.addSource('places', {
          'type': 'geojson',
          'data': {
            'type': 'FeatureCollection',
            'features': response.data,
          }
        });

        points.features.forEach(function (marker) {
          var el = document.createElement('img');
          el.id = "marker"
          el.className = 'marker';
          el.style.backgroundImage = 'url(./dist/img/marker/' + marker.properties.icon + '.png)';
          el.style.width = marker.properties.iconSize[0] + 'px';
          el.style.height = marker.properties.iconSize[1] + 'px';
          el.addEventListener('click', function (e) {

          });
          var popup = new mapboxgl.Popup()
            .setLngLat(marker.geometry.coordinates)
            .setHTML(marker.properties.description);
          // add marker to map
          new mapboxgl.Marker(el)
            .setLngLat([Number(marker.geometry.coordinates[0]), Number(marker.geometry.coordinates[1])])
            .addTo(map)
            .setPopup(popup);
          setInterval(function () {
            $.post(controller_url, { action: 'get_geradorMarker', gerador_id: marker.properties.id, estado: marker.properties.icon }, function (res) {
              let result = JSON.parse(res);
              if (result.status) {
                marker = result.data
                el.style.backgroundImage = 'url(./dist/img/marker/' + marker.properties.icon + '.png)';
                el.style.width = marker.properties.iconSize[0] + 'px';
                el.style.height = marker.properties.iconSize[1] + 'px';
                popup.setHTML(marker.properties.description)
              }

            })
          }, 2000)

        })
      });
    })

  }


  $('#chart_estado_select').change(function () {
    chart_estado()
  })

  function chart_estado() {
    $.post(controller_url, { action: 'chart_estado', chart_id: $('#chart_estado_select').val() }, function (retorno) {
      let response = JSON.parse(retorno)
      google.charts.load('current', { 'packages': ['corechart'] });
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable(response);

        var options = {
          is3D: true,
          chartArea: { left: 0, top: 0, width: '100%', height: '100%' }
        };

        var chart = new google.visualization.PieChart(document.getElementById('chart_estado'));

        chart.draw(data, options);
      }
    })

  }

  $('#chart_top_10_select').change(function () {
    chart_top_10()
  })

  function chart_top_10() {
    $.post(controller_url, { action: 'chart_top_10', chart_id: $('#chart_top_10_select').val() }, function (retorno) {

      let response = JSON.parse(retorno)

      google.charts.load('current', { packages: ['corechart', 'bar'] });
      google.charts.setOnLoadCallback(drawMaterial);

      function drawMaterial() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Gerador');
        data.addColumn('number', 'Quantidade');

        data.addRows(response);

        var options = {
          hAxis: {
            title: 'Time of Day',
            format: 'h:mm a',
            viewWindow: {
              min: [7, 30],
              max: [17, 30]
            }
          },
          vAxis: {
            title: 'Rating (scale of 1-10)'
          },
          legend: { position: 'none' }
        };

        var materialChart = new google.charts.Bar(document.getElementById('chart_top_10'));
        materialChart.draw(data, options);
      }
    })
  }

  function getMessage(type, message) {
    var text = '<div class="alert alert-sm alert-' + type + '" style="padding:4px">' + message + '</div>';

    $('.retorno').html(text);

    setTimeout(function () {
      $('.retorno').html('');
    }, 4000)
  }

  function microtime(getAsFloat) {
    var s, now, multiplier;

    if (typeof performance !== 'undefined' && performance.now) {
      now = (performance.now() + performance.timing.navigationStart) / 1000;
      multiplier = 1e6; // 1,000,000 for microseconds
    }
    else {
      now = (Date.now ? Date.now() : new Date().getTime()) / 1000;
      multiplier = 1e3; // 1,000
    }

    // Getting microtime as a float is easy
    if (getAsFloat) {
      return now;
    }

    // Dirty trick to only get the integer part
    s = now | 0;

    return (Math.round((now - s) * multiplier) / multiplier) + ' ' + s;
  }

  // teste som
  function alertson() {
    var snd = new Audio('../dist/son/alert.mp3');
    snd.onended = function () { alert("Notificação recebida 99"); };
    snd.play();
  }

});
