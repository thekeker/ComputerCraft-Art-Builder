<?php

class Schematics extends Dbh
{
    /**
     * Gets schematics data from the database.
     * 
     * @param string $id The string id of the schematic.
     */
    protected function getSchematics($id)
    {
        $sql = "SELECT * FROM schematics WHERE id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetchAll();
    }

    /**
     * Inserts the schematics into the database.
     * 
     * @param array $schematic Contains the id, width, height, and objectData(json) of the image.
     */
    protected function setSchematics($schematic)
    {
        if (empty($schematic['id'])) {
            return false;
        }
        if (!is_numeric($schematic['width'])) {
            return false;
        }
        if (!is_numeric($schematic['height'])) {
            return false;
        }
        if (empty($schematic['objectData'])) {
            return false;
        }

        $id = $schematic['id'];
        $webName = "test";
        $width = $schematic['width'];
        $height = $schematic['height'];
        $objectData = $schematic['objectData'];
        $imgPath = "test";

        $sql = "INSERT INTO schematics (id, webName, width, height, objectData, imgPath) VALUES (?,?,?,?,?,?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$id, $webName, $width, $height, $objectData, $imgPath]);
    }


    /**
     * Updates existing schematic data within the database.
     * 
     * @param string $method The method being used to update the schematic.
     * @param array $schematic Contains the id, width, height, and objectData(json) of the image.
     */
    protected function updateSchematics($method, $schematic)
    {
        if (empty($schematic['id'])) {
            return false;
        }
        if (!is_numeric($schematic['width'])) {
            return false;
        }
        if (!is_numeric($schematic['height'])) {
            return false;
        }
        if (empty($schematic['objectData'])) {
            return false;
        }

        $id = $schematic['id'];
        $width = $schematic['width'];
        $height = $schematic['height'];
        $objectData = $schematic['objectData'];

        $sql = "UPDATE schematics (width, height, objectData) VALUES (?,?,?) WHERE id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$width, $height, $objectData, $id]);
    }

    /**
     * Removes existing schematics data from the database.
     * 
     * @param string $id The string id of the schematic.
     */
    protected function deleteSchematics($id)
    {
        if (empty($id)) {
            return false;
        }

        $sql = "DELETE FROM schematics WHERE id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$id]);
    }
}
