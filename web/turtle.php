<?php
include 'includes/al.php';

if (!empty($_GET['id'])) {
    $sv = new SchematicsView();
    $schematic = $sv->turtleGetSchematic($_GET['id']);

    echo $schematic[0]['objectData'];
}
