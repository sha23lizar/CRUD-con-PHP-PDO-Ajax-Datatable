<?php

    include("conexion.php");
    include("funciones.php");


    if(isset($_POST['id_usuario'])) {
        $salida = array();
        $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE id = '".$_POST["id_usuario"]."' LIMIT 1");
        $stmt->execute();
        $resultado = $stmt->fetchAll();
        foreach ($resultado as $row) {
            $salida["nombre"] = $row["nombre"];
            $salida["apellido"] = $row["apellido"];
            $salida["telefono"] = $row["telefono"];
            $salida["email"] = $row["email"];
            if($row["imagen"] != "") {
                $salida["imagen_usuario"] = '<img src="'.$row["imagen"].'" class="img-thumbnail" width="100" height="50" /><input type="hidden" name="imagen_usuario_oculta" value="'.$row["imagen"].'" />';
            } else {
                $salida["imagen_usuario"] = '<input type="hidden" name="imagen_usuario_oculta" value="'.$row["imagen"].'" />';
            }
        }
        echo json_encode($salida);
    }