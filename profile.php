<?php  require('header.php') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Perfil</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Perfil</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-4">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle"
                       src="data:image/png;base64,<?php echo $_SESSION['caixa_monitorizacao']['user']['foto']?>"
                       alt="User profile picture">
                </div>

                <h3 class="profile-username text-center"><?php echo $_SESSION['caixa_monitorizacao']['user']['nome']?></h3>

                <p class="text-muted text-center"><?php echo $_SESSION['caixa_monitorizacao']['user']['funcao']?></p>

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Nº Funcionario</b> <a class="float-right"><?php echo $_SESSION['caixa_monitorizacao']['user']['numero_funcionario']?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Departamento</b> <a class="float-right"><?php echo $_SESSION['caixa_monitorizacao']['user']['departamento']?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Função</b> <a class="float-right"><?php echo $_SESSION['caixa_monitorizacao']['user']['funcao']?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Email</b> <a class="float-right"><?php echo $_SESSION['caixa_monitorizacao']['user']['email']?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Telefone</b> <a class="float-right"><?php echo $_SESSION['caixa_monitorizacao']['user']['telefone']?></a>
                  </li>
                </ul>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->

          <div class="col-md-8">
            <div class="card card-primary card-outline">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Grupos</a></li>
                  <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Configuração</a></li>
                  <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Atividade</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="activity">
                        <table class="table table-sm table-striped">
                          <tbody id="corpoTabelaGrupo">
                            <tr><td>aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa</td></tr>
                            <tr><td>aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa</td></tr>
                            <tr><td>aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa</td></tr>
                          </tbody>
                        </table>
                  </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="timeline">
                    <!-- The timeline -->
                    <div class="timeline timeline-inverse">
                      <!-- timeline time label -->
                      <div class="time-label">
                        <span class="bg-danger">
                          10 Feb. 2014
                        </span>
                      </div>
                      <!-- /.timeline-label -->
                      <!-- timeline item -->
                      <div>
                        <i class="fas fa-envelope bg-primary"></i>

                        <div class="timeline-item">
                          <span class="time"><i class="far fa-clock"></i> 12:05</span>

                          <h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>

                          <div class="timeline-body">Editou perfil
                          </div>
                        </div>
                      </div>
                      <!-- END timeline item -->
                      <div>
                        <i class="far fa-clock bg-gray"></i>
                      </div>
                    </div>
                  </div>
                  <!-- /.tab-pane -->

                  <div class="tab-pane" id="settings">
                    <form class="form-horizontal" name="editProfile">
                      <div class="retorno"></div>
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-3 col-form-label">Nome</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" value="<?php echo $_SESSION['caixa_monitorizacao']['user']['nome']?>" name="nome" placeholder="Name">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail" class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-9">
                          <input type="email" class="form-control" value="<?php echo $_SESSION['caixa_monitorizacao']['user']['email']?>"name="email" placeholder="Email">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputName2" class="col-sm-3 col-form-label">Password Antiga</label>
                        <div class="col-sm-9">
                          <input type="password" class="form-control" value="" name="old_password" placeholder="Password Antiga">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputName2" class="col-sm-3 col-form-label">Novo Password</label>
                        <div class="col-sm-9">
                          <input type="password" class="form-control" value="" name="new_password" placeholder="Novo Password">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputName2" class="col-sm-3 col-form-label">Confirmar Password</label>
                        <div class="col-sm-9">
                          <input type="password" class="form-control" value="" name="confirmar_password" placeholder="Cornfirma Password">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputName2" class="col-sm-3 col-form-label">Telefone</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" value="<?php echo $_SESSION['caixa_monitorizacao']['user']['telefone']?>" name="telefone" placeholder="Telefone">
                        </div>
                      </div>
                      <input type="hidden" name="id" value="<?php echo $_SESSION['caixa_monitorizacao']['user']['id']?>">
<!--
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <div class="checkbox">
                            <label>
                              <input type="checkbox"> I agree to the <a href="#">terms and conditions</a>
                            </label>
                          </div>
                        </div>
                      </div>
-->
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" class="btn btn-primary" id="btn-editprofile">Editar</button>
                        </div>
                      </div>
                    </form>
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
<?php require('footer.php'); ?>

<script type="text/javascript" src="backend/utilizador/script.js"></script>
