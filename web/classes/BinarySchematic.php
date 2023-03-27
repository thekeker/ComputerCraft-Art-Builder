<?php
include_once 'SchematicsController.php';
include_once 'Security.php';

class BinarySchematic
{
    protected $imageArray;
    protected $objectID;
    private $fileSizeLimit = 5; //size in MB

    public function __construct()
    {
        switch ($_POST['datatype']) {
            case 'img':
                $jpgFilePath = $this->uploadImage();
                $this->imageArray = $this->convertImageToJson($jpgFilePath);
                break;
            case 'json':
                if (!$this->uploadJson($_POST['jsonSchematic'])) {
                    header('Location: ?invalidJson');
                }
                break;
        }
    }

    private function pushSchematicToDatabase($binaryImageArray, $imageHeight, $imageWidth)
    {

        if (array_sum(array_map("count", $binaryImageArray)) != $imageHeight * $imageWidth) {
            return false;
        }

        $sec = new Security();
        $this->objectID = $sec->generateHash(8);
        $jsonBinaryArray = json_encode(array_reverse($binaryImageArray));

        $sc = new SchematicsController();
        $sc->uploadJpgBinarySchematic($this->objectID, $imageWidth, $imageHeight, $jsonBinaryArray);
    }

    private function uploadImage()
    {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["file"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["file"]["tmp_name"]);
        if ($check !== false) {
            $uploaded = true;
        } else {
            echo "File is not an image.<br>";
            $uploaded = false;
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            echo "File already exists.<br>";
            $uploaded = false;
        }

        // Check file size
        if ($_FILES["file"]["size"] > ($this->fileSizeLimit * 1000000)) {
            echo "Your file is too large.<br>";
            $uploaded = false;
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "jpeg") {
            echo "Please upload a JPG file.<br>";
            $uploaded = false;
        }

        // Upload error
        if ($uploaded == false) {
            echo "Sorry, your file was not uploaded.<br>";

            // Upload file
        } else {
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                $filename = htmlspecialchars(basename($_FILES["file"]["name"]));
                $filePath = "uploads/" . $filename;
                echo "The file $filename has been uploaded.<br>";
                return $filePath;
            } else {
                echo "There was an error uploading your file.<br>";
            }
        }
    }

    private function convertImageToJson($filePath)
    {
        $imageDetails = getimagesize($filePath);
        $imageWidth = $imageDetails[0];
        $imageHeight = $imageDetails[1];
        $image = imagecreatefromjpeg($filePath);

        $binaryImageArray = [];
        for ($i = 0; $i < $imageWidth; $i++) {
            for ($j = 0; $j < $imageHeight; $j++) {
                $rgbValue = imagecolorat($image, $i, $j);
                $r = ($rgbValue >> 16) & 0xFF;
                $g = ($rgbValue >> 8) & 0xFF;
                $b = $rgbValue & 0xFF;

                if ($r <= 5 && $g <= 5 && $b <= 5) {
                    $binaryImageArray[$j][$i] = 0;
                } elseif ($r >= 250 && $g >= 250 && $b >= 250) {
                    $binaryImageArray[$j][$i] = 1;
                } else {
                    break 2;
                }
            }
        }
        unlink($filePath);

        if ($this->pushSchematicToDatabase($binaryImageArray, $imageHeight, $imageWidth)) {
            return true;
        }
    }

    private function uploadJson($jsonUserInput)
    {
        if (!$convertedSchematic = json_decode($jsonUserInput, true)) {
            return false;
        }

        $imageHeight = count($convertedSchematic);
        $imageWidth = count($convertedSchematic[0]);

        if ($this->pushSchematicToDatabase($convertedSchematic, $imageHeight, $imageWidth)) {
            return true;
        }
    }
}