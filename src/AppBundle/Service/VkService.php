<?php

namespace AppBundle\Service;

use AppBundle\Helper\VkDataPackage;

/**
 * Description of VkService
 *
 * @author Vasiliy.Razumov <vasiliy@gmail.com>
 */
class VkService {

    private $currentAttempt = 0;
    private $maxAttempts = 10;

    public function handlePosts(VkDataPackage $vkData) {
        $url = 'https://api.vk.com/method/wall.get?' . $vkData->getParametersString();
        $response = $this->sendRequest($url);
        return $this->formatResponse($response);
    }

    private function formatResponse($response) {
        if (!isset($response['response']) || !sizeof($response['response'])) {
            throw new \Exception('Empty vk api response (2)');
        }
        $out = [
            'total' => array_shift($response['response']),
            'data' => []
        ];
        foreach ($response['response'] as $row) {
            if (is_array($row) && $row['post_type'] === 'post') {

                $out['data'][] = [
                    'id' => $row['id'],
                    'media' => $this->getPostMedia($row),
                    'comments' => $row['comments']['count'],
                    'likes' => $row['likes']['count'],
                    'reposts' => $row['reposts']['count'],
                    'date' => $row['date'],
                    'description' => $row['text']
                ];
            }
        }
        return $out;
    }

    private function getPostMedia($post) {
        if (!isset($post['attachment']) || !sizeof($post['attachment'])) {
            return null;
        }
        $attachment = $post['attachment'];
        $type = $attachment['type'];
        switch ($type) {
            case 'video':
                return [
                    'title' => $attachment[$type]['title'],
                    'image' => isset($attachment[$type]['image_big']) ? $attachment[$type]['image_big'] : ''
                ];
            case 'link':
                return [
                    'title' => $attachment[$type]['title'],
                    'image' => isset($attachment[$type]['image_src']) ? $attachment[$type]['image_src'] : ''
                ];
            case 'photo':
                return [
                    'title' => '',
                    'image' => isset($attachment[$type]['src_big']) ? $attachment[$type]['src_big'] : ''
                ];
            case 'audio':
                return [
                    'title' => '',
                    'image' => ''
                ];
            case 'poll':
                return [
                    'title' => '',
                    'image' => ''
                ];
            case 'doc':
                return [
                    'title' => '',
                    'image' => $attachment[$type]['thumb']
                ];
            case 'album':
                return [
                    'title' => '',
                    'image' => $attachment[$type]['thumb']['src_big']
                ];
            default:
                var_dump($attachment[$type]);
                throw new \Exception("Unknown attachment type: {$type}");
        }
    }

    private function sendRequest($url) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 3);
        $result = curl_exec($curl);
        curl_close($curl);
        if (!$result) {
            if ($this->currentAttempt < $this->maxAttempts) {
                return $this->sendRequest($url);
            }
            throw new \Exception('Empty vk api response');
        }
        $this->currentAttempt = 0;
        return json_decode($result, true);
    }

}
