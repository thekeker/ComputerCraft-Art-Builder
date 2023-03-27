<?php
include 'includes/al.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_POST['upload-button'])) {
    $bs = new BinarySchematic();
}
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
        <form id="datatypeSelectionForm">
            <input type="radio" name="uploadOption" id="uploadImage" onclick="changeFormDatatype(this)" checked>
            <label for="uploadImage" id="uploadImageLabel">Image</label>
            <input type="radio" name="uploadOption" id="uploadJson" onclick="changeFormDatatype(this)">
            <label for="uploadJson" id="uploadJsonLabel">JSON</label>
        </form>
        <div id="uploadImageFormContainer">
            <h2>Upload a Schematic Image</h2>
            <form method="post" enctype="multipart/form-data">
                <input type="hidden" name="datatype" value="img">
                <input type="file" name="file">
                <input type="submit" name="upload-button" value="Upload">
            </form>
        </div>
        <div id="uploadJsonFormContainer">
            <h2>Upload a JSON Schematic</h2>
            <form method="post" enctype="multipart/form-data" id="uploadJsonForm">
                <input type="hidden" name="datatype" value="json">
                <textarea name="jsonSchematic" id="jsonSchematicTextArea"><?php isset($_POST['jsonSchematic']) ? $_POST['jsonSchematic'] : '' ?></textarea>
                <input type="submit" name="upload-button" value="Upload">
            </form>
        </div>
    </main>

    <footer>Copyright &copy; <?php echo date("Y"); ?> Keker</footer>
</body>

</html>