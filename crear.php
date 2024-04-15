<?php

include("conexion.php");
include("funciones.php");

if ($_POST["operacion"] == "crear") {
    $imagen = "";
    if ($_FILES['imagen_usuario']['name'] != "") {
        $imagen = subir_imagen();
    }

    $stmt = $conexion->prepare("INSERT INTO usuarios(nombre, apellido, telefono, email, imagen)VALUES (:nombre, :apellido, :telefono, :email, :imagen)");

    $resultado = $stmt->execute(
        array(
            ":nombre" => $_POST["nombre"],
            ":apellido" => $_POST["apellido"],
            ":telefono" => $_POST["telefono"],
            ":email" => $_POST["email"],
            ":imagen" => $imagen
        )
    );

    if (!empty($resultado)) {
        echo "registro exitoso";
    }  else {
        echo "Algo salio mal";
    }
    // $stmt->bindParam(":nombre", $_POST["nombres"]);
    // $stmt->bindParam(":apellido", $_POST["apellidos"]);
    // $stmt->bindParam(":telefono", $_POST["telefonos"]);
    // $stmt->bindParam(":email", $_POST["emails"]);
    // $stmt->bindParam(":imagen", $imagen);
    // $stmt->bindParam(":fecha_creacion", $_POST["fecha_creacion"]);
    // $stmt->execute();
} 


if ($_POST["operacion"] == "editar") {
    $imagen = "";
    if ($_FILES['imagen_usuario']['name'] != "") {
        $imagen = subir_imagen();
    }else {
        $imagen = $_POST["imagen_usuario_oculta"];
    }

    $stmt = $conexion->prepare("UPDATE usuarios SET nombre = :nombre, apellido = :apellido, telefono = :telefono, email = :email, imagen = :imagen WHERE id = :id");

    $resultado = $stmt->execute(
        array(
            ":nombre" => $_POST["nombre"],
            ":apellido" => $_POST["apellido"],
            ":telefono" => $_POST["telefono"],
            ":email" => $_POST["email"],
            ":imagen" => $imagen,
            ":id" => $_POST["id_usuario"]
        )
    );

    if (!empty($resultado)) {
        echo "registro Actualizado";
    }  else {
        echo "Algo salio mal";
    }
    // $stmt->bindParam(":nombre", $_POST["nombres"]);
    // $stmt->bindParam(":apellido", $_POST["apellidos"]);
    // $stmt->bindParam(":telefono", $_POST["telefonos"]);
    // $stmt->bindParam(":email", $_POST["emails"]);
    // $stmt->bindParam(":imagen", $imagen);
    // $stmt->bindParam(":fecha_creacion", $_POST["fecha_creacion"]);
    // $stmt->execute();
} 
