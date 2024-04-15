<?php

    include("conexion.php");
    include("funciones.php");

    

if ($_POST["id_usuario"]) {
    $imagen = obtener_nombre_imagen($_POST["id_usuario"]);
    if ($imagen != "") {
        unlink($imagen);
    }

    $stmt = $conexion->prepare("DELETE FROM usuarios WHERE id = :id");

    $resultado = $stmt->execute(
        array(
            ":id" => $_POST["id_usuario"]
        )
    );

    if (!empty($resultado)) {
        echo "registro Borrado";
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
