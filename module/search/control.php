<?php
/**
 * The control file of search module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     search
 * @version     $Id: control.php 4129 2013-01-18 01:58:14Z wwccss $
 * @link        http://www.zentao.net
 */
class search extends control
{
    /**
     * Build search form.
     * 
     * @param  string  $module 
     * @param  array   $searchFields 
     * @param  array   $fieldParams 
     * @param  string  $actionURL 
     * @param  int     $queryID 
     * @access public
     * @return void
     */
    public function buildForm($module = '', $searchFields = '', $fieldParams = '', $actionURL = '', $queryID = 0)
    {
        $module       = empty($module) ? $this->session->searchParams['module'] : $module;
        $searchParams = $module . 'searchParams';
        $queryID      = (empty($module) and empty($queryID)) ? $this->session->$searchParams['queryID'] : $queryID;
        $searchFields = empty($searchFields) ? json_decode($this->session->$searchParams['searchFields'], true) : $searchFields;
        $fieldParams  = empty($fieldParams) ?  json_decode($this->session->$searchParams['fieldParams'], true)  : $fieldParams;
        $actionURL    = empty($actionURL) ?    $this->session->$searchParams['actionURL'] : $actionURL;
        $style        = isset($_SESSION[$searchParams]['style']) ? $this->session->$searchParams['style'] : '';
        $onMenuBar    = isset($_SESSION[$searchParams]['onMenuBar']) ? $this->session->$searchParams['onMenuBar'] : '';

        $_SESSION['searchParams']['module'] = $module;
        $this->search->initSession($module, $searchFields, $fieldParams);

        $this->view->module       = $module;
        $this->view->groupItems   = $this->config->search->groupItems;
        $this->view->searchFields = $searchFields;
        $this->view->actionURL    = $actionURL;
        $this->view->fieldParams  = $this->search->setDefaultParams($searchFields, $fieldParams);
        $this->view->queries      = $this->search->getQueryPairs($module);
        $this->view->queryID      = $queryID;
        $this->view->style        = empty($style) ? 'full' : $style;
        $this->view->onMenuBar    = empty($onMenuBar) ? 'no' : $onMenuBar;
        $this->display();
    }

    /**
     * Build query
     * 
     * @access public
     * @return void
     */
    public function buildQuery()
    {
        $this->search->buildQuery();
        die(js::locate($this->post->actionURL, 'parent'));
    }

    /**
     * Save search query.
     * 
     * @access public
     * @return void
     */
    public function saveQuery($module, $onMenuBar = 'no')
    {
        if($_POST)
        {
            $queryID = $this->search->saveQuery();
            if(!$queryID) die(js::error(dao::getError()));

            $data     = fixer::input('post')->get();
            $shortcut = empty($data->onMenuBar) ? 0 : 1;
            die(js::closeModal('parent.parent', '', "function(){parent.parent.loadQueries($queryID, $shortcut, '{$data->title}')}"));
        }
        $this->view->module    = $module;
        $this->view->onMenuBar = $onMenuBar;
        $this->display();
    }

    /**
     * Delete current search query.
     *
     * @param  int    $queryID
     * @access public
     * @return void
     */
    public function deleteQuery($queryID)
    {
        $this->search->deleteQuery($queryID);
        if(dao::isError()) die(js::error(dao::getError()));
        die('success');
    }

    /**
     * AJAX: get search query.
     *
     * @param  string $module
     * @param  int    $queryID
     * @access public
     * @return void
     */
    public function ajaxGetQuery($module = '', $queryID = 0)
    {
        $query   = $queryID ? $queryID : '';
        $module  = empty($module) ? $this->session->searchParams['module'] : $module;
        $queries = $this->search->getQueryPairs($module);

        $html = '';
        foreach($queries as $queryID => $queryName)
        {
            if(empty($queryID)) continue;
            $html .= '<li>' . html::a("javascript:executeQuery({$queryID})", $queryName . (common::hasPriv('search', 'deleteQuery') ? '<i class="icon icon-close"></i>' : ''), '', "class='label user-query' data-query-id='$queryID'") . '</li>';
        }
        die($html);
    }

    /**
     * Ajax remove from menu.
     * 
     * @param  int    $queryID 
     * @access public
     * @return void
     */
    public function ajaxRemoveMenu($queryID)
    {
        $this->dao->update(TABLE_USERQUERY)->set('shortcut')->eq(0)->where('id')->eq($queryID)->exec();
    }
}
