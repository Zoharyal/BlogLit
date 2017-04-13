<?php

namespace BlogLit\Domain;

class Chapter {
    private $id;
    private $title;
    private $content;
    private $dateAjout;
    private $dateModif;
    
    public function getId() {
        return $this->id;
    }
    
    public function setId($id) {
        $this->id = $id;
        return $this;
    }
    public function getNextId() {
        return $this->id + 1;
    }
    public function getPrevId() {
        return $this-> id - 1;
    }
    
    public function getTitle() {
        return $this->title;
    }
    
    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }
    
    public function getContent() {
        return $this->content;
    }
    
    public function setContent($content) {
        $this->content = $content;
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