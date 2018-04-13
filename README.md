# Selenium WebDriver 本体のDL  

`facebook/php-webdriver`はSeleniumの2系,3系どちらにも対応しているとのことなので、3系の最新をダウンロードする。  
http://selenium-release.storage.googleapis.com/index.html?path=3.4/  
更に使用するブラウザに合わせてドライバをダウンロードし、Selenium WebDriverを起動しておく。  

## FireFoxを使う場合  
https://github.com/mozilla/geckodriver/releases  
```
D:\>java -Dwebdriver.gecko.driver="Selenium\geckodriver.exe" -jar "Selenium\selenium-server-standalone-3.4.0.jar"
```

## Chromeを使う場合  
http://chromedriver.storage.googleapis.com/index.html  
```
D:\>java -Dwebdriver.chrome.driver="Selenium\chromedriver.exe" -jar "Selenium\selenium-server-standalone-3.4.0.jar" 
```

### 実行  
```
$ ./vendor/phpunit tests
```
