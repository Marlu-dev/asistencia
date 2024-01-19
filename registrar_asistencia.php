<?php
include "bd.php";
date_default_timezone_set('America/Lima'); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si el índice idUsuario está definido
    if (isset($_POST["idUsuario"])) {
        $idUsuario = $_POST["idUsuario"];
        $tipoRegistro = $_POST["tipoRegistro"];
        $fecha = $_POST["fecha"];
        $hora = $_POST["hora"];

        $sql = "SELECT idUsuario, estado FROM usuario";
        $result = $conn->query($sql);
        $result =$result->fetch_assoc();
        // Realizar la inserción en la base de datos (ajusta la consulta según tu esquema)
        if ($tipoRegistro === "Ingreso") {
            if($result['estado']==0){
                $sql = "INSERT INTO ingreso (Usuario_idUsuario, fecha, hora) VALUES ('$idUsuario', '$fecha', '$hora')";
                $sql1 = "UPDATE usuario SET estado='1' WHERE idUsuario='{$result['idUsuario']}'";
                $conn->query($sql1);
            }
            else{
                echo "Usuario en trabajo";
            }
        } elseif ($tipoRegistro === "Salida") {
            if($result['estado']==1){
                $sql = "INSERT INTO salida (Usuario_idUsuario, fecha, hora) VALUES ('$idUsuario', '$fecha', '$hora')";
                $sql1 = "UPDATE usuario SET estado='0' WHERE idUsuario='{$result['idUsuario']}'";
                $conn->query($sql1);
            }
            else{
                echo "Usuario no esta trabajo";
            }
        } else {
            echo "Tipo de registro no válido";
            exit;
        }

        if ($conn->query($sql) === TRUE) {
            echo "Acción registrada";
        }
    } else {
        echo "idUsuario no definido";
    }
} else {
    echo "Método no permitido";
}

$conn->close();
?>
