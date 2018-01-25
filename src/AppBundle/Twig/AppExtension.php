<?php

namespace AppBundle\Twig;

use AppBundle\Service\PagingService;
use AppBundle\Helper\PageInfoPackage;

class AppExtension extends \Twig_Extension {

    /**
     *
     * @var PagingService
     */
    private $pagingService;

    public function __construct(PagingService $pagingService) {
        $this->pagingService = $pagingService;
    }

    /**
     * Функции
     * 
     * @return array
     */
    public function getFunctions() {
        return [
            new \Twig_SimpleFunction('get_paginator', [$this, 'getPaginatorFunction'])
        ];
    }

    /**
     * Фильтры
     * 
     * @return array
     */
    public function getFilters() {
        return [
            new \Twig_SimpleFilter('text_highlight', [$this, 'textHighlightFilter']),
            new \Twig_SimpleFilter('copyright', [$this, 'CopyrightFilter']),
            new \Twig_SimpleFilter('date_title', [$this, 'dateTitleFilter'])
        ];
    }

    public function copyrightFilter($year) {
        if (strlen($year) < 4) {
            return '&#0169; ' . date('Y');
        } elseif ($year < date('Y')) {
            return '&#0169; ' . $year . ' &mdash; ' . date('Y');
        } elseif ($year > date('Y')) {
            return '&#0169; ' . date('Y');
        }
        return '&#0169; ' . $year;
    }

    public function getPaginatorFunction(PageInfoPackage $pageInfo) {
        return $this->pagingService->getPaginatorHtmlFor($pageInfo);
    }

    public function textHighlightFilter($fulltext, $highlight_text) {
        if (strlen($highlight_text) < 2) {
            return $fulltext;
        }
        return preg_replace('#' . preg_quote($highlight_text) . '#ui', '<code>\\0</code>', $fulltext);
    }
    
    public function dateTitleFilter(\DateTime $date) {
        if($date) {
            $months = [
                'Января',
                'Февраля',
                'Марта',
                'Апреля',
                'Мая',
                'Июня',
                'Июля',
                'Августа',
                'Сентября',
                'Октября',
                'Ноября',
                'Декабря'
            ];
            $dateString = $date->format('d') . ' ' . $months[$date->format('m') -1];
            if($date->format('Y') !== date('Y')) {
                $dateString .= ', ' . $date->format('Y');
            }
            return $dateString;
        }
        return null;
    }

}
