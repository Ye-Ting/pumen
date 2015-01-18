<?php
/**
 * The control file of search of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     http://api.chanzhi.org/goto.php?item=license
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     search
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
class search extends control
{
    /**
     * index 
     * 
     * @param  int    $words 
     * @param  int    $pageID 
     * @access public
     * @return void
     */
    public function index($words = '', $pageID = 1)
    {
        if(empty($words)) $words = $this->get->words;

        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal = 0, $this->config->search->recPerPage, $pageID);

        $this->session->set('serachIngWord', $words);

        $begin = time();
        $this->view->results = $this->search->getList($words, $pager);

        $this->view->consumed = time() - $begin;
        $this->view->title    = $this->lang->search->index; 
        $this->view->pager    = $pager;
        $this->view->words    = $words;

        $this->display();
    }

    /**
     * Build All index. 
     * 
     * @access public
     * @return void
     */
    public function buildIndex()
    {
        $this->search->buildAllIndex();
        $this->send(array('result' => 'success', 'message' => $this->lang->search->buildSuccessfully));
    }
}
