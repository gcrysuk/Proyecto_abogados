<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Inicio</title>
    <link rel="stylesheet" href="../css/estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #f9f9f9;
            font-size: 18px;
            /* Incrementar tamaño de fuente */
            padding: 20px;
        }

        .container {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
            width: 300px;
        }

        .card i {
            font-size: 50px;
            color: #007BFF;
            margin-bottom: 15px;
        }

        .card h3 {
            font-size: 24px;
            margin: 10px 0;
        }

        .card a {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 15px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .card a:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <header style="text-align: center; margin-bottom: 30px;">
        <h1 style="font-size: 36px;">Bienvenido a la Gestión de Abogados</h1>
        <p style="font-size: 20px; color: #555;">Seleccione una opción para comenzar</p>
    </header>

    <div class="container">
        <div class="card">
            <i class="fas fa-user"></i>
            <h3>Gestión de Clientes</h3>
            <a href="views/clientes.php">Ir a Clientes</a>
        </div>

        <div class="card">
            <i class="fas fa-gavel"></i>
            <h3>Gestión de Causas</h3>
            <a href="views/causas.php">Ir a Causas</a>
        </div>

        <div class="card">
            <i class="fas fa-balance-scale"></i>
            <h3>Seguimiento de Causas</h3>
            <a href="views/seguimientos.php">Ir a Seguimientos</a>
        </div>

        <div class="card">
            <i class="fas fa-book"></i>
            <h3>Gestión de Estados</h3>
            <a href="views/estados.php">Ir a Estados</a>
        </div>
    </div>
</body>

</html>

