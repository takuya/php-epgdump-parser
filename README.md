# php-epgdump-parser
epgdumpをphp/simplexmlでパースすする


## usage 
```php
<?php
use Takuya\RecorderUtil\EpgDumpXML\EpgDumpXmlBS;
$dumper = new EpgDumpXmlBS($xml);
$list = $dumper->programmes();
```


## run test
```
time ./vendor/bin/phpunit
```


## サンプルデータ

元データ
```xml
<programme start="20220117155000 +0900" stop="20220117160000 +0900" channel="4101.epgdata.ontvjapan">
  <title lang="ja_JP">ＢＳニュース</title>
  <desc lang="ja_JP">▽国内外のニュースや気象情報をお伝えします。　※スポーツ中継がある場合は、放送時間や内容が変更になります。</desc>
  <category lang="ja_JP">ニュース・報道</category>
  <category lang="en">news</category>
</programme>
```
出力配列
```php 
[
  'channel' => [
    'uid' => '4101.epgdata.ontvjapan',
    'name' => 'NHK BS1',
  ],
  'title' => 'ＢＳニュース',
  'description' => '▽国内外のニュースや気象情報をお伝えします。　※スポーツ中継がある場合は、放送時間や内容が変更になります。',
  'time' => [
    'start' => '2022-01-17T16:50:00+09:00',
    'stop' => '2022-01-17T17:00:00+09:00',
  ],
  'categoroy' => [
    'en' => 'news',
    'ja' => 'ニュース・報道',
  ],
]
```