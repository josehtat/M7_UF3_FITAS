<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>FITA 4 - EJERCICIO 4.2</title>
</head>

<body>
    <?php
    # (1.1) Conexión a MySQL (host, usuario, contraseña)
    $conn = mysqli_connect('localhost', 'admin123', 'superlocal777');

    # (1.2) Selección de la base de datos
    mysqli_select_db($conn, 'mundo');

    # (4.1) Consulta para obtener los idiomas disponibles
    $consultaContinentes = "SELECT DISTINCT c.continent FROM country c;";
    $resultContinentes = mysqli_query($conn, $consultaContinentes);

    if (!$resultContinentes) {
        die('Error al obtener los continentes: ' . mysqli_error($conn));
    }

    # (4.2) Generar opciones del select
    $opciones = "";
    while ($registre = mysqli_fetch_assoc($resultContinentes)) {
        $opciones .= "<option value='" . $registre["continent"] . "'>" . $registre["continent"] . "</option>";
    }
    ?>
    
    <form method="post">
        <input type="checkbox" name="continent[]" value="North America">Norte America<br>
        <input type="checkbox" name="continent[]" value="Asia">Asia<br>
        <input type="checkbox" name="continent[]" value="Africa">Africa<br>
        <input type="checkbox" name="continent[]" value="Europe">Europa<br>
        <input type="checkbox" name="continent[]" value="South America">America del Sur<br>
        <input type="checkbox" name="continent[]" value="Oceania">Oceania<br>
        <input type="checkbox" name="continent[]" value="Antarctica">Antarctica<br>
        <br>
        <input type="submit" name="Mostrar" value="Mostrar">
    </form>

    <?php
    var_dump($_POST);
    # Verificamos si se ha enviado el formulario
    if (isset($_POST["continent"])) {
        $continentSelect = $_POST["continent"];

        # (2.1) Consulta para obtener los países que hablan el idioma seleccionado
        $consulta = "SELECT c.name  FROM country c WHERE c.continent = '$continentSelect';";

        # (2.2) Ejecutamos la consulta
        $resultat = mysqli_query($conn, $consulta);

        # (2.3) Verificamos si hubo un error en la consulta
        if (!$resultat) {
            $message  = 'Consulta inválida: ' . mysqli_error($conn) . "\n";
            $message .= 'Consulta realizada: ' . $consulta;
            die($message);
        }

        # (3.1) Mostrar los resultados
        echo "<ul>";
        while ($registre = mysqli_fetch_assoc($resultat)) {
            echo "<li>" . $registre["name"] . "</li>";
        }
        echo "</ul>";
    }
    ?>

</body>

</html>