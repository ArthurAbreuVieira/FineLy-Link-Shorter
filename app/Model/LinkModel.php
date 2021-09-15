<?php 

namespace App\Model;

use App\Core\Database;
use App\Controller\UserController as User;

class LinkModel extends Database {
  public function insertUrlInDatabase($values) {
    $owner = User::userIsLoggedIn() ? $_SESSION['user']['id'] : 0;
    $values['owner'] = $owner; 
    $this->insert('links', $values);
  }

  public function getLinksFromUser() {
    $user = $_SESSION['user']['id'];
    $links = $this->selectMany('links', 'owner', $user);
    
    foreach ($links as $key => $link) {
      $timezone = new \DateTimeZone('America/Sao_Paulo');
      $date = new \DateTime($link['created_at']);
      $timestamp = $date->getTimestamp();
      $date->setTimezone($timezone);
      $date->setTimestamp($timestamp);
      $date = $date->format('d-m-Y H:i:s');
      $links[$key]['created_at'] = $date;
      $links[$key]['shorted'] = $_ENV['BASE']."/".$link['id'];
    }

    return $links;
  }

  public function getLinkData($link_code) {
    $owner = User::userIsLoggedIn() ? $_SESSION['user']['id'] : 0;
    $linkData = $this->selectOnly('links', 'id', $link_code);
    if(!empty($linkData)) {
      if($linkData['owner'] === $owner) {
        $timezone = new \DateTimeZone('America/Sao_Paulo');
        $date = new \DateTime($linkData['created_at']);
        $timestamp = $date->getTimestamp();
        $date->setTimezone($timezone);
        $date->setTimestamp($timestamp);
        $date = $date->format('d-m-Y H:i:s');
        $linkData['created_at'] = $date;
        $linkData['shorted'] = $_ENV['BASE']."/".$linkData['id'];
        return $linkData;
      }
    }
    return;
  }

  public function updateLink($data) {
    $link = $this->getLinkData($data['id']);
    if(!empty($link)) {
      if($this->update('links', 'redirect', $data['redirect'], 'id', $data['id']))
        return true;      
    }
    return false;
  }

  public function deleteLink($data) {
    $link = $this->getLinkData($data['id']);
    if(!empty($link)) {
      if($this->delete('links', 'id', $data['id']))
        return true;      
    }
    return false;
  }
}