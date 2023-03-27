<?php

class SchematicsView extends Schematics
{
    /**
     * Gets converted data from the database.
     * 
     * @param string $schematicId The string id of the schematic.
     */
    public function turtleGetSchematic($schematicId)
    {
        return $this->getSchematics($schematicId);
    }
}
