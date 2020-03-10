<?php
/**
 * @Author      : xiaxixiang
 * @Email       : xiaxixiang86@gmail.com
 * @Time        : 2020/3/9 2:27 下午
 * @Description : Hot Sale产品获取
 */

namespace Samary\HelloApi\Controller\Index;

use Samary\HelloApi\Helper\Data;
use Samary\HelloApi\Helper\Data as DataHelper;
use Magento\Framework\App\Action\Context;


class Product extends \Magento\Framework\App\Action\Action
{

    /**
     * @var DataHelper
     */
    protected $_dataHelper;


    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $_jsonFactory;

    /**
     * HotSale constructor.
     *
     * @param Context $context
     * @param DataHelper $dataHelper
     * @param \Magento\Framework\Controller\Result\JsonFactory $jsonFactory
     */
    public function __construct
    (
        Context $context,
        DataHelper $dataHelper,
        \Magento\Framework\Controller\Result\JsonFactory $jsonFactory
    )
    {
        $this->_dataHelper = $dataHelper;
        $this->_jsonFactory = $jsonFactory;
        parent::__construct($context);
    }


    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Json|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        if ($this->_request->isAjax()) {
            $resultJson = $this->_jsonFactory->create();
            $success = false;
            $messages = [];
            $products = $this->_dataHelper->getProductsInfo();

            if (count($products) > 0) {
                $messages = $products;
                $success = true;
            }
            return $resultJson->setData([
                'messages' => $messages,
                'success' => $success
            ]);

        } else {
            return $this->resultRedirectFactory->create()->setPath($this->_url->getUrl('noroute'));
        }
    }
}