<?php

use PHPUnit\Framework\TestCase;
use enesgur\Tureng;

class TurengTest extends TestCase
{
    public function testTranslateString()
    {
        $word = 'car';

        $tureng = new Tureng();
        $result = $tureng->word($word)->translate();

        $this->assertArrayHasKey($word, $result);
    }

    public function testTranslateArray()
    {
        $words = ['car', 'home'];

        $tureng = new Tureng();
        $result = $tureng->word($words)->translate();

        $this->assertArrayHasKey($words[1], $result);
    }

    public function testMultipleTranslate()
    {
        $tureng = new Tureng();

        $result = $tureng->word('car')->translate();
        $this->assertArrayHasKey('car', $result);
        
        $result = $tureng->clear()->word('home')->translate();
        $this->assertArrayHasKey('home', $result);
        $this->assertArrayNotHasKey('car', $result);
    }
}