<?php

namespace AppBundle\Helper;

/**
 * Description of VkDataPackage
 *
 * @author Vasiliy.Razumov <vasiliy@gmail.com>
 */
class VkDataPackage {

    private $accessToken = null;
    private $wallId = null;
    private $limit;
    private $offset;

    public function setAccessToken($accessToken) {
        $this->accessToken = $accessToken;
        return $this;
    }

    public function getAccessToken() {
        return $this->accessToken;
    }

    public function setWallId($wallId) {
        $this->wallId = $wallId;
        return $this;
    }

    public function getWallId() {
        return $this->wallId;
    }

    public function setLimit($limit) {
        $this->limit = $limit;
        return $this;
    }

    public function getLimit() {
        return $this->limit;
    }

    public function setOffset($offset) {
        $this->offset = $offset;
        return $this;
    }

    public function getOffset() {
        return $this->offset;
    }
    
    public function getParametersString() {
        $parameters = [
            'owner_id' => $this->getWallId() > 0 ? -$this->getWallId() : $this->getWallId(),
            'access_token' => $this->getAccessToken(),
            'count' => $this->getLimit(),
            'offset' => $this->getOffset()
        ];
        return http_build_query($parameters);
    }

}
