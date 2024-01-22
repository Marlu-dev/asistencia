<?php
include "bd.php";
date_default_timezone_set('America/Lima'); 
$sql = "SELECT idUsuario, nombre, estado FROM usuario";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <title>Asistencia</title>
</head>
<body>
    <div class="w-screen h-screen flex text-center">
        <div class="w-5/12 h-full flex items-center justify-center">
            <img src="img.png" class="w-5/6 h-3/6">
        </div>
        <div class="w-7/12 h-full flex items-center justify-center">
            <div class="bg-gray-100 w-4/6 h-3/6 flex flex-col border-solid border-2 border-black rounded ">
                <div class="flex items-center justify-center w-full h-1/6 mt-5">
                    <label class="text-4xl font-bold">Control de Asistencia</label>
                </div>
                <div class="ml-10 flex items-start justify-start w-full h-1/6">
                    <label class="mr-2 font-bold text-3xl">Usuario:</label>
                    <select name="usuario" class="text-2xl w-96 h-12 text-center rounded" id="usuario" onchange="showHideButtons()">
                        <option value="0">Seleccionar usuario</option>
                        <?php
                        while ($row = $result->fetch_assoc()) {
                            echo '<option value="' . $row['idUsuario'] . '" data-estado="' . $row['estado'] . '">' . $row['nombre'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="ml-10 flex items-start justify-start w-full h-1/6">
                    <div class="flex items-start justify-start w-3/6">
                        <label class="mr-2 font-bold text-3xl">Fecha:</label>
                        <input class="text-2xl w-48 h-12 text-center rounded bg-white" type="date" id="fecha" value="<?php echo date('Y-m-d'); ?>" disabled>
                    </div>
                </div>
                <div class="ml-10 flex items-start justify-start w-full h-1/6">
                    <div class="flex items-start justify-start w-3/6">
                        <label class="mr-2 font-bold text-3xl">Hora:</label>
                        <input class="text-2xl w-48 h-12 text-center rounded bg-white" type="text" id="hora" disabled>
                    </div>
                </div>
                <div class="flex items-start justify-end w-9/12 h-1/6">
                    <div class="flex items-center justify-center">
                        <button id="btn-ingreso" class="text-2xl bg-blue-300 hover:bg-blue-500 text-black border border-black font-bold py-2 px-4 rounded-md relative shadow-md hidden" onclick="registrar('0')">Ingreso</button>
                    </div>
                    <div class="flex items-start justify-end">
                        <button id="btn-salida" class="text-2xl bg-red-500 hover:bg-red-600 text-black border border-black font-bold py-2 px-4 rounded-md relative shadow-md hidden" onclick="registrar('1')">Salida</button>
                    </div>
                </div>
                <div class="flex items-center justify-center w-full h-1/6">
                    <a href="reporte.php" target="_blank" class="text-2xl text-blue-500 underline">Ver Reporte</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            function agregarCero(numero) {
                return numero < 10 ? "0" + numero : numero;
            }

            function actualizarHora() {
                var horaActual = new Date();
                var ampm = horaActual.getHours() >= 12 ? 'PM' : 'AM';
                var horaFormato = agregarCero(horaActual.getHours() % 12) + ":" + agregarCero(horaActual.getMinutes()) + ":" + agregarCero(horaActual.getSeconds()) + " " + ampm;
                $("#hora").val(horaFormato);
            }
            setInterval(actualizarHora, 1000);
        });

    </script>

    <script>
        function showHideButtons() {
            var select = document.querySelector('select[name="usuario"]');
            var estado = select.options[select.selectedIndex].getAttribute('data-estado');
            var btnIngreso = document.getElementById('btn-ingreso');
            var btnSalida = document.getElementById('btn-salida');

            // Oculta ambos botones por defecto
            btnIngreso.classList.add('hidden');
            btnSalida.classList.add('hidden');

            // Muestra el botón correspondiente según el estado
            if (estado == '0') {
                btnIngreso.classList.remove('hidden');
            } else if (estado == '1') {
                btnSalida.classList.remove('hidden');
            }
        }

        function registrar(tipoRegistro) {
            var usuario = document.getElementById('usuario').value;

            $.ajax({
                url: "registrarAsistencia.php",
                type: 'POST',
                data: { usuario: usuario, estado: tipoRegistro },
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Registro de ' + (tipoRegistro === '0' ? 'ingreso' : 'salida'),
                            text: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        }).then(function () {
                            // Si el registro fue exitoso, cambiar el texto del botón y el atributo data-estado
                            if (tipoRegistro === '0') {
                                document.getElementById('btn-ingreso').innerText = 'Salida';
                            } else if (tipoRegistro === '1') {
                                document.getElementById('btn-salida').innerText = 'Ingreso';
                            }

                            // Redireccionar a tu archivo PHP después de 5 segundos
                            setTimeout(function () {
                                window.location.href = 'index.php';
                            }, 1000);
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: '¡Error!',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 2500
                        });
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // Mostrar mensaje de error en la solicitud AJAX
                    Swal.fire({
                        icon: 'error',
                        title: '¡Error!',
                        text: 'Error en la solicitud AJAX',
                        showConfirmButton: false,
                        timer: 2500
                    });
                    console.log("Error en la solicitud AJAX:");
                    console.log("Estado: " + textStatus);
                    console.log("Error: " + errorThrown);
                    console.log("Respuesta del servidor:");
                    console.log(jqXHR.responseText);
                }
            });
        }

    </script>
</body>
</html>
