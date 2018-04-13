<?php
namespace Tests\Pages\Contracts;

use Facebook\WebDriver\WebDriverBy as By;

/**
 * PageObjects<br>
 * 基底クラス
 *
 */
abstract class Page
{
    use \Tests\Pages\Concerns\Element;

    /** @var \Facebook\WebDriver\Remote\RemoteWebDriver */
    protected $driver;

    /** @var string */
    protected $title;

    /** @var string */
    protected $url;

    /**
     * 各Pageクラスに設定されているTitleプロパティと実際のTitleを比較して正しく画面遷移できていることを確認する
     */
    public function __construct($driver)
    {
        $this->driver = $driver;
        // URL・タイトルを基に画面の描画が完了したか否かを判断する
        $this->driver->wait(5)->until(
            function () {
                return $this->urlMatch($this->url)
                    && $this->titleIs($this->title);
            }
        );
    }

    /**
     * URLの比較を行う
     * @param string $url
     * @return bool 部分一致する場合はtrue
     */
    protected function urlMatch($url)
    {
        return strpos($this->driver->getCurrentURL(), $url) === 0;
    }

     /**
     * タイトルの比較を行う
     * @param string $title
     * @return bool 完全一致する場合はtrue
     */
    protected function titleIs($title)
    {
        return $this->driver->getTitle() === $title;
    }
}