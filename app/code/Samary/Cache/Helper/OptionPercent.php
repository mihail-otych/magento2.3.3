<?php
/**
 * User: Samary @email:Samary.xia@gmail.com
 * Date: 2019/11/21
 * Time: 9:33
 * @description
 */

namespace Samary\Cache\Helper;

use Magento\Framework\App\Helper\Context;
use Magento\Framework\Serialize\Serializer\Json;

class OptionPercent extends Abstracts
{
    /**
     * @var string
     */
    protected $cache_tag = 'CUSTOMER_OPTION';
    /**
     * @var string
     */
    protected $cache_id = 'customer_option';

    /**
     * OptionDiscount constructor.
     * @param Context $context
     * @param \Magento\Framework\App\Cache $cache
     * @param \Magento\Framework\App\Cache\State $cacheState
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param Json|null $serializer
     */
    public function __construct(Context $context, \Magento\Framework\App\Cache $cache, \Magento\Framework\App\Cache\State $cacheState, \Magento\Store\Model\StoreManagerInterface $storeManager, Json $serializer = null)
    {
        parent::__construct($context, $cache, $cacheState, $storeManager, $serializer,$this->cache_tag,$this->cache_id);
    }
}