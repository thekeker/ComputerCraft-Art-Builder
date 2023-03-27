<?php

class SchematicsController extends Schematics
{
    /**
     * Uploads converted JPG data to the database.
     * 
     * @param string $id The string id of the schematic.
     * @param int $width The string id of the schematic.
     * @param int $height The string id of the schematic.
     * @param array $objectData Contains the Binary Schematic JSON object of the image.
     */
    public function uploadJpgBinarySchematic($id, $width, $height, $objectData)
    {
        $schematic['id'] = $id;
        $schematic['width'] = $width;
        $schematic['height'] = $height;
        $schematic['objectData'] = $objectData;
        $this->setSchematics($schematic);
    }
}
