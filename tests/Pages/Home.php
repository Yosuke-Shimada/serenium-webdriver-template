<?php
namespace Tests\Pages;

use Facebook\WebDriver\WebDriverExpectedCondition;

/**
 * PageObjects<br>
 * HOME
 */
class Home extends \Tests\Pages\Contracts\Page
{
    private const SEARCH_INPUT_ID = 'srchtxt';
    private const SEARCH_SUBMIT_ID = 'srchbtn';

    /** {@inheritdoc} */
    protected $title = 'Yahoo! JAPAN';

    /** {@inheritdoc} */
    protected $url = 'https://www.yahoo.co.jp/';

    /**
     * 検索を実行する
     * @return \Pages\Services\SeachResult
     */
    public function search($search)
    {
        $this->type(self::SEARCH_INPUT_ID, $search)
            ->click(self::SEARCH_SUBMIT_ID);
        return new SearchResult($this->driver, $search);
    }
}
