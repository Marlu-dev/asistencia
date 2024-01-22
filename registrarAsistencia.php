<?php
include "bd.php";
date_default_timezone_set('America/Lima');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["usuario"], $_POST["estado"])) {
        $idUsuario = $_POST["usuario"];
        $tipoRegistro = $_POST["estado"];
        $fecha = date('Y-m-d');
        $hora = date("H:i:s");

        $sql = "SELECT estado FROM usuario WHERE idUsuario = '$idUsuario'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $estadoUsuario = $row['estado'];

            if ($tipoRegistro === "0") {
                if ($estadoUsuario == 0) {
                    $sqlInsert = "INSERT INTO ingreso (Usuario_idUsuario, fecha, hora) VALUES ('$idUsuario', '$fecha', '$hora')";
                    $sqlUpdate = "UPDATE usuario SET estado = '1' WHERE idUsuario = '$idUsuario'";
                } else {
                    echo json_encode(["status" => "error", "message" => "Usuario ya en trabajo"]);
                    exit;
                }
            } elseif ($tipoRegistro === "1") {
                if ($estadoUsuario == 1) {
                    $sqlInsert = "INSERT INTO salida (Usuario_idUsuario, fecha, hora) VALUES ('$idUsuario', '$fecha', '$hora')";
                    $sqlUpdate = "UPDATE usuario SET estado = '0' WHERE idUsuario = '$idUsuario'";
                } else {
                    echo json_encode(["status" => "error", "message" => "Usuario no está trabajando"]);
                    exit;
                }
            } else {
                echo json_encode(["status" => "error", "message" => "Tipo de registro no válido"]);
                exit;
            }

            if ($conn->query($sqlInsert) === TRUE && $conn->query($sqlUpdate) === TRUE) {
                echo json_encode(["status" => "success", "message" => "Acción registrada"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Error al registrar la acción: " . $conn->error]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Usuario no encontrado"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Parámetros incompletos"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Método no permitido"]);
}

$conn->close();
?>
