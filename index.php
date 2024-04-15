<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CRUD con PHP,PDO,Ajax,Datatable</title>
  <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="./bootstrap/icon/font/bootstrap-icons.min.css" />
  <link rel="stylesheet" href="./DataTables/datatables.css" />
  <link rel="stylesheet" href="./css/styles.css" />
</head>

<body>
  <div class="container fondo">
    <h1 class="text-center">CRUD con PHP,PDO,Ajax,Datatable</h1>

    <div class="row">
      <div class="col-2 offset-10">
        <div class="text-center">
          <!-- Button trigger modal -->
          <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#modalUsuario">
            <i class="bi bi-plus-circle-fill"></i> Añadir
          </button>
        </div>
      </div>
    </div>
    <br />
    <br />

    <div class="table-responsive">
      <table id="datos-usuarios" class="table table-striped table-bordered">
        <thead>
          <tr>
            <th>id</th>
            <th>Nombre</th>
            <th>Edad</th>
            <th>telefono</th>
            <th>Gmail</th>
            <th>Imagen</th>
            <th>Fecha de creacion</th>
            <th>editar</th>
            <th>borrar</th>
          </tr>
        </thead>

      </table>
    </div>

  </div>






  <!-- Modal Agregar -->
  <div class="modal fade" id="modalUsuario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form method="POST" id="form-usuario" enctype="multipart/form-data">
          <div class="moda-content">
            <div class="modal-body">
              <label for="nombre">Ingrese el nombre</label>
              <input type="text" class="form-control" name="nombre" id="nombre">
              <br />

              <label for="apellido">Ingrese el apellido</label>
              <input type="text" class="form-control" name="apellido" id="apellido">
              <br />

              <label for="telefono">Ingrese el telefono</label>
              <input type="text" class="form-control" name="telefono" id="telefono">
              <br />

              <label for="email">Ingrese el email</label>
              <input type="email" class="form-control" name="email" id="email">
              <br />

              <label for="image">Ingrese su image</label>
              <input type="file" class="form-control" name="imagen_usuario" id="image-usuario">
              <span id="imagen_subida"></span>
              <br />

            </div>
          </div>
          <div class="modal-footer">
            <input type="hidden" name="id_usuario" id="id_usuario">
            <input type="hidden" name="operacion" id="operacion" value="crear">
            <input type="submit" name="action" id="action" class="btn btn-success" value="crear">
          </div>
        </form>
        <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>







  <!-- JQuery (Tiene que estar antes que datatables por que esta la necesita) -->
  <script src="./js/jquery-3.7.1.min.js"></script>
  <!-- datatables -->
  <script src="./DataTables/datatables.js"></script>
  <!-- Bootstrap JS -->
  <script src="./bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Script -->

  <script type="text/javascript">
    $(document).ready(function() {
      var dataTable = $("#datos-usuarios").DataTable({
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
          url: "obtener_registros.php",
          type: "POST"
        },
        "columnsDefs": [{
          "targets": [0, 3, 4],
          "orderable": false,
        }, ],
        "language": {
          "decimal": "",
          "emptyTable": "No hay datos disponibles en la tabla",
          "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
          "infoEmpty": "Mostrando 0 a 0 de 0 Entradas",
          "infoFiltered": "(Filtrado de _MAX_ total entradas)",
          "infoPostFix": "",
          "thousands": ",",
          "lengthMenu": "Mostrar _MENU_ Entradas",
          "loadingRecords": "Cargando...",
          "processing": "Procesando...",
          "search": "Buscar:",
          "zeroRecords": "Sin resultados encontrados",
          "paginate": {
            "first": "Primero",
            "last": "Ultimo",
            "next": "Siguiente",
            "previous": "Anterior"
          }
          
        }
      });



      $(document).on("submit", "#form-usuario", function(e) {
        e.preventDefault();
        var nombres = $("#nombres").val();
        var apellidos = $("#apellidos").val();
        var telefonos = $("#telefonos").val();
        var emails = $("#emails").val();
        var extencion = $("#image-usuario").val().split('.').pop().toLowerCase();
        if (extencion != "") {
          if ($.inArray(extencion, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
            alert('El archivo seleccionado no es una imagen');
            $("#image-usuario").val("");
            return false;
          }
          if (nombres != '' && apellidos != '' && telefonos != '' && emails != '') {
            $.ajax({
              url: "crear.php",
              method: "POST",
              data: new FormData(this),
              contentType: false,
              processData: false,
              success: function(data) {
                alert(data);
                $("#form-usuario")[0].reset();
                $("#modalUsuario").modal('hide');
                dataTable.ajax.reload();
              }
            });
          } else {
            alert('Todos los campos son requeridos');
          }
        }
      })


      // Funcionalidad editar
      $(document).on("click", ".editar", function(e) {
        var id_usuario = e.target.id;
        $.ajax({
          url: "obtener_registro.php",
          method: "POST",
          data: {
            id_usuario: id_usuario
          },
          dataType: "json",
          success: function(data) {
            $("#modalUsuario").modal("show");
            $("#nombre").val(data.nombre);
            $("#apellido").val(data.apellido);
            $("#telefono").val(data.telefono);
            $("#email").val(data.email);
            $("#imagen_subida").html(data.imagen_usuario);
            $("#id_usuario").val(id_usuario);
            $("#action").val("editar");
            $("#operacion").val("editar");
          },
          error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
          }
        })
      })

      // Funcionalidad Borrar
      $(document).on("click", ".borrar", function(e) {
        var id_usuario = e.target.id;
        if (confirm("¿Desea borrar el registro nro: "+ id_usuario+"?")) {
          $.ajax({
            url: "borrar.php",
            method: "POST",
            data: {
              id_usuario: id_usuario
            },
            success: function(data) {
              alert(data);
              dataTable.ajax.reload();
            }
          })
        }
      })


      // Final scritp
    })
  </script>

</body>

</html>