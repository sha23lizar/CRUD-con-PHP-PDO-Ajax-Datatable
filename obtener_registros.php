<?php

    include("conexion.php");
    include("funciones.php");

    $query = '';
    $salida = array();
    $query = "SELECT * FROM usuarios ";

    if(isset($_POST['search']['value'])) {
        $query .= "WHERE nombre LIKE '%".$_POST['search']['value']."%'";
        $query .= "OR apellido LIKE '%".$_POST['search']['value']."%'";
    }

    if (isset($_POST['order'])) {
        $query .= "ORDER BY " . $_POST['order']['0']['column'] . " " . $_POST['order']['0']['dir'] . " ";
    } else {
        $query .= "ORDER BY id DESC ";
    }

    if ($_POST['length'] != -1) {
        $query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
    }

    $stmt = $conexion->prepare($query);
    $stmt->execute();
    $resultado = $stmt->fetchAll();
    $datos = array();
    $filtered_rows = $stmt->rowCount();
    foreach($resultado as $row){
        $imagen = "";
        if($row['imagen'] != "") {
            $imagen = '<img src="' . $row['imagen'] . '" width="50" height="50" class="img-thumbnail">';
        } else {
            $imagen = '<img src="./img/default.png" width="50" class="img-thumbnail">';
        }
        $sub_array = array();
        $sub_array[] = $row['id'];
        $sub_array[] = $row['nombre'];
        $sub_array[] = $row['apellido'];
        $sub_array[] = $row['telefono'];
        $sub_array[] = $row['email'];
        $sub_array[] = $imagen;
        $sub_array[] = $row['fecha_creacion'];
        $sub_array[] = '<button type="button" name="editar" id="'.$row["id"].'" class="btn btn-warning btn-xs editar">Editar</button>';
        $sub_array[] = '<button type="button" name="borrar" id="'.$row["id"].'" class="btn btn-danger btn-xs borrar">Eliminar</button>';
        $datos[] = $sub_array;
    }

    $salida = array(
        "draw" => intval($_POST["draw"]),
        "recordsTotal" => $filtered_rows,
        "recordsFiltered" => obtener_todos_registros(),
        "data" => $datos
    );
    echo json_encode($salida);

