<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use AppBundle\Service\VkService;
use AppBundle\Helper\VkDataPackage;
use AppBundle\Entity\Post;

class ImportPostsCommand extends ContainerAwareCommand {

    protected function configure() {
        $this
        ->setName('import:posts')
        ->setDescription('...')
        ->addOption('all', null, InputOption::VALUE_NONE, 'If this option is set than we get all posts in wall')
        ->addArgument('page', InputArgument::OPTIONAL, 'Page from which get posts');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $container = $this->getContainer();
        /* @var $vkService VkService */
        $vkService = $container->get('app.vk_service');
        $vkData = new VkDataPackage();
        $vkData->setAccessToken($container->getParameter('vk_access_token'));
        $vkData->setWallId($container->getParameter('vk_wall_id'));
        if ($input->getOption('all')) {
            $output->writeln('we get all');
            $vkData->setLimit(1);
            $vkData->setOffset(0);
            $test = $vkService->handlePosts($vkData);
            $pages = ceil($test['total'] / 100);
            $clientPage = $input->getArgument('page');
            if ($clientPage > $pages) {
                $page = $pages;
            } elseif ($clientPage < 1) {
                $page = $pages;
            } else {
                $page = $clientPage;
            }
            for ($i = $page; $i >= 0; $i--) {
                $output->writeln("Page {$i} from {$pages}");
                $vkData->setLimit(100);
                $vkData->setOffset($i * 100);
                $response = $vkService->handlePosts($vkData);
                $saved = $this->saveData($response['data']);
                $output->writeln("Saved: {$saved} posts");
                $output->writeln("We are waiting 2 sec.");
                sleep(2);
            }
        } else {
            $vkData->setLimit(100);
            $vkData->setOffset(0);
            $response = $vkService->handlePosts($vkData);
            $saved = $this->saveData($response['data']);
            $size = sizeof($response['data']);
            var_dump(date('d.m.Y', $response['data'][0]['date']));
            $output->writeln("Saved: {$saved}/{$size} posts");
        }
    }

    private function saveData($data) {
        /* @var $em \Doctrine\ORM\EntityManager */
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $saved = 0;
        foreach ($data as $row) {
            if (!$em->getRepository(Post::class)->findOneBy(['foreign_id' => $row['id']])) {
                $saved++;
                $post = new Post();
                $post->setTitle($row['media']['title']);
                $post->setForeignId($row['id']);
                $post->setComments($row['comments']);
                $post->setDescription($row['description']);
                $post->setImage($row['media']['image']);
                $post->setLikes($row['likes']);
                $post->setReposts($row['reposts']);
                $post->setPublicatedAt(new \DateTime(date('Y-m-d H:i:s', $row['date'])));
                $em->persist($post);
            }
        }
        $em->flush();
        return $saved;
    }

}
