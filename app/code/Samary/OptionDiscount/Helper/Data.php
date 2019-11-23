<?php
/**
 * User: Samary @email:Samary.xia@gmail.com
 * Date: 2019/11/21
 * Time: 9:33
 * @description
 */

namespace Samary\OptionPercent\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;
use Magento\CatalogRule\Model\ResourceModel\Rule;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Store\Model\StoreManagerInterface;
use Samary\Cache\Helper\OptionPercent;

class Data extends AbstractHelper
{
    const ENABLED = 'option/percent/enabled';

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    public $config;
    /**
     * @var Rule
     */
    protected $_catalogRule;
    /**
     * @var CustomerSession
     */
    protected $_customerSession;
    /**
     * @var StoreManagerInterface
     */
    protected $_storeManager;
    /**
     * @var DateTime
     */
    protected $_dateTime;
    /**
     * @var
     */
    protected $_optionPercentCache;

    /**
     * Data constructor.
     * @param Context $context
     * @param Rule $rule
     * @param CustomerSession $customerSession
     * @param StoreManagerInterface $storeManager
     * @param DateTime $dateTime
     * @param OptionPercent $optionPercentCache
     */
    public function __construct
    (
        Context $context,
        Rule $rule,
        CustomerSession $customerSession,
        StoreManagerInterface $storeManager,
        DateTime $dateTime,
        OptionPercent $optionPercentCache
    )
    {
        $this->config = $context->getScopeConfig();
        $this->_catalogRule = $rule;
        $this->_customerSession = $customerSession;
        $this->_storeManager = $storeManager;
        $this->_dateTime = $dateTime;
        $this->_optionPercentCache = $optionPercentCache;
        parent::__construct($context);
    }

    /**
     * @param string $configPath
     * @return bool
     */
    public function hasConfig($configPath)
    {
        return $this->config->getValue(
            $configPath,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @param string $enable
     * @return bool
     */
    public function isEnabled($enable = self::ENABLED)
    {
        return $this->hasConfig($enable);
    }

    /**
     * @param $item
     * @return array|bool
     * @throws \Magento\Framework\Exception\LocalizedException
     * @escription Gets the catalog percent rule for the current product
     */
    protected function getCatalogRule($productId)
    {
        $date = $this->_dateTime->gmtDate();
        $cacheId = $this->_optionPercentCache->getId('percent', [$productId]);
        if (($cache = $this->_optionPercentCache->load($cacheId)) != false) {
            $catalogRules = $cache;
        } else {
            $catalogRules = $this->_catalogRule->getRulesFromProduct
            (
                $date,
                $this->_storeManager->getWebsite()->getId(),
                $this->_customerSession->getCustomerGroupId(),
                $productId
            );
            $this->_optionPercentCache->save($catalogRules, $cacheId, 86400 * 7);
        }
        if ($catalogRules) {
            return $catalogRules;
        } else {
            return false;
        }
    }

    /**
     * @param $catalogRules
     * @param $productOptions
     * @param $finalPrice
     * @description Calculate the percent price of option
     */
    public function calculatePrice($optionPrice, $productId)
    {
        if($this->isEnabled()){
            $catalogRules = $this->getCatalogRule($productId);
            if ($catalogRules) {
                foreach ($catalogRules as $catalogRule) {
                    if ($catalogRule['action_operator'] == 'by_percent') {
                        $percent = 1 - ($catalogRule['action_amount'] / 100);
                        $optionPrice = sprintf("%.2f", $percent * $optionPrice);
                    }
                }
            }
        }
        return $optionPrice;
    }
}