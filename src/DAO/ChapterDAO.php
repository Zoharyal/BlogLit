<?php
namespace BlogLit\DAO;
use Doctrine\DBAL\Connection;
use BlogLit\Domain\Chapter;

class ChapterDAO extends DAO {
    
    public function findAll() {
        $sql = "select * from t_chapter order by chap_id desc";
        $result = $this->getDb()->fetchAll($sql);
        
        $chapters = array();
        foreach ($result as $row) {
            $chapterId = $row['chap_id'];
            $chapters[$chapterId] = $this->buildDomainObject($row);
        }
        return $chapters;
    }
    
    protected function buildDomainObject(array $row) {
        $chapter = new Chapter();
        $chapter->setId($row['chap_id']);
        $chapter->setTitle($row['chap_title']);
        $chapter->setContent($row['chap_content']);
        $chapter->setDateAjout($row['chap_dateAjout']);
        
        return $chapter;
        
    }
    
    public function find($id) {
        $sql = "select * from t_chapter where chap_id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));
        
        if ($row) {
            return $this->buildDomainObject($row);
        } else {
            throw new \Exception("No chapter matching id " . $id);
        }
    }
    
    
    
    public function save(Chapter $chapter) {
        $chapterData = array(
            'chap_title' => $chapter->getTitle(),
            'chap_content' => $chapter->getContent(),
            'chap_dateAjout' => $chapter->createDate(),
        );
        
        if ($chapter->getId()) {
            $this->getDb()->update('t_chapter', $chapterData, array('chap_id' => $chapter->getId()));
        } else {
            $this->getDb()->insert('t_chapter', $chapterData);
            
            $id = $this->getDb()->lastInsertId();
            $chapter->setId($id);
        }
    }
    
    public function delete($id) {
        $this->getDb()->delete('t_chapter', array('chap_id' => $id));
    }
}