<?php

namespace app\components;
use yii\base\Component;

class VKApi extends Component
{
    public $appId;
    public $apiSecret;
    public $accessToken;
    public $owner_id;

    private $_vk;

    public function init() {
        $this->_vk = new \VK\VK($this->appId, $this->apiSecret, $this->accessToken);
        parent::init();
    }
    
    public function getAuthorizeURL($apiSettings, $callbackUrl) {
        return $this->_vk->getAuthorizeURL($apiSettings, $callbackUrl);
    }
    
    public function getAccessToken($code) {
        return $this->_vk->getAccessToken($code);
    }
    
    public function isAuth() {
        return $this->_vk->isAuth();
    }

    public function api($method, $params = []) {
        return $this->_vk->api($method, $params);
    }
} 