<?php

namespace Krri\posts;

/**
 * To attach posts-flow to a page or some content.
 *
 */
class Posts extends \Anax\MVC\CDatabaseModel {



public function findAllPosts($posttype = null) {
    $this->db->select()
        ->from($this->getSource())
        ->where("posttype = ?")
        ->orderby("timestamp DESC");
    
    $this->db->execute([$posttype]);
    $this->db->setFetchModeClass(__CLASS__);
    return $this->db->fetchAll();
}



public function findAllPostsWithTag($tag) {
    $this->db->select()
        ->from($this->getSource())
        ->where("posttype = ?")
        ->andwhere("tags LIKE ?")
        ->orderby("timestamp DESC");
    
    $this->db->execute(['1', '%'.$tag.'%']);
    $this->db->setFetchModeClass(__CLASS__);
    return $this->db->fetchAll();
}



public function deleteOne($id, $posttype = null) {
    $posts = $this->findAllPosts($posttype);
    foreach($posts as $post) {
        if($post->id == $id) {
            $this->delete($id);
        }
    }
}



public function findQuestion($id) {
    $this->db->select()
        ->from($this->getSource())
        ->where("id = ?");
        
    $this->db->execute([$id]);
    $this->db->setFetchModeClass(__CLASS__);
    
    return $this->db->fetchAll();
}



public function findAnswers($id) {
    $this->db->select()
        ->from($this->getSource())
        ->where("QuestionID = ?");
        
    $this->db->execute([$id]);
    $this->db->setFetchModeClass(__CLASS__);
    return $this->db->fetchAll();
}



public function findUsersPosts($id) {
    $this->db->select()
        ->from($this->getSource())
        ->where("userid = ?");
    
    $this->db->execute([$id]);
    $this->db->setFetchModeClass(__CLASS__);
    return $this->db->fetchAll();
}



public function findLatestQuestions() {
    $this->db->select()
        ->from($this->getSource())
        ->limit('5')
        ->where("posttype = ?")
        ->orderby("timestamp DESC");
        
    $this->db->execute(['1']);
    $this->db->setFetchModeClass(__CLASS__);
    
    return $this->db->fetchAll();
}



public function findMostActUsers() {
    $this->db->select('userid')
        ->from($this->getSource());
        
    $this->db->execute();
    $this->db->setFetchModeClass(__CLASS__);
    
    return $this->db->fetchAll();
}



}
