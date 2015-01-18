<?php
/**
 * The model file of search module of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     http://api.chanzhi.org/goto.php?item=license
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     search
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
class searchModel extends model
{
    /**
     * get search results of keywords.
     * 
     * @param  string    $keywords 
     * @param  object    $pager 
     * @access public
     * @return array
     */
    public function getList($keywords, $pager)
    {
        $splitedWords = $this->app->loadClass('spliter')->utf8Split($keywords);
        $words        = $splitedWords['words'];

        $results = $this->dao->select("*, MATCH(title, content) AGAINST('+{$words}' IN BOOLEAN MODE) as score")
            ->from(TABLE_SEARCH_INDEX)
            ->where("MATCH(title,content) AGAINST('+{$words}' IN BOOLEAN MODE)")
            ->andWhere('status')->eq('normal')
            ->andWhere('addedDate')->le(helper::now())
            ->orderBy('score_desc, editedDate_desc')
            ->page($pager)
            ->fetchAll('id');

        foreach($results as $record)
        {
            $record->title   = $this->decode($this->markKeywords($record->title, $words));
            $record->summary = $this->getSummary($record->content, $words);
        }

        return $this->processLinks($results);
    }

    /**
     * Save an index item.
     * 
     * @param  string    $objectType article|blog|page|product|thread|reply|
     * @param  int       $objectID 
     * @access public
     * @return void
     */
    public function save($objectType, $object)
    {
        $fields = $this->config->search->fields->{$objectType};

        $index = new stdclass();
        $index->objectID   = $object->{$fields->id};
        $index->objectType = $objectType;
        $index->title      = $object->{$fields->title};
        $index->status     = !empty($object->{$fields->status}) ? $object->{$fields->status} : 'normal' ;
        $index->addedDate  = isset($object->{$fields->addedDate}) ? $object->{$fields->addedDate} : '0000-00-00 00:00:00';
        $index->editedDate = isset($object->{$fields->editedDate}) ? $object->{$fields->editedDate} : '0000-00-00 00:00:00';

        $paramFields = explode(',', $fields->params);
        foreach($paramFields as $field)
        {
            $params[$field] = isset($object->$field) ? $object->$field : ''; 
        }

        $index->params = json_encode($params);

        $index->content = '';
        $contentFields  = explode(',', $fields->content);
        foreach($contentFields as $field) $index->content .= $object->$field;

        $spliter = $this->app->loadClass('spliter');

        $titleSplited   = $spliter->utf8Split($index->title);
        $index->title   = $titleSplited['words'];
        $contentSplited = $spliter->utf8Split(strip_tags($index->content));
        $index->content = $contentSplited['words'];

        $this->saveDict($titleSplited['dict'] + $contentSplited['dict']);
        $this->dao->replace(TABLE_SEARCH_INDEX)->data($index)->exec();
        return true;
    }

    /**
     * Save dict info. 
     * 
     * @param  array    $words 
     * @access public
     * @return void
     */
    public function saveDict($dict)
    {
        foreach($dict as $key => $value)
        {
            if(!is_numeric($key) or empty($value)) continue;
            $this->dao->replace(TABLE_SEARCH_DICT)->data(array('key' => $key, 'value' => $value))->exec();
        }
    }

    /**
     * Transfer unicode to words.
     * 
     * @param  string    $string 
     * @access public
     * @return void
     */
    public function decode($string)
    {
        $dict   = $this->dao->select("concat(`key`, ' ') as `key`, value")->from(TABLE_SEARCH_DICT)->fetchPairs();
        $dict['|'] = '';
        return str_replace(array_keys($dict), array_values($dict), $string . ' ');
        
    }

    /**
     * Get summary of results.
     * 
     * @param  string    $content 
     * @param  string    $words 
     * @access public
     * @return string
     */
    public function getSummary($content, $words)
    {
        $length = $this->config->search->summaryLength;
        if(strlen($content) <= $length)
        { 
            $summary = $content;
        }
        else
        {
            preg_match_all("/\d+/", $words, $unicodes);
            if(!empty($unicodes[0])) $words = join(' ', $unicodes[0]);

            $pattern = ltrim(str_replace(' ', '|', $words), '|');
            preg_match_all("/{$pattern}/", $content, $matched);

            if(empty($matched[0])) 
            {
                $summary = substr($content, 0, $length);
            }
            else
            {
                $content = explode(' ', $content);
                $pos   = array_search($matched[0][0], $content);
                $start = max(0, $pos - ($length / 2));
                $summary = join(' ', array_slice($content, $start, $length));
            }
        }

        $summary = $this->markKeywords($summary, $words);
        $summary = $this->decode($summary);

        return $summary;
    }

    /**
     * Process links of search results.
     * 
     * @param  array    $results 
     * @access public
     * @return array
     */
    public function processLinks($results)
    {
        foreach($results as $record)
        {
            $record->params = json_decode($record->params);
            if($record->objectType == 'article') $record->url = helper::createLink('article', 'view',  "id={$record->objectID}", "category={$record->params->category}&name={$record->params->alias}");
            if($record->objectType == 'product') $record->url = helper::createLink('product', 'view',  "id={$record->objectID}", "category={$record->params->category}&name={$record->params->alias}");
            if($record->objectType == 'thread')  $record->url = helper::createLink('thread', 'view', "id={$record->objectID}");;
            if($record->objectType == 'blog')    $record->url = helper::createLink('blog', 'view',  "id={$record->objectID}", "category={$record->params->category}&name={$record->params->alias}");
            if($record->objectType == 'page')    $record->url = helper::createLink('page', 'view',  "id={$record->objectID}", "name={$record->params->alias}");
            if($record->objectType == 'book')    $record->url = helper::createLink('book', 'read', "id={$record->objectID}", "book={$record->params->book}&node={$record->params->alias}");
        }

        return $results;
    }

    /**
     * Mark keywords in content.
     * 
     * @param  string    $content 
     * @param  string    $keywords 
     * @access public
     * @return void
     */
    public function markKeywords($content, $keywords)
    {
        $words = explode(' ', trim($keywords, ' '));
        $markedWords = array();

        foreach($words as $key => $word)
        {
            $words[$key] = $word . ' ';
            $markedWords[] = "<strong class='text-danger'>" . $this->decode($word) . "</strong>";
        }

        return str_replace($words, $markedWords, $content . ' ');
    }

    /**
     * Build all search index.
     * 
     * @access public
     * @return bool
     */
    public function buildAllIndex()
    {
        $categories = $this->dao->select('id,alias')->from(TABLE_CATEGORY)->fetchPairs();
        $articles   = $this->dao->select('t1.*, t2.category as category')->from(TABLE_ARTICLE)->alias('t1')->leftJoin(TABLE_RELATION)->alias('t2')->on("t1.id=t2.id")->where('t2.type')->in('article,blog')->fetchAll('id');
        $products   = $this->dao->select('t1.*, t2.category as category')->from(TABLE_PRODUCT)->alias('t1')->leftJoin(TABLE_RELATION)->alias('t2')->on("t1.id=t2.id")->where('t2.type')->eq('product')->fetchAll('id');

        foreach($articles as $article) 
        {
            $article->category = $categories[$article->category];
            $this->save($article->type, $article);
        }

        foreach($products as $product)
        {
            $product->category = $categories[$product->category];
            $this->save('product', $product);
        }

        $pages = $this->dao->select("*")->from(TABLE_ARTICLE)->fetchAll('id');
        foreach($pages as $page) $this->save('page', $page);

        $threads  = $this->dao->select("*, 'normal' as status")->from(TABLE_THREAD)->fetchAll('id');
        foreach($threads as $thread) $this->save('thread', $thread);

        $books    = $this->dao->select('id,alias')->from(TABLE_BOOK)->where('type')->eq('book')->fetchPairs();
        $articles = $this->dao->select('*')->from(TABLE_BOOK)->where('type')->eq('article')->fetchAll();

        foreach($articles as $article)
        {
            $pathes = explode(',', trim($article->path, ','));
            $bookID = $pathes[0];

            $article->book = $books[$bookID];
            $this->save('book', $article);
        }
    }


    public function deleteIndex($objectType, $objectID)
    {
        $this->dao->delete()->from(TABLE_SEARCH_INDEX)->where('objectType')->eq($objectType)->andWhere('objectID')->eq($objectID)->exec();
        return !dao::isError();
    }
}
