<?php
/**
 * Extend post funtion to build index after post.
 * 
 * @param  int    $boardID 
 * @access public
 * @return void
 */
public function post($boardID)
{
    $threadID = parent::post($boardID);
    if(!$threadID) return false;

    $thread = $this->getByID($threadID);
    $this->loadModel('search')->save('thread', $thread);

    return $threadID;
}

/**
 * Extend update function to build index.
 * 
 * @param  int    $threadID 
 * @access public
 * @return void
 */
public function update($threadID)
{
    $result = parent::update($threadID);
    if(!$result) return false;

    $thread = $this->getByID($threadID);
    if(empty($thread)) return false;
    return $this->loadModel('search')->save('thread', $thread);
}

/**
 * Extendsion for delete index.
 * 
 * @param  int    $threadID 
 * @param  null   $null 
 * @access public
 * @return void
 */
public function delete($threadID , $null = null)
{
    $result = parent::delete($threadID);   
    if(!$result) return false;

    return $this->loadModel('search')->deleteIndex('thread', $threadID);
}
