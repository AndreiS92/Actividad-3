<?php
session_start();
require_once "config.php"; 

if (!isset($_SESSION["username"])) {
    header("location:index.php");
    exit();
}

echo "<h1>Bienvenido, " . htmlspecialchars($_SESSION["username"]) . "</h1>";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container align-middle">

    <div class="row">
        <?php
        $query = "SELECT * FROM user"; 
        $result = mysqli_query($connection, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '
                <div class="col-md-4 my-3">
                    <div class="card" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title">' . htmlspecialchars($row["username"]) . '</h5>
                            <h6 class="card-subtitle mb-2 text-muted">ID: ' . htmlspecialchars($row["id"]) . '</h6>
                        </div>
                    </div>
                </div>
                ';
            }
        } else {
            echo "<p>No se encontraron usuarios.</p>";
        }
        ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<a href="logout.php">Cerrar sesión</a>
</body>
</html>
