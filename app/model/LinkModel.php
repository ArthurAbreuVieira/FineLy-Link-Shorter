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


    // var_dump($links);
    // die();

    
    return $links;
  }
}