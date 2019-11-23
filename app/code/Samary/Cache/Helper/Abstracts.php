<?php
/**
 * User: Samary @email:Samary.xia@gmail.com
 * Date: 2019/11/21
 * Time: 9:33
 * @description
 */

namespace Samary\Cache\Helper;

use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Serialize\Serializer\Json;

class Abstracts extends \Magento\Framework\App\Helper\AbstractHelper
{
    const CACHE_LIFETIME = 86400;

    /**
     * @var string
     */
    protected $cache_tag = 'COMMON';
    /**
     * @var string
     */
    protected $cache_id = 'common';

    /**
     * @var \Magento\Framework\App\Cache
     */
    protected $cache;

    /**
     * @var \Magento\Framework\App\Cache\State
     */
    protected $cacheState;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var
     */
    private $storeId;
    /**
     * @var
     */
    protected $serializer;

    /**
     * Review constructor.
     * @param Context $context
     * @param \Magento\Framework\App\Cache $cache
     * @param \Magento\Framework\App\Cache\State $cacheState
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    public function __construct
    (
        Context $context,
        \Magento\Framework\App\Cache $cache,
        \Magento\Framework\App\Cache\State $cacheState,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        Json $serializer = null,
        $cacheTag = null,
        $cacheId = null
    )
    {
        parent::__construct($context);
        $this->cache = $cache;
        $this->cacheState = $cacheState;
        $this->storeManager = $storeManager;
        $this->storeId = $storeManager->getStore()->getId();
        $this->serializer = $serializer ?: ObjectManager::getInstance()->get(Json::class);
        $this->cache_tag = $cacheTag ?: $this->cache_tag;//缓存Tag标签
        $this->cache_id = $cacheId ?: $this->cache_id;//缓存ID
    }

    /**
     * @param $method
     * @param array $vars
     * @return string
     */
    public function getId($method, $vars = array())
    {
        return base64_encode($this->storeId . $this->cache_id . $method . implode('', $vars));
    }

    /**
     * @param $cacheId
     * @return bool|string
     */
    public function load($cacheId)
    {
        if ($this->cacheState->isEnabled($this->cache_id)) {
            $cache = $this->cache->load($cacheId);
            if ($cache) {
                return $this->serializer->unserialize($cache);
            }
        }

        return false;
    }

    /**
     * @param $data
     * @param $cacheId
     * @param int $cacheLifeTime
     * @return bool
     */
    public function save($data, $cacheId, $cacheLifeTime = self::CACHE_LIFETIME)
    {
        if ($this->cacheState->isEnabled($this->cache_id)) {
            $data = $this->serializer->serialize($data);
            $this->cache->save($data, $cacheId, array($this->cache_tag), $cacheLifeTime);
            return true;
        }

        return false;
    }
}