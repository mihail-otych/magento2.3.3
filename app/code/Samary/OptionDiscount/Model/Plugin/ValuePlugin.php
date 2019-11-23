<?php
/**
 * User: Samary @email:Samary.xia@gmail.com
 * Date: 2019/11/21
 * Time: 9:33
 * @description
 */

namespace Samary\OptionDiscount\Model\Plugin;

use Magento\Catalog\Model\Product\Option\Value;
use Samary\OptionDiscount\Helper\Data;

class ValuePlugin
{
    /**
     * @var Data
     */
    protected $_helper;

    /**
     * ValuePlugin constructor.
     * @param Data $data
     */
    public function __construct
    (
        Data $data
    )
    {
        $this->_helper = $data;
    }

    /**
     * @param Value $subject
     * @param $result
     * @return string
     */
    public function afterGetPrice(Value $subject, $result)
    {
        $productId = $subject->getOption()->getProductId();
        return $this->_helper->calculatePrice($result, $productId);
    }
}