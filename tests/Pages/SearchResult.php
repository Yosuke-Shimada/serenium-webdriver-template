<?php
namespace Tests\Pages;

use Facebook\WebDriver\WebDriverExpectedCondition;

/**
 * PageObjects<br>
 * SearchResult
 */
class SearchResult extends \Tests\Pages\Contracts\Page
{
    private const SEARCH_RESULT_NUMBER_CLASS = '.resultNum';

    /** {@inheritdoc} */
    protected $title = '「%s」の検索結果 - Yahoo!検索';

    /** {@inheritdoc} */
    protected $url = 'https://search.yahoo.co.jp/search;';

    public function __construct($driver, $title)
    {
        // ページタイトルが動的に設定されるので、事前に変数に設定してから親クラスのtitle判定につなげる
        $this->title = sprintf($this->title, $title);
        parent::__construct($driver);
    }

    /**
     * 検索結果の件数が画面に表示されているかどうかを返却する
     * @return bool
     */
    public function hasResultNumber()
    {
        return $this->countElementsByClass(self::SEARCH_RESULT_NUMBER_CLASS) > 0;
    }
}