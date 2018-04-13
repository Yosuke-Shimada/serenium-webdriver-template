<?php
namespace Tests\Pages\Concerns;

use Facebook\WebDriver\Exception\NoSuchElementException;
use Facebook\WebDriver\WebDriverBy as By;
use Facebook\WebDriver\WebDriverKeys as Keys;
use Facebook\WebDriver\WebDriverSelect;

/**
 * PageObjects<br>
 * Element操作用trait
 *
 */
trait Element
{
    /**
     * セレクタが一致する要素に対して文字列を入力する<br>
     * id > name の順で要素を検索
     * @param string $selector
     * @param string $str
     * @return $this
     */
    protected function type($selector, $text)
    {
        try {
            $this->findElementById($selector)->clear()->sendKeys($text);
        } catch (NoSuchElementException $e) {
            $this->findElementByName($selector)->clear()->sendKeys($text);
        }
        return $this;
    }

    /**
     * idが一致するラジオボタンに対して値の選択を行う<br>
     * @param string $id
     * @return $this
     */
    protected function radio($id)
    {
        $this->findElementById($id)->click();
        return $this;
    }

    /**
     * セレクタが一致するセレクトボックスに対して値の選択を行う<br>
     * @param string $id
     * @param string $value
     * @return $this
     */
    protected function select($id, $value)
    {
        $select = new WebDriverSelect($this->findElementById($id));

        // キャッシュなどの効果で既に$valueを選択済みの状態である場合に想定通りの動きをしなかった。回避策として一度一番上の要素を選択させてから$valueを選択させる
        $select->selectByIndex(0);
        $select->selectByValue($value);

        return $this;
    }

    /**
     * テキストが一致する要素に対してクリックを実行する
     * @param string $text
     */
    protected function clickText($text)
    {
        $this->findElementByLink($text)->click();
        return $this;
    }

    /**
     * idが一致する要素をクリックする<br>
     * @param string $id
     * @return $this
     */
    protected function click($id)
    {
        $this->findElementById($id)->click();
        return $this;
    }

    /**
     * 指定したクラスを持つ要素の個数を返却する
     * @param string $class
     * @return integer
     */
    protected function countElementsByClass($class)
    {
        return count($this->driver->findElements(By::cssSelector($class)));
    }

    /**
     * idが一致する要素を返却する
     * @param string $sid
     * @return \Facebook\WebDriver\Remote\RemoteWebElement NoSuchElementException is thrown in HttpCommandExecutor if no element is found.
     */
    protected function findElementById($id)
    {
        return $this->driver->findElement(By::id($id));
    }

    /**
     * nameが一致する要素を返却する
     * @param string $name
     * @return \Facebook\WebDriver\Remote\RemoteWebElement NoSuchElementException is thrown in HttpCommandExecutor if no element is found.
     */
    protected function findElementByName($name)
    {
        return $this->driver->findElement(By::name($name));
    }

    /**
     * リンクテキストが一致する要素を返却する
     * @param string $link_text
     * @return \Facebook\WebDriver\Remote\RemoteWebElement NoSuchElementException is thrown in HttpCommandExecutor if no element is found.
     */
    protected function findElementByLink($link_text)
    {
        return $this->driver->findElement(By::linkText($link_text));
    }
}
