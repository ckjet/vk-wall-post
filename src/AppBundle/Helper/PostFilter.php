<?php

namespace AppBundle\Helper;

/**
 * Description of PostFilter
 *
 * @author Vasiliy.Razumov <vasiliy@itstably.com>
 */
class PostFilter {
    
    /**
     *
     * @var string
     */
    public $searchQuery;

    /**
     *
     * @var integer
     */
    public $limit;

    /**
     *
     * @var integer
     */
    public $offset;
    
    /**
     *
     * @var []
     */
    private $sort;

    public function getSearchQuery() {
        return $this->searchQuery;
    }

    public function setSearchQuery($searchQuery) {
        $this->searchQuery = $searchQuery;
        return $this;
    }

    public function getLimit() {
        return $this->limit;
    }

    public function setLimit($limit) {
        $this->limit = $limit;
        return $this;
    }

    public function getOffset() {
        return $this->offset;
    }

    public function setOffset($offset) {
        $this->offset = $offset;
        return $this;
    }

    public function getSort() {
        return $this->sort;
    }

    public function setSort($sort) {
        $this->sort = $sort;
        return $this;
    }

}
