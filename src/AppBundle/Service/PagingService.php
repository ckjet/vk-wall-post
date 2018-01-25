<?php

namespace AppBundle\Service;

use Twig_Environment;
use AppBundle\Helper\PageInfoPackage;

/**
 * Description of PagingService
 *
 * @author Vasiliy.Razumov <vasiliy@itstably.com>
 */
class PagingService {

    /**
     *
     * @var Twig_Environment
     */
    public $twig;

    public function __construct(Twig_Environment $twig) {
        $this->twig = $twig;
    }

    private function getOnePaginationUrl($pageNumber, $searchQuery = '') {
        $params = [];
        if (strlen($searchQuery) > 1) {
            $params['q'] = $searchQuery;
        }
        if ($pageNumber > 1) {
            $params['page'] = $pageNumber;
        }
        if(!sizeof($params)) {
            return '';
        }
        return '?' . http_build_query($params);
    }

    public function getPaginatorHtmlFor(PageInfoPackage $pageInfo) {
        $currentPage = $pageInfo->getPage();
        $countItems = $pageInfo->getCount();
        $itemsPerPage = $pageInfo->getItemsPerPage();
        $totalPages = intval(ceil($countItems / $itemsPerPage));
        $pagingRange = 6;

        $paginationWithRange = $this->getPaginationWithRange($currentPage, $totalPages, $pagingRange);

        $back = $currentPage > 1 ? $this->getOnePaginationUrl($currentPage - 1, $pageInfo->getSearchQuery()) : false;
        $next = $currentPage < $totalPages ? $this->getOnePaginationUrl($currentPage + 1, $pageInfo->getSearchQuery()) : false;

        $first = $currentPage > 1 ? $this->getOnePaginationUrl(1, $pageInfo->getSearchQuery()) : false;
        $last = $currentPage < $totalPages ? $this->getOnePaginationUrl($totalPages, $pageInfo->getSearchQuery()) : false;

        $pagination = [
            'first' => false,
            'last' => false,
            'current' => $currentPage,
            'back' => $back,
            'next' => $next,
            'pages' => [],
        ];

        foreach ($paginationWithRange as $key => $pageNumber) {
            $currentFlag = $pageNumber == $currentPage;
            $prevFlag = $pageNumber + 1 == $currentPage;
            $nextFlag = $pageNumber - 1 == $currentPage;
            $pagination['pages'][] = [
                'url' => $this->getOnePaginationUrl($pageNumber, $pageInfo->getSearchQuery()),
                'number' => $pageNumber,
                'current' => $currentFlag,
                'prev' => $prevFlag,
                'next' => $nextFlag
            ];
            if ($currentFlag) {
                if ($pageNumber - ($pagingRange / 2) > 1) {
                    $pagination['first'] = [
                        'number' => 1,
                        'url' => $first
                    ];
                }
            }
            if ($key + 1 === sizeof($paginationWithRange)) {
                if ($pageNumber < $totalPages) {
                    $pagination['last'] = [
                        'number' => $totalPages,
                        'url' => $last
                    ];
                }
            }
        }
        $viewData = [
            'pagination' => $pagination,
            'total_pages' => $totalPages
        ];

        return $this->twig->render('@App/Embed/pagination.html.twig', $viewData);
    }

    private function getPaginationWithRange($currentPage, $totalPages, $rangeRadius) {

        $startRange = intVal($currentPage - floor($rangeRadius / 2));
        $endRange = intVal($currentPage + floor($rangeRadius / 2));
        if ($startRange <= 0) {
            $endRange += abs($startRange) + 1;
            $startRange = 1;
        }
        if ($endRange > $totalPages) {
            $startRange -= $endRange - $totalPages;
            $endRange = $totalPages;
        }
        if ($startRange < 1) {
            $startRange = 1;
        }
        return range($startRange, $endRange);
    }

}
