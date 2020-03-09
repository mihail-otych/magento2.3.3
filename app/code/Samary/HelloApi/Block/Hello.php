<?php
/**
 * @Author      : xiaxixiang
 * @Email       : xiaxixiang86@gmail.com
 * @Time        : 2020/3/9 9:08 上午
 * @Description :
 */

namespace Samary\HelloApi\Block;

use Magento\Framework\View\Element\Template;

class Hello extends Template
{

    protected $layoutProcessors;

    public function __construct
    (
        Template\Context $context,
        array $layoutProcessors = [],
        array $data = []
    )
    {
        $this->jsLayout = isset($data['jsLayout']) && is_array($data['jsLayout']) ? $data['jsLayout'] : [];
        $this->layoutProcessors = $layoutProcessors;
        parent::__construct($context, $data);
    }

    public function getJsLayout()
    {
        foreach ($this->layoutProcessors as $processor) {
            $this->jsLayout = $processor->process($this->jsLayout);
        }
        return \Zend_Json::encode($this->jsLayout);
    }
}