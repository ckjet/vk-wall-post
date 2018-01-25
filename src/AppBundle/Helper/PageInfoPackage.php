<?php

namespace AppBundle\Helper;

/**
 * Description of PageInfoPackage
 *
 * @author Vasiliy.Razumov <vasiliy@itstably.com>
 */
class PageInfoPackage {

    /**
     *
     * @var integer
     */
    public $count = null;

    /**
     *
     * @var integer
     */
    public $page = null;

    /**
     *
     * @var integer
     */
    public $itemsPerPage = null;

    /**
     *
     * @var string
     */
    public $searchQuery = null;
    
    public function getCount() {
        return $this->count;
    }

    public function setCount($count) {
        $this->count = $count;
        return $this;
    }

    public function getPage() {
        return $this->page;
    }

    public function setPage($page) {
        $this->page = $page;
        return $this;
    }

    public function getItemsPerPage() {
        return $this->itemsPerPage;
    }

    public function setItemsPerPage($itemsPerPage) {
        $this->itemsPerPage = $itemsPerPage;
        return $this;
    }

    public function getPageType() {
        return $this->pageType;
    }

    public function getSearchQuery() {
        return $this->searchQuery;
    }

    public function setSearchQuery($searchQuery) {
        $this->searchQuery = $searchQuery;
        return $this;
    }
    
    public function getClone() {
        $clone = new PageInfoPackage();
        $clone->setCount($this->getCount());
        $clone->setPage($this->getPage());
        $clone->setItemsPerPage($this->getItemsPerPage());
        $clone->setPage($this->getPage());
        $clone->setSearchQuery($this->getSearchQuery());
        return $clone;
    }

}
