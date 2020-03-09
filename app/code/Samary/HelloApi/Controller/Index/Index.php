<?php
/**
 * @Author      : xiaxixiang
 * @Email       : xiaxixiang86@gmail.com
 * @Time        : 2020/3/9 8:54 上午
 * @Description :
 */

namespace Samary\HelloApi\Controller\Index;

use Magento\Framework\App\Action\Context;

class Index extends \Magento\Framework\App\Action\Action
{

    protected $_resultPageFactory;
    public function __construct
    (
        Context $context,
        \Magento\Framework\View\Result\PageFactory $_resultPageFactory
    )
    {
        $this->_resultPageFactory = $_resultPageFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultPage = $this->_resultPageFactory->create();
        return $resultPage;
    }
}