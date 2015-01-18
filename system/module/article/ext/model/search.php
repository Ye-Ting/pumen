<?php
/**
 * Extend create funtion to build index after create.
 * 
 * @param  string    $type 
 * @access public
 * @return void
 */
public function create($type)
{
    $articleID = parent::create($type);
    if(!$articleID) return false;

    $article = $this->getByID($articleID);
    $this->loadModel('search')->save('article', $article);

    return $articleID;
}

/**
 * Extend update function to build index.
 * 
 * @param  int    $articleID 
 * @access public
 * @return void
 */
public function update($articleID, $type = 'article')
{

    $result = parent::update($articleID, $type);
    if(!$result) return false;

    $article = $this->getByID($articleID);

    if(empty($article)) return false;
    return $this->loadModel('search')->save('article', $article);
}

/**
 * Extendsion for delete index.
 * 
 * @param  int    $articleID 
 * @param  null   $null 
 * @access public
 * @return void
 */
public function delete($articleID , $null = null)
{
    $article = $this->getByID($articleID);

    $result = parent::delete($articleID);   
    if(!$result) return false;

    return $this->loadModel('search')->deleteIndex($article->type, $articleID);
}
