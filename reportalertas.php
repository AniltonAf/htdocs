<?php

require('header.php');

//require('backend/enviroment/function.php');
/*
if(!hasRoles(['utilizadores','utilizadores_utilizador','utilizadores_utilizador_adicionar'])){
  echo "<script> window.location.href='./404.php'; </script>";
}
*/
?>
<link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<style type="text/css">
  .btn-action {
    margin: 0px 5px 0px 0px;
    font-size: 10px
  }
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Reporte Alertas
          </h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <!-- <li class="breadcrumb-item active">Utilizador</li> -->
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">

      <!-- ===============================================================================
==================== START CODE WHERE
====================================================================================-->

      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <form name="filtro" class="form-inline">
                <div class="form-group mb-2 mr-3">
                  <label class="mr-2">Utilizador</label>
                  <select name="gerador_id" id="" class="form-control form-control-sm">
                    <option value="">Todos</option>
                  </select>
                </div>
                <div class="form-group mb-2 mr-3">
                  <label class="mr-2">Estado</label>
                  <select name="gerador_status" id="" class="form-control form-control-sm">
                    <option value="">Todos</option>
                    <option value="1">Enviado</option>
                    <option value="0">Não enviado</option>
                  </select>
                </div>
                <div class="form-group mb-2 mr-3">
                  <label class="mr-2">Meio</label>
                  <select name="avariado" id="" class="form-control form-control-sm">
                    <option value="">Todos</option>
                    <option value="1">Sms</option>
                    <option value="0">E-mail</option>
                  </select>
                </div>
               
                <div class="form-group mb-2 mr-3">
                  <label class="mr-2">Data</label>
                  <input type="text" name="data" value="" class="form-control form-control-sm" style="width: 300px;">
                </div>

                <div class="form-group mb-2">
                  <button type="submit" class="btn btn-sm btn-secondary"><i class="fa fa-filter"></i> Filtrar</button>
                </div>

              </form>
            </div>
          </div>
        </div>
        <div class="col-12">
          <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
              <table id="datatable" class="table table-bordered ">
                <thead>
                  <tr>
                    <th>Utilizador</th>
                    <th>Estado</th>
                    <th>Meio</th>
                    <th width="50%">Mensagem</th>
                    <th>Data</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
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
<script type="text/javascript" src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script type="text/javascript" src="plugins/datatables-buttons/js/jszip.min.js"></script>
<script type="text/javascript" src="plugins/datatables-buttons/js/pdfmake.min.js"></script>
<script type="text/javascript" src="plugins/datatables-buttons/js/vfs_fonts.js"></script>
<script type="text/javascript" src="plugins/datatables-buttons/js/buttons.min.js"></script>
<script type="text/javascript" src="plugins/datatables-buttons/js/buttons.print.js"></script>
<script type="text/javascript" src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>


<script type="text/javascript" src="backend/reporte_alertas/script.js"></script>
