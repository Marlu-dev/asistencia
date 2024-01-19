<?php
include "bd.php";
date_default_timezone_set('America/Lima'); 
$sql = "SELECT idUsuario, nombre FROM usuario";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <title>Asistencia</title>
</head>
<body>
    <div class="w-screen h-screen flex">
        <div class="w-1/2 h-full flex items-center justify-center">
            <img src="img.jpg" class="w-4/6 h-3/6">
        </div>
        <div class="w-1/2 h-full flex items-center justify-center">
            <div class="bg-gray-100 w-4/6 h-3/6 flex flex-col border border-black">
                <div class="flex items-center justify-center w-full h-1/6 mt-5">
                    <label class="text-4xl font-bold">Control de Asistencia</label>
                </div>
                <div class="flex items-center justify-center w-full h-1/6">
                    <label class="mr-2 font-bold text-3xl">Usuario:</label>
                    <select name="usuario" class="text-2xl text-center">
                        <option value="0">Seleccionar</option>
                        <?php
                            while ($row = $result->fetch_assoc()) {
                                echo '<option value="' . $row['idUsuario'] . '">' . $row['nombre'] . '</option>';
                            }
                        ?>
                    </select>
                </div>
                <div class="flex items-center justify-center w-full h-1/6">
                    <div class="flex items-center justify-center w-3/6">
                        <label class="mr-2 font-bold text-3xl">Fecha:</label>
                        <input class="text-2xl text-center" type="date" id="fecha" value="<?php echo date('Y-m-d'); ?>" readonly>
                    </div>
                    <div class="flex items-center justify-center w-3/6">
                        <label class="mr-2 font-bold text-3xl">Hora:</label>
                        <input class="text-xl text-center" type="text" id="hora" readonly>
                    </div>
                </div>
                <div class="flex items-center justify-center w-full h-1/6">
                    <div class="flex items-center justify-center w-3/6">
                        <button class="text-2xl bg-white hover:bg-gray-100 text-black border border-black font-bold py-2 px-4 rounded-md relative shadow-md">Ingreso</button>
                    </div>
                    <div class="flex items-center justify-center w-3/6">
                        <button class="text-2xl bg-white hover:bg-gray-100 text-black border border-black font-bold py-2 px-4 rounded-md relative shadow-md">Salida</button>
                    </div>
                </div>
                <div class="flex items-center justify-center w-full h-1/6">
                    <a href="#" class="text-2xl text-blue-500 underline">Ver Reporte</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            var usuarioSeleccionado;

            $("select[name='usuario']").on("change", function() {
                usuarioSeleccionado = $(this).val();
            });

            $("button:contains('Ingreso'), button:contains('Salida')").on("click", function() {
                var tipoRegistro = $(this).text().trim();
                if (usuarioSeleccionado !== undefined) {
                    registrarAsistencia(usuarioSeleccionado, tipoRegistro);
                } else {
                    alert("Error: usuario Seleccionado no definido");
                }
            });

            function registrarAsistencia(idUsuario, tipoRegistro) {
                var fecha = $("#fecha").val();
                var hora = $("#hora").val();

                $.ajax({
                    type: "POST",
                    url: "registrar_asistencia.php",
                    data: {
                        idUsuario: idUsuario,
                        tipoRegistro: tipoRegistro,
                        fecha: fecha,
                        hora: hora
                    },
                    success: function(response) {
                        alert(response);
                    },
                    error: function(error) {
                        alert("Error en la solicitud AJAX:", error);
                    }
                });
            }

            // Función para agregar un cero delante de números menores que 10
            function agregarCero(numero) {
                return numero < 10 ? "0" + numero : numero;
            }

            // Función para actualizar la hora y los segundos cada segundo
            function actualizarHora() {
                var horaActual = new Date();
                var ampm = horaActual.getHours() >= 12 ? 'PM' : 'AM';
                var horaFormato = agregarCero(horaActual.getHours() % 12) + ":" + agregarCero(horaActual.getMinutes()) + ":" + agregarCero(horaActual.getSeconds()) + " " + ampm;
                $("#hora").val(horaFormato);
            }

            // Actualizar la hora y los segundos cada segundo
            setInterval(actualizarHora, 1000);
        });
    </script>
</body>
</html>
