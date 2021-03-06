<?php
/**
 * The model file of upgrade module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv11.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     upgrade
 * @version     $Id: model.php 5019 2013-07-05 02:02:31Z wyd621@gmail.com $
 * @link        http://www.chanzhi.org
 */
?>
<?php
class upgradeModel extends model
{
    /**
     * Errors.
     * 
     * @static
     * @var array 
     * @access public
     */
    static $errors = array();

    /**
     * The execute method. According to the $fromVersion call related methods.
     * 
     * @param  string $fromVersion 
     * @access public
     * @return void
     */
    public function execute($fromVersion)
    {
        switch($fromVersion)
        {
            case '1_0': $this->execSQL($this->getUpgradeFile('1.0'));
            case '1_1': $this->execSQL($this->getUpgradeFile('1.1'));
            case '1_2': $this->execSQL($this->getUpgradeFile('1.2'));
            case '1_3': $this->execSQL($this->getUpgradeFile('1.3'));
            case '1_4': $this->execSQL($this->getUpgradeFile('1.4'));
            case '1_5': 
                $this->execSQL($this->getUpgradeFile('1.5'));
                $this->processTag();
            case '1_6':
                $this->execSQL($this->getUpgradeFile('1.6'));
                $this->setEnabledModules();
                $this->setFeaturedProducts();
            case '1_7':
                $this->execSQL($this->getUpgradeFile('1.7'));
                $this->moveBooks();
                $this->setMessageBlocks();
            case '1_8':
                $this->setPageBlocks();
                $this->setBlogBlocks();
            case '2_0':
                $this->execSQL($this->getUpgradeFile('2.0'));
                $this->processSiteDesc();
            case '2_0_1':
                $this->execSQL($this->getUpgradeFile('2.0.1'));
                $this->setImageSize();
                $this->upgradeHtmlBlocks();
                $this->upgradeLayouts();
            case '2_1': $this->execSQL($this->getUpgradeFile('2.1'));
            case '2_2': $this->execSQL($this->getUpgradeFile('2.2'));
            case '2_2_1':
                $this->execSQL($this->getUpgradeFile('2.2.1'));
                $this->upgradeSlide();
                $this->upgradeIndexKeyword();
                $this->upgradeHeaderLayouts();
            case '2_3':
                $this->execSQL($this->getUpgradeFile('2.3'));
                $this->upgradeRegions();
                $this->fixTopRegion();
                $this->fixSlideHeight();
                $this->setDefaultSiteType();
            case '2_4':
                $this->execSQL($this->getUpgradeFile('2.4'));
                $this->upgradeSlideTarget();
                $this->createIndexFile();
                $this->deleteLogFile();
                $this->setDefaultCurrency();
            case '2_5_beta':
                $this->execSQL($this->getUpgradeFile('2.5.beta'));
                $this->setCompanyBlocks();
            case '2_5_2':
                $this->execSQL($this->getUpgradeFile('2.5.2'));
            case '2_5_3':
                $this->execSQL($this->getUpgradeFile('2.5.3'));
                $this->fixCustomedCss();
            case '3_1':
                $this->fixBasicSite();
            case '3_3':
                $this->execSQL($this->getUpgradeFile('3.3'));

            default: if(!$this->isError()) $this->loadModel('setting')->updateVersion($this->config->version);
        }

        $this->createCustomerCss();
        $this->deletePatch();
    }

    /**
     * Create the confirm contents.
     * 
     * @param  string $fromVersion 
     * @access public
     * @return string
     */
    public function getConfirm($fromVersion)
    {
        $confirmContent = '';
        switch($fromVersion)
        {
            case '1_0'      : $confirmContent .= file_get_contents($this->getUpgradeFile('1.0'));
            case '1_1'      : $confirmContent .= file_get_contents($this->getUpgradeFile('1.1'));
            case '1_2'      : $confirmContent .= file_get_contents($this->getUpgradeFile('1.2'));
            case '1_3'      : $confirmContent .= file_get_contents($this->getUpgradeFile('1.3'));
            case '1_4'      : $confirmContent .= file_get_contents($this->getUpgradeFile('1.4'));
            case '1_5'      : $confirmContent .= file_get_contents($this->getUpgradeFile('1.5'));
            case '1_6'      : $confirmContent .= file_get_contents($this->getUpgradeFile('1.6'));
            case '1_7'      : $confirmContent .= file_get_contents($this->getUpgradeFile('1.7'));
            case '2_0'      : $confirmContent .= file_get_contents($this->getUpgradeFile('2.0'));
            case '2_0_1'    : $confirmContent .= file_get_contents($this->getUpgradeFile('2.0.1'));
            case '2_1'      : $confirmContent .= file_get_contents($this->getUpgradeFile('2.1'));
            case '2_2'      : $confirmContent .= file_get_contents($this->getUpgradeFile('2.2'));
            case '2_2_1'    : $confirmContent .= file_get_contents($this->getUpgradeFile('2.2.1'));
            case '2_3'      : $confirmContent .= file_get_contents($this->getUpgradeFile('2.3'));
            case '2_4'      : $confirmContent .= file_get_contents($this->getUpgradeFile('2.4'));
            case '2_5_beta' : $confirmContent .= file_get_contents($this->getUpgradeFile('2.5.beta'));
            case '2_5_2'    : $confirmContent .= file_get_contents($this->getUpgradeFile('2.5.2'));
            case '2_5_3'    : $confirmContent .= file_get_contents($this->getUpgradeFile('2.5.3'));
            case '3_3'      : $confirmContent .= file_get_contents($this->getUpgradeFile('3.3'));
        }
        return str_replace(array('xr_', 'eps_'), $this->config->db->prefix, $confirmContent);
    }

    /**
     * Delete the patch record.
     * 
     * @access public
     * @return void
     */
    public function deletePatch()
    {
        return true;
        $this->dao->delete()->from(TABLE_EXTENSION)->where('type')->eq('patch')->exec();
    }

    /**
     * Unify keywords of article, product and category, count tag's rank and save.
     *
     * @access public
     * @return void
     */
    public function processTag()
    {
        $tags = '';

        $articles = $this->dao->select('id, keywords')->from(TABLE_ARTICLE)->fetchPairs('id', 'keywords');  
        foreach($articles as $id => $keywords)
        {
            $keywords = seo::unify($keywords, ',');
            $this->dao->update(TABLE_ARTICLE)->set('keywords')->eq($keywords)->where('id')->eq($id)->exec();
            $tags = $keywords;
        }

        $products = $this->dao->select('id, keywords')->from(TABLE_PRODUCT)->fetchPairs('id', 'keywords');  
        foreach($products as $id => $keywords)
        {
            $keywords = seo::unify($keywords, ',');
            $this->dao->update(TABLE_PRODUCT)->set('keywords')->eq($keywords)->where('id')->eq($id)->exec();
            $tags .= ',' . $keywords;
        }

        $categories = $this->dao->select('id, keywords')->from(TABLE_CATEGORY)->fetchPairs('id', 'keywords');  
        foreach($categories as $id => $keywords)
        {
            $keywords = seo::unify($keywords, ',');
            $this->dao->update(TABLE_CATEGORY)->set('keywords')->eq($keywords)->where('id')->eq($id)->exec();
            $tags .= ',' . $keywords;
        }

        $this->loadModel('tag')->save($tags);
    }

    /**
     * Set enabled modules when upgrade V1.6
     * 
     * @access public
     * @return void
     */
    public function setEnabledModules()
    {
       $modules = array(); 
       $blog  = $this->dao->select("count(*) as count")->from(TABLE_CATEGORY)->where('type')->eq('blog')->fetch('count');
       if($blog)  $modules[] = 'blog';

       $forum = $this->dao->select("count(*) as count")->from(TABLE_CATEGORY)->where('type')->eq('forum')->fetch('count');
       if($forum) 
       {
           $modules[] = 'forum';
           $modules[] = 'user';
       }

       $books = $this->loadModel('book')->getBookList();
       if(!empty($books))  $modules[] = 'book';

       $setting = new stdclass();
       $setting->moduleEnabled = join($modules, ',');
       return $this->loadModel('setting')->setItems('system.common.site', $setting);
    }

    /**
     * Set featured products when upgrade v1.6
     * 
     * @access public
     * @return void
     */
    public function setFeaturedProducts()
    {
        $this->loadModel('block');
        $homeBlocks = $this->block->getRegionBlocks('index_index', 'bottom');
        if(count($homeBlocks) > 3)  return false;
        $products = $this->dao->select("id,name")->from(TABLE_PRODUCT)->orderBy('id_desc')->limit(3)->fetchPairs('id', 'name');

        $blocks = $this->dao->select('blocks')->from(TABLE_LAYOUT)
            ->where('page')->eq('index_index')
            ->andWhere('region')->eq('bottom')
            ->fetch('blocks');
        $blocks = trim($blocks, ',');

        foreach($products as $id => $name)
        {
            $block = new stdclass();
            $block->type       = 'featuredProduct';
            $block->title      = $name;
            $params['product'] = $id;
            $block->content    = json_encode($params);
            $this->dao->insert(TABLE_BLOCK)->data($block)->exec();

            if(!dao::isError()) $blocks = $this->dao->lastInsertID() . ',' . $blocks;
        }

        $this->dao->update(TABLE_LAYOUT)->set('blocks')->eq($blocks)
            ->where('page')->eq('index_index')
            ->andWhere('region')->eq('bottom')
            ->exec();

        return true;
    }

    /**
     * Move books data.
     * 
     * @access public
     * @return void
     */
    public function moveBooks()
    {
        $books = $this->dao->select('*')->from(TABLE_CONFIG)
            ->where('owner')->eq('system')
            ->andWhere('module')->eq('common')
            ->andWhere('section')->eq('book')
            ->fetchAll('key');

        foreach($books as $code => $book)
        {
            $book = json_decode($book->value);
            $this->dao->insert(TABLE_BOOK)
                ->set('alias')->eq($code)
                ->set('title')->eq($book->name)
                ->set('grade')->eq(1)
                ->set('summary')->eq($book->summary)
                ->exec();
            
            $bookID     = $this->dao->lastInsertID();
            $catalogues = $this->dao->select('*')->from(TABLE_CATEGORY)->where('type')->eq('book_' . $code)->fetchAll('id');
            $chapters   = array();

            foreach($catalogues as $catalogue)
            {
                $chapter = new stdclass();
                $chapter->id         = $catalogue->id;
                $chapter->title      = $catalogue->name;
                $chapter->alias      = $catalogue->alias;
                $chapter->keywords   = $catalogue->keywords;
                $chapter->summary    = $catalogue->desc;
                $chapter->type       = 'chapter';
                $chapter->parent     = $catalogue->parent == 0 ? $bookID : $catalogue->parent;
                $chapter->grade      = $catalogue->grade + 1;
                $chapter->addedDate  = $catalogue->postedDate;
                $chapter->editedDate = $catalogue->postedDate;
                $chapter->order      = $catalogue->order;

                $paths = explode(',', $catalogue->path);
                foreach($paths as $key => $value) 
                {
                    if(empty($value)) unset($paths[$key]);
                }
                $chapter->path = ",{$bookID}," . join($paths, ',') . ',';

                $this->dao->insert(TABLE_BOOK)->data($chapter)->exec();
                $chapter->id = $this->dao->lastInsertID();

                $chapters[$catalogue->id] = $chapter;
            }

            $articles = $this->dao->select('*')->from(TABLE_ARTICLE)
                ->where('type')->eq('book_' . $code)
                ->fetchAll('id');

            foreach($articles as $origin)
            {
                $article = new stdclass();
                $article->title      = $origin->title;
                $article->alias      = $origin->alias;
                $article->author     = $origin->author;
                $article->keywords   = $origin->keywords;
                $article->summary    = $origin->summary;
                $article->content    = $origin->content;
                $article->type       = 'article';
                $article->parent     = $origin->parent == 0 ? $book->id : $origin->parent;
                $article->addedDate  = $origin->addedDate;
                $article->editedDate = $origin->editedDate;
                $article->order      = $origin->order;
                $article->views      = $origin->views;
                
                $category = $this->dao->select('*')->from(TABLE_RELATION)->where('type')->eq("book_{$code}")->andWhere('id')->eq($origin->id)->fetch('category');

                $article->parent = $chapters[$category]->id;
                $article->grade  = $chapters[$category]->grade + 1;
                $path = $chapters[$category]->path;
                $paths = explode(',', $path);
                foreach($paths as $key => $value)
                {
                    if(empty($value)) unset($paths[$key]);
                }

                $article->path   = ',' . join($paths, ',') . ',';

                $this->dao->insert(TABLE_BOOK)->data($article)->exec();
                $articleID = $this->dao->lastInsertID();
                $this->dao->update(TABLE_FILE)
                    ->set('objectType')->eq('book')
                    ->set('objectID')->eq($articleID)
                    ->where('objectType')->like('book_%')
                    ->andWhere('objectID')->eq($origin->id)
                    ->exec();
            }
        }

        $this->dao->update(TABLE_BOOK)->set("path=concat(',', id, ',')")->where('type')->eq('book')->exec();
        $this->dao->update(TABLE_BOOK)->set("path=concat(path, id, ',')")->where('type')->eq('article')->exec();

        $this->dao->delete()->from(TABLE_CONFIG)->where('owner')->eq('system')->andWhere('module')->eq('common')->andWhere('section')->eq('book')->exec();
        $this->dao->delete()->from(TABLE_ARTICLE)->where('type')->like('book_%')->exec();
        $this->dao->delete()->from(TABLE_CATEGORY)->where('type')->like('book_%')->exec();

        return true;
    }

    /**
     * Set image size.
     * 
     * @access public
     * @return bool
     */
    public function setImageSize()
    {
        $this->loadModel('file');

        $files = $this->dao->select('*')->from(TABLE_FILE)->fetchAll();

        foreach($files as $file)
        {
            if(in_array($file->extension, $this->config->file->imageExtensions))
            {
                $imageSize    = $this->file->getImageSize($this->file->savePath . $file->pathname);
                $file->width  = $imageSize['width'];
                $file->height = $imageSize['height'];

                $this->dao->update(TABLE_FILE)->data($file)->where('id')->eq($file->id)->exec();
            }
        }

        return true;
    }

    /**
     * Get the upgrade sql file.
     * 
     * @param  string $version 
     * @access public
     * @return string
     */
    public function getUpgradeFile($version)
    {
        return $this->app->getAppRoot() . 'db' . DS . 'upgrade' . $version . '.sql';
    }

    /**
     * Execute a sql.
     * 
     * @param  string  $sqlFile 
     * @access public
     * @return void
     */
    public function execSQL($sqlFile)
    {
        $mysqlVersion = $this->loadModel('install')->getMysqlVersion();

        /* Read the sql file to lines, remove the comment lines, then join theme by ';'. */
        $sqls = explode("\n", file_get_contents($sqlFile));
        foreach($sqls as $key => $line) 
        {
            $line       = trim($line);
            $sqls[$key] = $line;
            if(strpos($line, '--') !== false or empty($line)) unset($sqls[$key]);
        }
        $sqls = explode(';', join("\n", $sqls));

        foreach($sqls as $sql)
        {
            $sql = trim($sql);
            if(empty($sql)) continue;

            if($mysqlVersion <= 4.1)
            {
                $sql = str_replace('DEFAULT CHARSET=utf8', '', $sql);
                $sql = str_replace('CHARACTER SET utf8 COLLATE utf8_general_ci', '', $sql);
            }

            $sql = str_replace(array('eps_', 'xr_'), $this->config->db->prefix, $sql);
            try
            {
                $this->dbh->exec($sql);
            }
            catch (PDOException $e) 
            {
                self::$errors[] = $e->getMessage() . "<p>The sql is: $sql</p>";
            }
        }
    }
       
    /**
     * Set blocks of message page.
     * 
     * @access public
     * @return bool
     */
    public function setMessageBlocks()
    {
        $id = $this->dao->select('id')->from(TABLE_BLOCK)->where('type')->eq('contact')->fetch('id');
        $this->dao->insert(TABLE_LAYOUT)->set('page')->eq('message_index')->set('region')->eq('side')->set('blocks')->eq($id)->exec();
        return !dao::isError();
    }

    /**
     * Set blog blocks.
     * 
     * @access public
     * @return void
     */
    public function setBlogBlocks()
    {
        $blocks = array();
        $blocks['en']    = array('type' => 'blogTree', 'title' => 'Blog Category', 'content' => '{"showChildren":"1"}');
        $blocks['zh-cn'] = array('type' => 'blogTree', 'title' => '博客分类',      'content' => '{"showChildren":"1"}');
        $blocks['zh-tw'] = array('type' => 'blogTree', 'title' => '博客分類',      'content' => '{"showChildren":"1"}');
        $block = $blocks[$this->config->site->lang];
        $this->dao->insert(TABLE_BLOCK)->data($block)->exec();
        $blockID = $this->dao->lastInsertID();

        $this->dao->insert(TABLE_LAYOUT)->set('page')->eq('blog_index')->set('region')->eq('side')->set('blocks')->eq($blockID . ',')->exec();
        $this->dao->insert(TABLE_LAYOUT)->set('page')->eq('blog_view')->set('region')->eq('side')->set('blocks')->eq($blockID . ',')->exec();
        return !dao::isError();
    }   

    /**
     * Set page blocks.
     * 
     * @access public
     * @return void
     */
    public function setPageBlocks()
    {
        $this->dao->insert(TABLE_LAYOUT)->set('page')->eq('page_index')->set('region')->eq('side')->set('blocks')->eq('2,9,')->exec();
        $this->dao->insert(TABLE_LAYOUT)->set('page')->eq('page_view')->set('region')->eq('side')->set('blocks')->eq('2,9,')->exec();
        return !dao::isError();
    }   

    /**
     * Set company blocks when upgrade from 2.5.beta.
     * 
     * @access public
     * @return void
     */
    public function setCompanyBlocks()
    {
        $this->app->loadLang('block');

        $wechatBlock = array('type' => 'followUs', 'title' => $this->lang->block->default->typeList['followUs'], 'content' => '', 'template' => 'default');

        $this->dao->insert(TABLE_BLOCK)->data($wechatBlock)->exec();

        $wechatBlockID = $this->dao->lastInsertID();

        $contactBlocks = $this->dao->select('*')->from(TABLE_BLOCK)->where('type')->eq('contact')->fetchAll('template');

        if(!$contactBlocks)
        {
            $contactBlock = array('type' => 'contact', 'title' => $this->lang->block->default->typeList['contact'], 'content' => '', 'template' => 'default');
            $this->dao->insert(TABLE_BLOCK)->data($contactBlock)->exec();
            $contactBlockID = $this->dao->lastInsertID();

            $companyBlocks = array();
            $contactBlock  = array();
            $wechatBlock   = array();

            $contactBlock['id'] = $contactBlockID;
            $wechatBlock['id']  = $wechatBlockID;
            $companyBlocks[]    = $contactBlock;
            $companyBlocks[]    = $wechatBlock;

            $this->dao->insert(TABLE_LAYOUT)
                ->set('page')->eq('company_index')
                ->set('region')->eq('side')
                ->set('blocks')->eq(json_encode($companyBlocks))
                ->set('template')->eq('default')
                ->exec();

            return !dao::isError();
        }

        foreach($contactBlocks as $template => $block)
        {
            $companyBlocks = array();
            $contactBlock  = array();
            $wechatBlock   = array();

            $contactBlock['id'] = $block->id;
            $wechatBlock['id']  = $wechatBlockID;
            $companyBlocks[]    = $contactBlock;
            $companyBlocks[]    = $wechatBlock;

            $this->dao->insert(TABLE_LAYOUT)
                ->set('page')->eq('company_index')
                ->set('region')->eq('side')
                ->set('blocks')->eq(json_encode($companyBlocks))
                ->set('template')->eq($template)
                ->exec();
        }

        return !dao::isError();
    }   

    /**
     * Process site desc data.
     * 
     * @access public
     * @return void
     */
    public function processSiteDesc()
    {
        $value = strip_tags(htmlspecialchars_decode($this->config->site->desc));
        $this->dao->update(TABLE_CONFIG)->set('value')->eq($value)->where('`key`')->eq('desc')->andWhere('section')->eq('site')->exec();
        return !dao::isError();
    }   

    /**
     * Upgrade layouts when upgrade when 2.0.1.
     * 
     * @access public
     * @return void
     */
    public function upgradeLayouts()
    {
        $this->dao->update(TABLE_LAYOUT)->set('region')->eq('middle')->where('region')->eq('bottom')->exec();
        $layoutlist = $this->dao->select('*')->from(TABLE_LAYOUT)->fetchAll();

        foreach($layoutlist as $layout)
        {
            $blockIdList = explode(',', $layout->blocks);
            $blocks = array();
            foreach($blockIdList as $blockID)
            {
                if(!$blockID) continue;

                $block = array();
                $block['id']         = $blockID;
                $block['grid']       = '';
                $block['titleless']  = 0;
                $block['borderless'] = 0;

                if($layout->page == 'index_index' and $layout->region == 'middle') $block['grid']  = 4;
                $blocks[] = $block;
            }

            $this->dao->update(TABLE_LAYOUT)
                ->set('blocks')->eq(json_encode($blocks))
                ->where('page')->eq($layout->page)
                ->andWhere('region')->eq($layout->region)
                ->exec();
        }

        return !dao::isError();
    }

    /**
     * Upgrade slide when upgrade when 2.2.1.
     * 
     * @access public
     * @return void
     */
    public function upgradeSlide()
    {
        $slides = $this->dao->select('*')->from(TABLE_CONFIG)
            ->where('owner')->eq('system')
            ->andWhere('module')->eq('common')
            ->andWhere('section')->eq('slides')
            ->fetchAll('key');

        foreach($slides as $key => $slide)
        {
            $slides[$key] = json_decode($slide->value);
            $slides[$key]->titleColor      = '#FFF';
            $slides[$key]->mainLink        = $slides[$key]->label ? '' : $slides[$key]->url;
            $slides[$key]->backgroundType  = 'image';
            $slides[$key]->backgroundColor = '#114DAD';
            $slides[$key]->height          = '';
            $slides[$key]->label           = array($slides[$key]->label);
            $slides[$key]->buttonClass     = array('0' => 'primary');
            $slides[$key]->buttonUrl       = isset($slides[$key]->url) ? array($slides[$key]->url) : '';

            unset($slides[$key]->url);

            $this->dao->update(TABLE_CONFIG)
                ->set('value')->eq(helper::jsonEncode($slides[$key]))
                ->where('`key`')->eq($key)
                ->exec();
        }

        return !dao::isError();
    } 

    /**
     * Upgrade header layout of all page when upgrade from 2.2.1 .
     * 
     * @access public
     * @return bool 
     */
    public function upgradeHeaderLayouts()
    {
        $this->dao->update(TABLE_LAYOUT)->set('region')->eq('start')->where('page')->eq('all')->andWhere('region')->eq('header')->exec();

        $this->app->loadLang('block');
        $block = array('type' => 'header', 'title' => $this->lang->block->typeList['header'], 'content' => '');
        $this->dao->insert(TABLE_BLOCK)->data($block)->exec();
        $blockID = $this->dao->lastInsertID();

        $headerBlock = array();
        $headerBlock['id']         = $blockID;
        $headerBlock['grid']       = '';
        $headerBlock['titleless']  = 0;
        $headerBlock['borderless'] = 0;
        $headerBlocks[] = $headerBlock;

        $this->dao->insert(TABLE_LAYOUT)->set('page')->eq('all')->set('region')->eq('header')->set('blocks')->eq(json_encode($headerBlocks))->exec();

        return !dao::isError();
    }

    /**
     * Fix top region (which is empty)
     * 
     * @access public
     * @return void
     */
    public function fixTopRegion()
    {
        $topRegion = $this->dao->select('*')->from(TABLE_LAYOUT)->where('page')->eq('all')->andWhere('region')->eq('top')->fetch();

        if(empty($topRegion))
        {
            $this->app->loadLang('block');
            $block = array('type' => 'header', 'title' => $this->lang->block->typeList['header'], 'content' => '');
            $this->dao->insert(TABLE_BLOCK)->data($block)->exec();
            if(dao::isError()) return false;
            $blockID = $this->dao->lastInsertID();

            $topBlock = array();
            $topBlock['id']         = $blockID;
            $topBlock['grid']       = '';
            $topBlock['titleless']  = 0;
            $topBlock['borderless'] = 0;
            $topBlocks[] = $topBlock;

            $this->dao->insert(TABLE_LAYOUT)
                ->set('page')->eq('all')
                ->set('region')->eq('top')
                ->set('blocks')->eq(json_encode($topBlocks))
                ->exec();
            return dao::isError();
        }

        return true;
    }    

    /**
     * Upgrade html blocks when upgrade from 2.0.1 .
     * 
     * @access public
     * @return void
     */
    public function upgradeHtmlBlocks()
    {
        $blocks = $this->dao->select('*')->from(TABLE_BLOCK)->where('type')->eq('html')->fetchAll();

        foreach($blocks as $block)
        {
            $block->content = json_encode(array('content' => $block->content, 'icon' => ''));
            $this->dao->update(TABLE_BLOCK)->data($block)->where('id')->eq($block->id)->exec();
        }

        return !dao::isError();
    }

    /**
     * Upgrade indexKeyword from 2.2.1 
     * 
     * @access public
     * @return void
     */
    public function upgradeIndexKeyword()
    {
        $setting = array('indexKeywords' => $this->config->site->keywords);
        return $this->loadModel('setting')->setItems('system.common.site', $setting);
    }

    /**
     * Upgrade regions from 2.3. 
     * 
     * @access public
     * @return void
     */
    public function upgradeRegions()
    {
        $layout = new stdclass();
        $layout->page   = 'all';
        $layout->region = 'bottom';
        $blocks = array();

        $bottomRegions = $this->dao->select('*')->from(TABLE_LAYOUT)->where('page')->eq('all')->andWhere('region')->in('footer, end')->fetchAll();
        foreach($bottomRegions as $region)
        {
            $blocks = array_merge($blocks, json_decode($region->blocks, true));
        }
        $layout->blocks = helper::jsonEncode($blocks);

        $this->dao->replace(TABLE_LAYOUT)->data($layout)->exec();
        $this->dao->delete()->from(TABLE_LAYOUT)->where('page')->eq('all')->andWhere('region')->in('footer, end')->exec();

        $this->dao->update(TABLE_LAYOUT)->set('region')->eq('top')->where('region')->eq('header')->exec();
        $this->dao->update(TABLE_LAYOUT)->set('region')->eq('bottom')->where('region')->eq('footer')->exec();
        $this->dao->update(TABLE_LAYOUT)->set('region')->eq('header')->where('region')->eq('start')->exec();

        return !dao::isError();
    }

    /**
     * Fix slide height.
     * 
     * @access public
     * @return void
     */
    public function fixSlideHeight()
    {
        $slides = $this->dao->select('*')->from(TABLE_CONFIG)
            ->where('owner')->eq('system')
            ->andWhere('module')->eq('common')
            ->andWhere('section')->eq('slides')
            ->fetchAll('id');

        foreach($slides as $id => $slide)
        {
            $value = json_decode($slide->value);

            if($value->backgroundType == 'image') continue;
            if(isset($value->height) and $value->height) continue;

            $value->height = 100;
            $this->dao->update(TABLE_CONFIG)->set('`value`')->eq(json_encode($value))->where('id')->eq($id)->exec();
        }
        return !dao::isError();
    }

    /**
     * Set default site type.
     * 
     * @access public
     * @return void
     */
    public function setDefaultSiteType()
    {
        if(isset($this->config->site->type) and $this->config->site->type == 'blog') return true;
        return $this->loadModel('setting')->setItems('system.common.site', array('type' => 'portal'));
    }

    /**
     * Upgrade slide when upgrade when 2.4.
     * 
     * @access public
     * @return void
     */
    public function upgradeSlideTarget()
    {
        $slides = $this->dao->select('*')->from(TABLE_CONFIG)
            ->where('owner')->eq('system')
            ->andWhere('module')->eq('common')
            ->andWhere('section')->eq('slides')
            ->fetchAll('key');

        foreach($slides as $key => $slide)
        {
            $slides[$key] = json_decode($slide->value);
            $slides[$key]->target = '_self';

            $slides[$key]->buttonTarget = array();
            foreach($slides[$key]->buttonUrl as $button => $url)
            {
                $slides[$key]->buttonTarget[$button] = '_self';
            }

            $this->dao->update(TABLE_CONFIG)
                ->set('value')->eq(helper::jsonEncode($slides[$key]))
                ->where('`key`')->eq($key)
                ->exec();
        }

        return !dao::isError();
    }

    /**
     * Scan directory and create empty index file when upgrade from 2.4
     * 
     * @param  string    $path 
     * @access public
     * @return void
     */
    public function createIndexFile($path = null)
    {
        if(empty($path)) $path = $this->app->getDataRoot() . 'upload';

        $scanDir   = dir($path);
        $indexFile = $path . DS . "index.php";
        if(is_writable($path) && !file_exists($indexFile))
        {
            $fd = @fopen($indexFile, "a+");
            @fclose($fd);
            chmod($indexFile, 0755);
        }
        
        while($file = $scanDir->read())
        {
            $nextDir = $path . DS . $file;
            if((is_dir($nextDir)) AND ($file != ".") AND ($file != ".."))
            {
                $this->createIndexFile($nextDir);
            }
        }
    }

    /**
     * Delete log file when upgrade from 2.4 
     * delete all file in logRoot directory but index.php .
     * if delete fail set system.common.upgrade deleteLogFile=0  
     *
     * @access public
     * @return void
     */
    public function deleteLogFile()
    {
        $logRoot = $this->app->getLogRoot();
        if(!is_writable($logRoot))
        {
            return $this->loadModel('setting')->setItems('system.common.upgrade', array('deleteLogFile' => '0'));
        }
        else
        {
            $scanDir = dir($logRoot);
            while($file = $scanDir->read())
            {
                if(is_file($logRoot . $file) && $file != 'index.php' && $file != '.gitkeep')
                {
                    unlink($logRoot . $file);
                }
            }
        }
    }

    /**
     * Set default currency.
     * 
     * @access public
     * @return void
     */
    public function setDefaultCurrency()
    {
        if($this->config->site->lang != 'en') return $this->loadModel('setting')->setItems('system.common.product', array('currency' => '￥'));
        if($this->config->site->lang == 'en') return $this->loadModel('setting')->setItems('system.common.product', array('currency' => '$'));
    }

    /**
     * Fix customed css.
     * 
     * @access public
     * @return void
     */
    public function fixCustomedCss()
    {
        $customedFile = $this->app->getDataRoot() . 'theme/custom.css';
        if(is_file($customedFile))
        {
            $customPath = $this->app->getDataRoot() . 'css' . DS . 'default' . DS . 'colorful' . DS;
            mkdir($customPath, 0777, true);

            rename($customedFile, $customPath . 'style.css');
        }

        if(isset($this->config->site->themeSetting))
        {
            $customed = json_decode($this->config->site->themeSetting, true);
            $setting['default']['colorful']['font-size']        = $customed['fontSize'];
            $setting['default']['colorful']['border-radius']    = $customed['borderRadius'];
            $setting['default']['colorful']['color-primary']    = $customed['primaryColor'];
            $setting['default']['colorful']['background-color'] = $customed['backColor'];

            return  $this->loadModel('setting')->setItems('system.common.template', array('custom' => helper::jsonEncode($setting)) );
        }

        return true;
    }

    /**
     * Fix BasicSite for icpSN and modules.
     * 
     * @access public
     * @return bool
     */
    public function fixBasicSite()
    {
        $this->dao->update(TABLE_CONFIG)->set('`key`')->eq('icpSN')->where('`key`')->eq('icp')->andWhere('section')->eq('site')->exec();
        $this->dao->update(TABLE_CONFIG)->set('`key`')->eq('modules')->where('`key`')->eq('moduleEnabled')->andWhere('section')->eq('site')->exec();

        return !dao::isError();
    }

    /**
     * Judge any error occers.
     * 
     * @access public
     * @return bool
     */
    public function isError()
    {
        return !empty(self::$errors);
    }

    /**
     * Get errors during the upgrading.
     * 
     * @access public
     * @return array
     */
    public function getError()
    {
        $errors = self::$errors;
        self::$errors = array();
        return $errors;
    }

    /**
     * Create customer css files.
     * 
     * @access public
     * @return void
     */
    public function createCustomerCss()
    {
        $lessc = $this->app->loadClass('lessc');
        $settings = isset($this->config->template->custom) ? json_decode($this->config->template->custom, true) : array();
        foreach($settings as $template => $themes)
        {
            foreach($themes as $theme => $params)
            {
                $this->loadModel('ui')->createCustomerCss($template, $theme, $params);
            }
        }
        return true;
    }
}
