<?php 

namespace Minesweeper;


class Minesweeper {
    private $rows = 0;
    private $cols = 0;
    private $mines = 0;
    private $board = [];
    private $fogOfWar = [];
    private $mineLocations = [];
    private $count = [];

    public function __construct($rows = 10, $cols = 10 , $mineLocations = [],  $mines = 15){
        $this->rows = $rows;
        $this->cols = $cols;
        $this->mines = $mines;
        $this->mineLocations = $mineLocations;

        $this->initializeBoard($this->board, "hidden");
        $this->initializeBoard($this->fogOfWar, "#");
        if(empty($mineLocations) ) 
            $this->placeRandomMines();
        
        $this->calculateNumberOfMinesSurroundingCells();
    }

    private function initializeBoard(array &$board, $contents ){
        for ($i = 0; $i < $this->rows; $i++) {
            for ($j = 0; $j < $this->cols; $j++) {
                $board[$i][$j] = $contents;
            }
        }

    }


    public function displayBoard() {
        echo " ";
        for ($i = 0; $i < $this->cols; $i++) {
            echo " " . ($i + 1);
        }
        echo "\n";
        for ($i = 0; $i < $this->rows; $i++) {
            echo ($i + 1) . " ";
            for ($j = 0; $j < $this->cols; $j++) {
                if($this->fogOfWar[$i][$j] !== null){ // display fog of war if present
                    echo "#";
                } else{
                    if (in_array([$i, $j], $this->mineLocations)) {
                        echo "*";
                    } else {
                        if ($this->count[$i][$j] == 0) {
                            echo " ";
                        } else {
                            echo $this->count[$i][$j];
                        }
                    }
            
                }
                echo " ";
            }
            echo "\n";
        }
    }

    public function reveal($x, $y) {
        $this->clearFogOfWar($x,$y);

        if(in_array([$x,$y],$this->mineLocations))
            return 'You lost';

        if($this->checkVictoryConditions())
            return 'You win';
        
        $this->displayBoard();
        return 'continue...';
    }


    private function checkVictoryConditions(){
        $clearedPoints = [];
        for($i = 0; $i <= $this->rows - 1; $i++){
            for($j = 0; $j <= $this->cols - 1; $j++){
                if($this->fogOfWar[$i][$j] !== null)
                    $cleared_points[] =  "{$i},{$j}";
            }
        }
        $mineLocations = array_map(function($value){
            return "{$value[0]},{$value[1]}";
        }, $this->mineLocations);
        $remaining = array_diff($clearedPoints,$mineLocations);
        return count($remaining) === 0; 

    }

    private function clearFogOfWar($x,$y ){
        if($x < 0 || $y < 0 || $x > $this->rows || $y > $this->cols || $this->fogOfWar[$x][$y] === null)
            return null;

        $this->fogOfWar[$x][$y] = $this->fogOfWar[$x][$y] !== null ? null : $this->fogOfWar[$x][$y];
        if ($this->count[$x][$y] !== 0
            || in_array([$x,$y], $this->mineLocations) ) 
            return null;

        $this->clearFogOfWar( $x , $y + 1);
        $this->clearFogOfWar( $x , $y - 1);
        $this->clearFogOfWar( $x - 1 , $y );
        $this->clearFogOfWar( $x + 1 , $y );
        $this->clearFogOfWar( $x - 1, $y - 1);
        $this->clearFogOfWar( $x + 1, $y - 1 );
        $this->clearFogOfWar( $x + 1, $y + 1 );
        $this->clearFogOfWar( $x - 1, $y + 1);


        return null;
    }

    

    private function placeRandomMines(){
        // Place mines randomly on the board
        $this->mineLocations = [];
        for ($k = 0; $k < $this->mines; $k++) {
            $i = rand(0, $this->rows - 1);
            $j = rand(0, $this->cols - 1);
            if (!in_array([$i, $j], $this->mineLocations)) {
                $this->mineLocations[] = [$i, $j];
            } else {
                $k--;
            }
        }
    }
    private function calculateNumberOfMinesSurroundingCells(){
        // Calculate the number of mines surrounding each cell
        $this->count = [];
        for ($i = 0; $i < $this->rows; $i++) {
            for ($j = 0; $j < $this->cols; $j++) {
                $this->count[$i][$j] = $this->calculateNumberOfMinesSurroundingCell($i,$j);
            }
        }
    }


    private function calculateNumberOfMinesSurroundingCell($x,$y){
        $count = 0;
        foreach ($this->mineLocations as $mine) {
            if (abs($x - $mine[0]) <= 1 && abs($y - $mine[1]) <= 1) {
                $count++;
            }
        }
        return $count;
    }



}



    ?>
