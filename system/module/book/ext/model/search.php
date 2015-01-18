<?php
/**
 * Extend update function to build index.
 * 
 * @param  int    $bookID 
 * @access public
 * @return void
 */
public function update($bookID)
{
    $book   = $this->getNodeByID($bookID);
    $result = parent::update($bookID);
    if(!$result) return false;

    if(empty($book)) return false;
    return $this->loadModel('search')->save('book', $book);
}

/**
 * Extendsion for delete index.
 * 
 * @param  int    $bookID 
 * @param  null   $null 
 * @access public
 * @return void
 */
public function delete($bookID , $null = null)
{
    $result = parent::delete($bookID);   
    if(!$result) return false;

    return $this->loadModel('search')->deleteIndex('book', $bookID);
}
