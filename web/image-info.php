<?php
include 'includes/al.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/styles.css">
    <script src="assets/js/main.js" defer></script>
    <title>JsonBinarySchematic</title>
</head>

<body>
    <header>
        <h1>CCPixelBuilder</h1>
    </header>

    <main>
        <div class="block-count">
            <?php
            if (isset($_GET['id'])) {
                $sc = new SchematicCounter(htmlspecialchars($_GET['id']));
            }
            ?>
        </div>
    </main>

    <footer>Copyright &copy; <?php echo date("Y"); ?> Keker</footer>
</body>

</html>