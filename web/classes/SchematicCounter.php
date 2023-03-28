<?php
class SchematicCounter extends SchematicsView
{
    public function __construct($id)
    {
        $data = $this->turtleGetSchematic($id);
        $schematic = json_decode($data[0]['objectData'], true);

        $this->countBlocks($data, $schematic);
    }

    public function countBlocks($data, $schematic)
    {
        $blockOneCount = 0;
        $blockTwoCount = 0;
        $blockThreeCount = 0;
        $blockFourCount = 0;
        $totalBlocks = 0;
        for ($i = 0; $i < $data[0]['height']; $i++) {
            for ($j = 0; $j < $data[0]['width']; $j++) {
                switch ($schematic[$i][$j]) {
                    case 0:
                        $blockOneCount++;
                        break;

                    case 1:
                        $blockTwoCount++;
                        break;

                    case 2:
                        $blockThreeCount++;
                        break;

                    case 3:
                        $blockFourCount++;
                        break;

                    default:
                        break;
                }
                $totalBlocks++;
            }
            // echo "<br>";
        }
        echo "1st Chest (Black pixels) will require: " . $blockOneCount . "<br>";
        echo "2nd Chest (White pixels) will require: " . $blockTwoCount . "<br>";
        echo "3rd Chest (Red pixels) will require: " . $blockThreeCount . "<br>";
        echo "4th Chest (Green pixels) will require: " . $blockFourCount . "<br>";
        echo "Total Block Count: $totalBlocks";
    }
}
