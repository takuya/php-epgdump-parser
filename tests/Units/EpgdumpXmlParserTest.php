<?php


namespace Tests\Units;


use Tests\TestCase;
use Takuya\RecorderUtil\EpgDumpXML\EpgDumpXmlBS;

class EpgdumpXmlParserTest extends TestCase {
  
  public function test_epgdump_xml_parse_BS () {
    $xml = __DIR__.'/../test-data/epgdump-sample-bs.xml';
    $stream = fopen($xml, 'r');
    $dumper = new EpgDumpXmlBS($stream);
    $list = $dumper->programmes();

    // array(5) {
    //   ["channel"]=>
    //   array(2) {
    //     ["uid"]=>
    //     string(22) "4101.epgdata.ontvjapan"
    //     ["name"]=>
    //     string(7) "NHK BS1"
    //   }
    //   ["title"]=>
    //   string(18) "ＢＳニュース"
    //   ["description"]=>
    //   string(159) "▽国内外のニュースや気象情報をお伝えします。　※スポーツ中継がある場合は、放送時間や内容が変更になります。"
    //   ["time"]=>
    //   array(2) {
    //     ["start"]=>
    //     string(25) "2022-01-17T16:50:00+09:00"
    //     ["stop"]=>
    //     string(25) "2022-01-17T17:00:00+09:00"
    //   }
    //   ["categoroy"]=>
    //   array(2) {
    //     ["en"]=>
    //     string(4) "news"
    //     ["ja"]=>
    //     string(21) "ニュース・報道"
    //   }
    // }
    $this->assertEquals(3968, sizeof($list));
    $this->assertEquals('2022-01-17T16:50:00+09:00', $list[9]['time']['start']);
    $this->assertEquals('2022-01-17T17:00:00+09:00', $list[9]['time']['stop']);
    $this->assertEquals('ＢＳニュース', $list[9]['title']);
    $this->assertEquals('▽国内外のニュースや気象情報をお伝えします。'.
                        '　※スポーツ中継がある場合は、放送時間や内容が変更になります。',
                        $list[9]['description']);
  }
}