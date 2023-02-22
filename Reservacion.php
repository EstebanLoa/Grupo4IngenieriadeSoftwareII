<?php
if (isset($_POST['butGrabar'])){
  require 'Database.php';
  //Verifica que no esten vacios los campos de nombre,email y password
  $categorias="Cliente";
  $message = '';
  $x_codigo_activacion = "589658";
  $x_sql = "INSERT INTO `reservacion`(`id_usuario`, `id_scooter`, `codigo_activacion`, `hora_inicio`, `hora_fin`, `fecha`, `ubicacion_fin`) VALUES ('".$_POST['username']."', '".$_POST['scooter']."', '".$x_codigo_activacion."', '".$_POST['inicio']."', '".$_POST['fin']."', '".$_POST['fecha']."', '".$_POST['ubicacion']."')";
  $x_ejecutar = $conn->prepare($x_sql);  
  if ($x_ejecutar->execute()) {
    $x_sql="UPDATE `scooter` SET `disponibilidad`='No disponible', `ubicacion_scooter`= '".$_POST['ubicacion']."' WHERE `id_scooter` LIKE('".$_POST['scooter']."')";
    $x_ejecutar = $conn->prepare($x_sql);  
    if ($x_ejecutar->execute()){
      $x_estado = 1;
      $message = 'Código de Activación '.$x_codigo_activacion;
    }
  } else {
    $x_estado = 0;
    $message = 'Error, al ejecutar la sentencia SQL: '.$x_sql;
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Scooter ESPE.</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.css">
</head>
<body class="hold-transition layout-top-nav" onload="MensajeGrabacion();">  
  <div class="modal fade" id="modal-success">
    <div class="modal-dialog">
      <div class="modal-content bg-success">
        <div class="modal-header">
          <h4 class="modal-title">Reservación Creada Exitosamente</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="modal-success-form">
          <p>One fine body&hellip;</p>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-outline-light" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand-md navbar-light navbar-lightblue">
    <div>
      <img  src="css/espe.png" alt="Scooter" class="img-size-90" style="width: 300px " >
        <span class="brand-text font-weight ">
        Sistema de Scooter ESPE</span>    
      <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    </div>
    <div style=" padding-left: 60%; ">
    <img  src="css/scooter.png" alt="Scooter" class="img-size-90" style="width: 64px; " >
    </div>
  </nav>
  <!-- /.navbar -->

  
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Salir</a></li>
              <li class="breadcrumb-item active">Reservar</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <section class="content row " clear="right">
                    <div class="container-fluid col-md-6">
                        <form  id="form" action="Reservacion.php" method="post">
                            <div class="card  card-green">
                                <div class="card-header">
                                    <h3 class="card-title">Reservar Scooter</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class=" col-5">
                                            <label >Username</label>
                                            <div class="position-relative" >
                                                <input type="text" class="form-control"   name="username" id="username" required="required">
                                            </div>
                                        </div>
                                        <div class=" col-md-5">
                                           <label>ID Scooter</label>
                                            <div class="position-relative" >
                                                <select type="text"  class="form-control" name="scooter" id="scooter" required="required">
                                                  <?php 
                                                  require 'Database.php';                                                 
                                                  $x_sql="SELECT `id_scooter` FROM `scooter` WHERE `disponibilidad` LIKE('Disponible')";
                                                  $x_records = $conn->prepare($x_sql);
                                                  $x_records->execute();
                                                  if($x_records){
                                                    if($x_records->rowCount()>0){
                                                      while($x_row_scooter = $x_records->fetch(PDO::FETCH_ASSOC)){
                                                        ?>
                                                        <option value="<?php echo $x_row_scooter['id_scooter']; ?>"><?php echo $x_row_scooter['id_scooter']; ?></option>
                                                        <?php
                                                      }
                                                    }
                                                  }else{
                                                    echo "ERROR....";
                                                  }
                                                  ?>                                                  
                                                </select>
                                            </div>       
                                        </div>
                                        <div class=" col-md-5">
                                            <label >Hora inicio</label>
                                            <div class="position-relative" >
                                                <input type="time" class="form-control "  name="inicio" id="inicio" required="required">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-5">
                                            <label>Hora fin</label>
                                            <div class="position-relative" >
                                                <input type="time" class="form-control" id="fin" name="fin" required="required">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-5">
                                            <label>Fecha</label>
                                            <div class="position-relative" >
                                                <input type="date" class="form-control" id="fecha"  name="fecha" required="required">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-5">
                                        <label>Ubicación de Entrega</label>
                                            <div class="position-relative" >
                                                <select type="text"  class="form-control" name="ubicacion" id="ubicacion" required="required">
                                                    <option value="Bloque A">Bloque A</option>
                                                    <option value="Bloque B">Bloque B</option>
                                                    <option value="Bloque C">Bloque C</option>
                                                    <option value="Bloque D">Bloque D</option>
                                                    <option value="Bloque E">Bloque E</option>
                                                    <option value="Bloque F">Bloque F</option>
                                                    <option value="Bloque G">Bloque G</option>
                                                    <option value="Bloque H">Bloque H</option>
                              
                                                </select>
                                            </div>     
                                        </div>
                                        
                                        
                                    </div>
                                </div>                     
                                <div class="card-footer ">
                                  <button type="submit" class="btn btn-primary" name="butGrabar" id="butGrabar">
                                    Guardar
                                  </button>
                                  <button class="btn btn-outline-secondary" onclick="document.location.href='Reservacion.php'">     
                                      Cancelar
                                  </button>                    
                                </div>                       
                            </div>  
                        </form>
                    </div>
                </section> 
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title"></h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Modelo</th>
                    <th scope="col">Color</th>
                    <th scope="col">Ubicación</th>
                    <th scope="col">Disponibilidad</th>
                  </tr>
                  </thead>
                  <tbody>                  
                    <?php 
                    require 'Database.php';
                    $x_sql="SELECT `id_scooter`, `modelo_scooter`, `color_scooter`, `ubicacion_scooter`, `disponibilidad` FROM scooter";
                    $records = $conn->prepare($x_sql);
                    $records->execute();
                    if($records){
                      if($records->rowCount()>0){
                        while($x_row = $records->fetch(PDO::FETCH_ASSOC)){
                          ?>
                          <tr>
                            <td><?php echo $x_row['id_scooter']; ?></td>
                            <td><?php echo $x_row['modelo_scooter']; ?></td>
                            <td><?php echo $x_row['color_scooter']; ?></td>
                            <td><?php echo $x_row['ubicacion_scooter']; ?></td>
                            <td><?php echo $x_row['disponibilidad']; ?></td>
                          </tr>
                          <?php
                        }
                      }
                    }
                    ?>
                  </tbody> 
                </table>
              </div>
              
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
    



  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Ingenieria de Software II </strong> Team 4.
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>

<!-- DataTables  & Plugins -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="plugins/jszip/jszip.min.js"></script>
<script src="plugins/pdfmake/pdfmake.min.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
  function MensajeGrabacion(){
    var estado = <?php echo $x_estado; ?>;
    var mensaje = '<?php echo $message; ?>';
    if(estado === 1){
      $('#modal-success-form').html(mensaje);
      $('#modal-success').modal({backdrop: 'static', keyboard: false});
    }
  }
</script>
</body>
</html>