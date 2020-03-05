<?php
/**
 * User: xiaxixiang @email:1635055310@qq.com
 * Date: 2019/9/19
 * Time: 9:44
 * @description
 */

namespace Samary\Cache\Helper;

use Samary\Cache\Helper\Abstracts;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Serialize\Serializer\Json;

class Detail extends Abstracts
{
    protected $cache_tag = 'PRODUCT_VIEW';
    protected $cache_id = 'product_view';

    public function __construct(Context $context, \Magento\Framework\App\Cache $cache, \Magento\Framework\App\Cache\State $cacheState, \Magento\Store\Model\StoreManagerInterface $storeManager, Json $serializer = null)
    {
        parent::__construct($context, $cache, $cacheState, $storeManager, $serializer,$this->cache_tag,$this->cache_id);
    }
}