<?php require('header.php') ?>
<style>
  .marker {
    display: block;
    border: none;
    border-radius: 50%;
    cursor: pointer;
    padding: 0;
  }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <section class="content"><br>
    <div class="container-fluid">

      <!-- ===============================================================================
==================== START CODE WHERE
====================================================================================-->

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <!-- Info boxes -->
          <div class="row">
            <div class="col-lg-2 col-6">
              <div class="small-box bg-success">
                <div class="inner">
                  <h3 class="gerador_on"></h3>
                  <p>Gerador On</p>
                </div>
                <div class="icon"><i class="fas fa-power-off"></i></div>
                <a href="#" class="small-box-footer">
                <!--  Ver Lista <i class="fas fa-arrow-circle-right"></i>-->
                </a>
              </div>
            </div>

            <div class="col-lg-2 col-6">
              <div class="small-box bg-danger">
                <div class="inner">
                  <h3 class="gerador_off"></h3>
                  <p>Gerador OFF</p>
                </div>
                <div class="icon"><i class="fas fa-power-off"></i></div>
                <a href="#" class="small-box-footer">
                 <!--  Ver Lista <i class="fas fa-arrow-circle-right"></i>-->
                </a>
              </div>
            </div>

            <div class="col-lg-2 col-6">
              <div class="small-box bg-danger">
                <div class="inner">
                  <h3 class="gerador_avariado"></h3>
                  <p>Gerador Avariado</p>
                </div>
                <div class="icon"><i class="fas fa-wrench"></i></div>
                <a href="#" class="small-box-footer">
                  <!--  Ver Lista <i class="fas fa-arrow-circle-right"></i>-->
                </a>
              </div>
            </div>

            <div class="col-lg-2 col-6">
              <div class="small-box">
                <div class="inner bg-light">
                  <div class="row" style="font-size:20px;padding:5px">
                    <div class="col-sm-6">
                      <span class="badge badge-success"><i class="fas fa-power-off"></i> <span class="rede_publica_on"></span></span>
                    </div>
                    <div class="col-sm-6">
                      <span class="badge badge-danger"><i class="fas fa-power-off"></i> <span class="rede_publica_off"></span></span>
                    </div>
                  </div>
                  <p>Rede Publica</p>
                </div>
                <div class="icon" style="color:Lightblue"><i class="fas fa-plug"></i></div>
                <a href="#" class="small-box-footer bg-info">
                  <!--  Ver Lista <i class="fas fa-arrow-circle-right"></i>-->
                </a>
              </div>
            </div>

            <!-- fix for small devices only -->
            <div class="clearfix hidden-md-up"></div>

            <div class="col-lg-2 col-6">
              <div class="small-box">
                <div class="inner bg-light">
                  <div class="row" style="font-size:20px;padding:5px">
                    <div class="col-sm-6">
                      <span class="badge badge-success"><i class="fas fa-power-off"></i> <span class="qua_aut_trans_on"></span></span>
                    </div>
                    <div class="col-sm-6">
                      <span class="badge badge-danger"><i class="fas fa-power-off"></i> <span class="qua_aut_trans_off"></span></span>
                    </div>
                  </div>
                  <p>QTA</p>
                </div>
                <div class="icon" style="color:Lightblue"><i class="fas fa-bolt"></i></div>
                <a href="#" class="small-box-footer bg-info">
                  <!--  Ver Lista <i class="fas fa-arrow-circle-right"></i>-->
                </a>
              </div>
            </div>

            <div class="col-lg-2 col-6">
              <div class="small-box">
                <div class="inner bg-light">
                  <div class="row" style="font-size:20px;padding:5px">
                    <div class="col-md-6">
                      <span class="badge badge-success"><i class="fas fa-power-off"></i> <span class="low_fuel_off"></span></span>
                    </div>
                    <div class="col-md-6">
                      <span class="badge badge-danger"><i class="fas fa-power-off"></i> <span class="low_fuel_on"></span></span>
                    </div>
                  </div>
                  <p>Nivel Combustivel</p>
                </div>
                <div class="icon" style="color:Lightblue"><i class="fas fa-gas-pump"></i></div>
                <a href="#" class="small-box-footer bg-info">
                  <!--  Ver Lista <i class="fas fa-arrow-circle-right"></i>-->
                </a>
              </div>
            </div>
          </div>


          <div class="row">
            <div class="col-md-5">
              <div class="card card-outline card-primary">
                <div class="card-header">
                  <h5 class="card-title">Localização Geradores</h5>
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                  </div>
                </div>
                <div class="card-body" id="map" style="height: 500px;">
                </div>
              </div>
            </div>

            <div class="col-md-3">
              <div class="card card-outline card-primary">
                <div class="card-header">
                  <h3 class="card-title">Notificações</h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                  </div>
                </div>
                <div class="card-body" style="display: block;min-height: 500px; padding:8px">
                  <div class="direct-chat-messages" style="height: 450px; padding:0px">
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-4">
              <div class="row">
                <div class="col-md-12">
                  <div class="card card-outline card-primary">
                    <div class="card-header">
                      <h3 class="card-title">
                        <select id="chart_estado_select" style="border: none;">
                          <option value="1">Estado Geradores</option>
                          <option value="2">Estado Rede Publica</option>
                          <option value="3">Estado QTA</option>
                        </select>
                      </h3>
                      <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                          <i class="fas fa-minus"></i>
                        </button>
                      </div>
                    </div>
                    <div class="card-body" id="chart_estado" style="display: block;min-height: 216px; padding:8px">
                    </div>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="card card-outline card-primary">
                    <div class="card-header">
                      <h3 class="card-title">Top 10
                        <select name="" id="chart_top_10_select" style="border: none;">
                          <option value="1">Gerador Avariado</option>
                          <option value="2">Avaria no QTA</option>
                          <option value="3">Avaria na Rede publica</option>
                        </select>
                      </h3>
                      <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                          <i class="fas fa-minus"></i>
                        </button>
                      </div>
                    </div>
                    <div class="card-body" id="chart_top_10" style="display: block;min-height: 216px; padding:8px">
                    </div>
                  </div>
                </div>
              </div>
            </div>




          </div>










          <!-- ===============================================================================
==================== END CODE WHERE
====================================================================================-->

          <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>

    <?php require('footer.php'); ?>
    <script src="https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.js"></script>
    <link href="https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/paho-mqtt/1.0.1/mqttws31.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="backend/dashboard/script.js"></script>
