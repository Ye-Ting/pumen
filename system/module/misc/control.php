<?php
/**
 * The control file of misc of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv11.html)
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     misc
 * @version     $Id$
 * @link        http://www.zentao.net
 */
class misc extends control
{
    public function ping()
    {
        die();
    }

    /** 
     * Create qrcode for mobile visit.
     * 
     * @access public
     * @return void
     */
    public function qrcode()
    {   
        if(!extension_loaded('gd'))
        {   
            $this->view->noGDLib = sprintf($this->lang->misc->noGDLib, $loginAPI);
            $this->display();
        }   

        $this->app->loadClass('qrcode');
        QRcode::png($this->server->http_referer, false, 4, 6); 
    }   
}
