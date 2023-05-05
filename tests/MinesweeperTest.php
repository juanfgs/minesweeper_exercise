<?php
namespace Minesweeper;

require './src/Minesweeper.php';

use PHPUnit\Framework\TestCase;

final class MinesweeperTest extends TestCase {
    
    public function testRevealLost(){
        $minesweeper = new MineSweeper(2, 2, [[0,0],[0,1],[1,0]]);
        // lose conditions
        $this->assertIsString($minesweeper->reveal(0,0));
        $this->assertStringContainsStringIgnoringCase('You lost', $minesweeper->reveal(0,0));
        
                     
    }
    public function testRevealWin(){
        $minesweeper = new MineSweeper(2, 2, [[0,0],[0,1],[1,0]]);
        // lose conditions

        $this->assertIsString($minesweeper->reveal(1,1));
        $this->assertStringContainsStringIgnoringCase('You win', $minesweeper->reveal(1,1));
        
                     
    }

}
    
    
