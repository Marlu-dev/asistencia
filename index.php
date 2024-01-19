<?php
date_default_timezone_set('America/Lima'); // Establecer la zona horaria de Perú
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
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
                        <option value="1">Luis Cadillo</option>
                        <option value="2">Nestor Cordova</option>
                        <option value="3">Diandra Ticona</option>
                        <option value="4">Mariano Sabana</option>
                    </select>
                </div>
                <div class="flex items-center justify-center w-full h-1/6">
                    <div class="flex items-center justify-center w-3/6">
                        <label class="mr-2 font-bold text-3xl">Fecha:</label>
                        <input class="text-2xl text-center" type="date" id="fecha" value="<?php echo date('Y-m-d'); ?>" readonly>
                    </div>
                    <div class="flex items-center justify-center w-3/6">
                        <label class="mr-2 font-bold text-3xl">Hora:</label>
                        <input class="text-2xl text-center" type="time" id="hora" value="<?php echo date('H:i'); ?>" readonly>
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
</body>
</html>