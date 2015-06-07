<?php
namespace Anax\Users;
 
/**
 * Model for Users.
 *
 */
class Users extends \Anax\MVC\CDatabaseModel
{

public function findUN($username)
{
    $this->db->select()
            ->from($this->getSource())
            ->where("username = ?");
     
    $this->db->execute([$username]);
    return $this->db->fetchInto($this);
}


public function findUserWithId($userid) {
        $this->db->select()
            ->from($this->getSource())
            ->where("id = ?");
     
    $this->db->execute([$userid]);
    return $this->db->fetchInto($this);
}



}
