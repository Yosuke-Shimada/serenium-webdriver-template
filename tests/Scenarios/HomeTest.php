<?php
namespace Tests\Scenarios;

use Tests\Pages\Home;

class HomeTest extends \Tests\Scenarios\Contracts\TestCase
{
    public function test()
    {
        $page = new Home($this->driver);
        $result_page = $page->search('Google');
        $this->assertTrue($result_page->hasResultNumber());
    }
}
