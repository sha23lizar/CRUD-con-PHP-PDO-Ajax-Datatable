<?php

    function subir_imagen(){
        if(isset($_FILES['imagen_usuario'])){
            $extension = explode('.', $_FILES['imagen_usuario']['name']);
            $new_name = rand().'.'. $extension[1];
            $url = './img/'.$new_name;
            move_uploaded_file($_FILES['imagen_usuario']['tmp_name'], $url);
            return $url;
        }
    }

    function obtener_nombre_imagen($id_usuario){
        include("conexion.php");
        $stmt = $conexion->prepare("SELECT imagen FROM usuarios WHERE id = '$id_usuario'");
        $stmt->execute();
        $resultado = $stmt->fetchAll();
        foreach ($resultado as $row) {
            return $row["imagen"];
        }
    }
    function obtener_todos_registros(){
        include("conexion.php");
        $stmt = $conexion->prepare("SELECT * FROM usuarios");
        $stmt->execute();
        // $resultado = $stmt->fetchAll();
        return $stmt->rowCount();
    }