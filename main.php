<?php


require './src/Minesweeper.php';


$minesweeper = new Minesweeper\MineSweeper();
$minesweeper->displayBoard();

$minesweeper->reveal(3,5);
$minesweeper->reveal(2,8);
$minesweeper->reveal(1,2);
