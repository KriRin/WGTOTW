<?php

namespace Mos\Comment;

/**
 * To attach comments-flow to a page or some content.
 *
 */
class Comments extends \Anax\MVC\CDatabaseModel {



public function findAllComments($page = null) {
    $this->db->select()
        ->from($this->getSource())
        ->where("page = ?");
    
    $this->db->execute([$page]);
    $this->db->setFetchModeClass(__CLASS__);
    return $this->db->fetchAll();
}



public function deleteAll($page = null) {
    $this->db->delete(
        $this->getSource(),
        'page = ?'
    );
    return $this->db->execute([$page]);
}



public function deleteOne($id, $page = null) {
    $comments = $this->findAllComments($page);
    foreach($comments as $comment) {
        if($comment->id == $id) {
            $this->delete($id);
        }
    }
}


public function findComments() {
    $this->db->select()
        ->from($this->getSource());
        
    $this->db->execute();
    $this->db->setFetchModeClass(__CLASS__);
    return $this->db->fetchAll();
}





}
