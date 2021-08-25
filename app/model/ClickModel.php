<?php 

namespace App\Model;

use App\Core\Database;

class ClickModel extends Database {

  public function trackClick($link_id) {
    $ip = $_SERVER["REMOTE_ADDR"];
    $values = [
      "link" => $link_id,
      "clicked_at" => 'NOW()',
      "ip" => $ip
    ];
    $this->insert("clicks", $values);
    $clickCount = (int) $this->selectOnly("links", "id", $link_id, "click_count")["click_count"];
    $clickCount++;
    $this->update("links", "click_count", $clickCount, "id", $link_id);
  }

  public function getClickData($link_id) {
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

}