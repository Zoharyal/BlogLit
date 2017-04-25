<?php

namespace BlogLit\DAO;

use Doctrine\DBAL\Connection;
use BlogLit\Domain\Comment;

class CommentDAO extends DAO
{
    private $chapterDAO;
    
    public function  setChapterDAO(ChapterDAO $chapterDAO) {
        $this->chapterDAO = $chapterDAO;
    }
    
    public function findAllByChapter($chapterId) {
        $chapter = $this->chapterDAO->find($chapterId); 
        $sql = "select com_id, com_content, com_author, com_date, parent_id from t_comment where chap_id=? order by com_id";
        $result = $this->getDb()->fetchAll($sql, array($chapterId));
        $comments = array();
        
        foreach( $result as $row) {
            $comId = $row['com_id'];
            $comment = $this->buildDomainObject($row);
            $comment->setChapter($chapter);
            $comments[$comId] = $comment;
        }
        
        
        return $comments;
        
    }
    
    
   
    public function findAll() {
        $sql = "select * from t_comment order by com_id";
        $result = $this->getDb()->fetchAll($sql);
        $entities = array();
        foreach ($result as $row) {
            $id = $row['com_id'];
            $entities[$id] = $this->buildDomainObject($row);
        }
        return $entities;
    }
    
    public function find($id) {
        $sql = "select * from t_comment where com_id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));
        
        if($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No comment matching " . $id);
    }
    
    
    public function save(Comment $comment) {
        $commentData = array(
            'chap_id' => $comment->getChapter()->getId(),
            'com_content'   => $comment->getContent(),
            'com_author' => $comment->getAuthor(),
            'com_date' => $comment->createDate()
            );
        if ($comment->getId()) {
            $this->getDb()->update('t_comment', $commentData, array('com_id' => $comment->getId()));
        } else {
            $this->getDb()->insert('t_comment', $commentData);
            $id = $this->getDb()->lastInsertId();
            $comment->setId($id);
        }
    }
    
    public function delete($id) {
        $this->getDb()->delete('t_comment', array('com_id' => $id));
    }
    
    public function deleteAllByChapter($chapterId) {
        $this->getDb()->delete('t_comment', array('chap_id' => $chapterId));
    }
    
    protected function buildDomainObject(array $row) {
        $comment = new Comment();
        $comment->setId($row['com_id']);
        $comment->setContent($row['com_content']);
        $comment->setAuthor($row['com_author']);
        $comment->setDateAjout($row['com_date']);
        
        
        if (array_key_exists('chap_id', $row)) {
            $chapId = $row['chap_id'];
            $chapter = $this->chapterDAO->find($chapId);
            $comment->setChapter($chapter);
        }

        return $comment;
        
    }
}