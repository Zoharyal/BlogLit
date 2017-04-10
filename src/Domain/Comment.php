<?php

namespace BlogLit\Domain;

class Comment
{
    private $id;
    private $author;
    private $content;
    private $chapter;
    private $dateAjout;
    
    public function getId() {
        return $this->id;
    }
    
    public function setId($id) {
        $this->id = $id;
        return $this;
    }
    
    public function getAuthor() {
        return $this->author;
    }
    
    public function setAuthor($author) {
        $this->author = $author;
        return $this;
    }
    
    public function getContent() {
        return $this->content;
    }
    
    public function setContent($content) {
        $this->content = $content;
        return $this;
    }
    
    public function getChapter() {
        return $this->chapter;
    }
    
    public function setChapter(Chapter $chapter) {
        $this->chapter = $chapter;
        return $this;
    }
    
    public function getDateAjout() {
        return $this->dateAjout;
    }
    
    public function setDateAjout($dateAjout) {
        $this->dateAjout = $dateAjout;
        return $this;
    }
    
    public function createDate() {
        return date("Y-m-d");
    }
}