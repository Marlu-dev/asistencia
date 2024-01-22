<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Horas Trabajadas</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
</head>
<body class="text-center font-sans">

<?php
include "bd.php";
date_default_timezone_set('America/Lima');

$fechaActual = date('Y-m-d');
$queryUsers = "SELECT * FROM usuario";
$resultUsers = $conn->query($queryUsers);
$totalUsers = $resultUsers->num_rows;
?>

    <div class="mt-32">
        <h2 class="text-4xl font-bold my-6">Reporte de Horas Trabajadas</h2>

        <table class="w-8/12 mx-auto my-6 border-4 border-solid border-black text-3xl">
            <thead class='bg-blue-300 border-2 border-solid border-black rounded'>
                <tr>
                    <th class="p-4 border-2 border-solid border-black rounded">Usuario</th>
                    <th class="p-4 border-2 border-solid border-black rounded">Horas Acumuladas</th>
                </tr>
            </thead>
            <tbody class="bg-white border-2 border-solid border-black">
                <?php
                for ($i = 1; $i <= $totalUsers; $i++) {
                    $useringreso = "SELECT nombre
                                    FROM usuario
                                    WHERE idUsuario = $i";
                    $resultUser = $conn->query($useringreso);
                    $user = $resultUser->fetch_assoc();
                    $user = $user["nombre"];

                    $queryingreso = "SELECT hora
                                    FROM ingreso
                                    JOIN usuario ON ingreso.USUARIO_idUsuario = usuario.idUsuario
                                    WHERE idUsuario = $i";
                    $resultingreso = $conn->query($queryingreso);

                    $querySalida = "SELECT hora
                                    FROM salida
                                    JOIN usuario ON salida.USUARIO_idUsuario = usuario.idUsuario
                                    WHERE idUsuario = $i";
                    $resultSalida = $conn->query($querySalida);

                    $horaAcumulada = 0.0;
                    while (($row = $resultingreso->fetch_assoc()) && ($row1 = $resultSalida->fetch_assoc())) {
                        $horaIngreso = new DateTime($row['hora']);
                        $horaSalida = new DateTime($row1['hora']);

                        $diferencia = $horaSalida->diff($horaIngreso);
                        $diferenciaEnMinutos = $diferencia->h * 60 + $diferencia->i;
                        $diferenciaEnHorasConDecimal = $diferenciaEnMinutos / 60;
                        $horaAcumulada += $diferenciaEnHorasConDecimal;
                    }

                    echo "<tr class='border-2 border-solid border-black'>";
                    echo "<td class='p-4 border-2 border-solid border-black'>$user</td>";
                    echo "<td class='p-4 border-2 border-solid border-black'>" . number_format($horaAcumulada, 2) . " h</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
