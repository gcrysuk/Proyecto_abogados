<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Inicio</title>
    <!-- Vinculamos una tipografía moderna desde Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #f0f4f8;
            font-family: 'Roboto', sans-serif;
            font-size: 16px;
            color: #333;
            margin: 0;
            padding: 0;
        }

        header {
            text-align: center;
            margin: 50px 0;
            padding: 0 20px;
        }

        header h1 {
            font-size: 40px;
            color: #2c3e50;
            margin-bottom: 10px;
        }

        header p {
            font-size: 18px;
            color: #7f8c8d;
        }

        .container {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 30px;
            padding: 20px;
        }

        .card {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            width: 280px;
            text-align: center;
            padding: 30px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        .card i {
            font-size: 60px;
            color: #3498db;
            margin-bottom: 20px;
        }

        .card h3 {
            font-size: 22px;
            color: #2c3e50;
            margin: 15px 0;
        }

        .card a {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 18px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }

        .card a:hover {
            background-color: #2980b9;
        }
    </style>
</head>

<body>
    <header>
        <h1>Bienvenido a la Gestión de Abogados</h1>
        <p>Seleccione una opción para comenzar</p>
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
