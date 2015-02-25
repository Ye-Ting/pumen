<?php
/**
 * The model file of company of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv11.html)
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     company 
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
class companyModel extends model
{
    /**
     * get contact information.
     * 
     * @access public
     * @return string
     */
    public function getContact()
    {
        $contact = json_decode($this->config->company->contact);
        foreach($contact as $item => $value)
        {
            if($value)
            {
                if($item == 'qq') 
                {
                    $contact->qq = html::a("http://wpa.qq.com/msgrd?v=3&uin={$value}&site={$this->config->company->name}&menu=yes", $value, "target='_blank'");
                }
                else if($item == 'email')
                {
                    $contact->email = html::mailto($value, $value);
                }
                else if($item == 'weibo')
                {
                    $contact->weibo = html::a("http://weibo.com/{$value}", $value, "target='_blank'");
                }
                else if($item == 'site')
                {
                    if($_SERVER['HTTP_HOST'] != $value) $contact->site = html::a("http://{$value}", $value, "target='_blank'");
                    if($_SERVER['HTTP_HOST'] == $value) unset($contact->$item);
                }
                else if($item == 'wangwang')
                {
                    $contact->wangwang = html::a("http://www.taobao.com/webww/ww.php?ver=3&touid={$value}&siteid=cntaobao&status=2&charset=utf-8", $value, "target='_blank'");
                }
                else if($item == 'phone')
                {
                    $contact->phone = html::a("tel:$value", $value);
                }
            }
            else
            {
                unset($contact->$item);
            }
        }
        return $contact;
    }
}
