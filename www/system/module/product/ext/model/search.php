<?php
/**
 * Extend create funtion to build index after create.
 * 
 * @access public
 * @return void
 */
public function create()
{
    $productID = parent::create();
    if(!$productID) return false;

    $product = $this->getByID($productID);
    $this->loadModel('search')->save('product', $product);

    return $productID;
}

/**
 * Extend update function to build index.
 * 
 * @param  int    $productID 
 * @access public
 * @return void
 */
public function update($productID)
{
    $result = parent::update($productID);
    if(!$result) return false;

    $product = $this->getByID($productID);
    if(empty($product)) return false;
    return $this->loadModel('search')->save('product', $product);
}

/**
 * Extendsion for delete index.
 * 
 * @param  int    $productID 
 * @param  null   $null 
 * @access public
 * @return void
 */
public function delete($productID , $null = null)
{
    $result = parent::delete($productID);   
    if(!$result) return false;

    return $this->loadModel('search')->deleteIndex('product', $productID);
}
