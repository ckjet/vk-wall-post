<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Helper\PageInfoPackage;
use AppBundle\Entity\Post;
use AppBundle\Helper\PostFilter;

class MainController extends Controller {

    public function indexAction(Request $request) {
        $searchQuery = $request->get('q');
        $page = (int) $request->get('page');
        $pageInfo = new PageInfoPackage();
        $em = $this->getDoctrine()->getManager();
        $currentPage = $page > 1 ? $page : 1;
        $pageInfo->setPage($currentPage);
        $postRepo = $em->getRepository(Post::class);
        $limit = $this->getParameter('post_list_limit');
        $pageInfo->setItemsPerPage($limit);
        $filter = new PostFilter();
        if(strlen($searchQuery) > 1) {
            $filter->setSearchQuery($searchQuery);
            $pageInfo->setSearchQuery($searchQuery);
        }
        $filter->setLimit($limit);
        $filter->setOffset($limit * ($currentPage - 1));
        $filter->setSort([
            'publicated_at' => 'DESC'
        ]);
        $posts = $postRepo->getListByFilter($filter);
        $pageInfo->setCount($posts['total']);
        return $this->render('@App/Main/index.html.twig', [
            'posts' => $posts['data'],
            'page_info' => $pageInfo
        ]);
    }

}
