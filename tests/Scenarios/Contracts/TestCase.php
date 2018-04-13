<?php
namespace Tests\Scenarios\Contracts;

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /** @const TIMEOUT_SECONDS 特定の要素を探した際に待機する最大秒数 */
    const TIMEOUT_SECONDS = 5;

    /** @const INITIALIZEED_URL 初回にアクセスするURL */
    const INITIALIZEED_URL = 'https://www.yahoo.co.jp/';

    /** @var array windows障害レポートのプロセスID */
    private $wer_fault_pids;

    /** @var \Facebook\WebDriver\Remote\RemoteWebDriver */
    protected $driver;

    /**
     * {@inheritdoc}
     * @see PHPUnit\Framework\TestCase::setUp()
     */
    public function setUp()
    {
        parent::setUp();
        // firefoxが強制終了されたかのようなwidnows障害レポートが毎回出力されてしまうので、障害レポートのプロセスを都度都度殺す
        // 誤って関係のない障害レポートのプロセスを殺さないように、テスト開始時点で既に稼働しているプロセスが存在しないかチェックする
        $this->wer_fault_pids = $this->processIds();

        $host = 'http://localhost:4444/wd/hub';

        $desired_capabilities = DesiredCapabilities::firefox();
        // SSL証明書の期限が切れていても続行させる
        $desired_capabilities->setCapability("acceptInsecureCerts", true);

        $this->driver = RemoteWebDriver::create($host, $desired_capabilities);
        $this->driver->manage()
            ->timeouts()
            ->implicitlyWait(self::TIMEOUT_SECONDS);
        $this->driver->manage()
            ->window()
            ->maximize();
        $this->driver->get(self::INITIALIZEED_URL);
    }

    /**
     * {@inheritdoc}
     * @see PHPUnit\Framework\TestCase::tearDown()
     */
    public function tearDown()
    {
        if ($this->hasFailed()) {
            $this->driver->takeScreenshot(__DIR__ . '/../screenshot/' . (new \DateTime())->format('Ymd_Hisu') . '_' . $this->getName() . '_failed.png');
        }

        $this->driver->quit();

        // firefoxが強制終了されたかのようなwidnows障害レポートが毎回出力されてしまうので、障害レポートのプロセスを都度都度殺す
        // テスト起動時に既に稼働していたプロセス以外（今回のテストで新たに作成されたプロセス）のみ殺す
        foreach ($this->processIds() as $id) {
            if (in_array($id, $this->wer_fault_pids)) {
                continue;
            }
            exec("taskkill /PID {$id}");
        }
        parent::tearDown();
    }

    /**
     * 現在動いているプロセスIDの一覧を返却する
     * @param string $name プロセス名
     * @return array プロセスIDを格納した添字配列
     */
    private function processIds($name = 'WerFault.exe')
    {
        $pid = [];
        exec("tasklist /FI \"IMAGENAME eq {$name}\"", $result);
        foreach ($result as $line => $value) {
            // ヘッダー行は処理しない
            if ($line < 3) {
                continue;
            }
            $pid[] = preg_split('/ +/', $value)[1];
        }
        return $pid;
    }
}
