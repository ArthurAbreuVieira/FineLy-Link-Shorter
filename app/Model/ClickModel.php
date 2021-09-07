<?php 

namespace App\Model;

use App\Core\Database;

class ClickModel extends Database {

  public function trackClick($link_id) {
    $ip = $_SERVER["REMOTE_ADDR"];
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ip = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ip = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ip = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ip = $_SERVER['REMOTE_ADDR'];
    $ipStackData = file_get_contents("http://api.ipstack.com/$ip?access_key=39cbc49ed3d82e6a82299056a0c3fd8e");
    $values = [
      "link" => $link_id,
      "clicked_at" => 'NOW()',
      "ip" => $ip,
      "ipstack" => $ipStackData
    ];
    $this->insert("clicks", $values);
    $clickCount = (int) $this->selectOnly("links", "id", $link_id, "click_count")["click_count"];
    $clickCount++;
    $this->update("links", "click_count", $clickCount, "id", $link_id);
  }

  public function getClicks($link_id) {
    $data = $this->selectMany("clicks", "link", $link_id);
    if(empty($data)) {
      return false;
    }
    foreach($data as $key => $click) {
      $date = new \DateTime($click['clicked_at']);
      $date = $date->format('d-m-Y H:i:s');
      $click['clicked_at'] = str_replace(['-', ' '], ['/', ' - '], $date);
      $data[$key]['clicked_at'] = $click['clicked_at'];
    }
    $data = array_reverse($data);
    return $data; 
  }


  public function getClickData($id = null) {
    $data = $this->selectOnly("clicks", "id", $id);
    if(!empty($data)) {
      return $data;
    }
    return false;
  }
}