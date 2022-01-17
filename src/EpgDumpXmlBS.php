<?php

namespace Takuya\RecorderUtil\EpgDumpXML;

class EpgDumpXmlBS {
  
  protected $input;
  protected $dom;
  
  public function __construct( $f_in = null ) {
    $f_in && $this->open($f_in);
  }
  
  public function open( $file ) {
    
    if( is_resource($file) ) {
      $this->openStream($file);
      return;
    }
    if( is_string($file) ) {
      $this->openFile($file);
      return;
    }
    throw new \InvalidArgumentException();
  }
  
  protected function openStream( $f_in ) {
    if( get_resource_type($f_in) != 'stream' ) {
      throw new \RuntimeException('cannot open file.');
    }
    $this->input = $f_in;
  }
  
  protected function openFile( $f_in ) {
    if( ! is_readable($f_in) ) {
      throw new \RuntimeException('cannot open file.');
    }
    $this->input = fopen($f_in, 'r');
  }
  
  public function programmes( $datetime_format = 'c' ) {
    
    $timezone = 'Asia/Tokyo';
    $reset = date_default_timezone_get();
    date_default_timezone_set($timezone);
    $obj = $this->load_xml();
    $channels = $this->channels();
    $list = [];
    foreach ($obj->programme as $item) {
      $list[] = [
        'channel'     => [
          'uid'  => $item["channel"]->__toString(),
          'name' => $channels[$item["channel"]->__toString()],
        ],
        'title'       => $item->title->__toString(),
        'description' => $item->desc->__toString(),
        'time'        => [
          'start' => date($datetime_format, strtotime((string)$item['start'])),
          'stop'  => date($datetime_format, strtotime((string)$item['stop'])),
        ],
        'categoroy'   => [
          'en' => $item->xpath('./category[@lang="en"]')[0]->__toString(),
          'ja' => $item->xpath('./category[@lang="ja_JP"]')[0]->__toString(),
        ],
      ];
    }
    date_default_timezone_set($reset);
    
    return $list;
  }
  
  protected function load_xml() {
    return $this->dom ?: $this->dom = simplexml_load_string(stream_get_contents($this->input));
  }
  
  public function channels():array {
    $dom = $this->load_xml();
    $list = [];
    foreach ($dom->channel as $item) {
      $id = trim($item['id']->__toString());
      $name = trim($item->{'display-name'}->__toString());
      $list[$id] = $name;
    }
    
    return $list;
  }
}