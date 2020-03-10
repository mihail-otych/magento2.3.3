<?php
/**
 * @Author      : xiaxixiang
 * @Email       : xiaxixiang86@gmail.com
 * @Time        : 2020/3/9 2:33 下午
 * @Description :
 */

namespace Samary\HelloApi\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Catalog\Model\ProductFactory;
use Magento\Catalog\Helper\Image;
use Magento\Wishlist\Helper\Data as WishlistHelper;
use Magento\Framework\Pricing\PriceCurrencyInterface;

class Data extends AbstractHelper {

    /**
     * @var ProductFactory
     */
    protected $_productFactory;

    /**
     * @var Image
     */
    protected $_imageHelper;

    /**
     * @var PriceCurrencyInterface
     */
    protected $_priceCurrency;

    /**
     * @var WishlistHelper
     */
    protected $_wishlistHelper;

    /**
     * @var \Magento\Review\Model\ReviewFactory
     */
    protected $_reviewFactory;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * Data constructor.
     * @param Context $context
     * @param ProductFactory $productFactory
     * @param Image $imageHelper
     * @param PriceCurrencyInterface $priceCurrency
     * @param WishlistHelper $wishlistHelper
     * @param \Magento\Review\Model\ReviewFactory $reviewFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    public function __construct
    (
        Context $context,
        ProductFactory $productFactory,
        Image $imageHelper,
        PriceCurrencyInterface $priceCurrency,
        WishlistHelper $wishlistHelper,
        \Magento\Review\Model\ReviewFactory $reviewFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->_productFactory = $productFactory;
        $this->_imageHelper     = $imageHelper;
        $this->_priceCurrency   = $priceCurrency;
        $this->_wishlistHelper  = $wishlistHelper;
        $this->_reviewFactory = $reviewFactory;
        $this->_storeManager = $storeManager;
        parent::__construct( $context );
    }

    /**
     * @return int
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @description 商店ID
     */
    public function getStoreId()
    {
        return $this->_storeManager->getStore()->getId();
    }

    /**
     * @param $categoryId
     * @param $num
     *
     * @return mixed
     * @description 获取指定分类产品
     */
    protected function getCategoryProduct( ) {
        $category          = $this->_productFactory->create();
        $productCollection = $category->getCollection()
            ->addAttributeToSelect( '*' )
            ->addFieldToFilter( 'status', 1 )
            ->setPageSize( 5 )
            ->setCurPage( 1 );

        return $productCollection;
    }

    /**
     * @param $product
     *
     * @return mixed
     * @description 产品评论星级
     */
    protected function getRatingSummary($product)
    {
        $this->_reviewFactory->create()->getEntitySummary($product, $this->getStoreId());
        $ratingSummary = $product->getRatingSummary()->getRatingSummary();

        return $ratingSummary;
    }

    /**
     * @param $product
     *
     * @return mixed
     * @description 查您评论数量
     */
    protected function getReviewCount($product)
    {
        $reviewCount = $product->getRatingSummary()->getReviewsCount();
        return $reviewCount;
    }

    /**
     * @param $categoryId
     * @param $num
     *
     * @return array
     * @description 获取产品指定信息
     */
    public function getProductsInfo() {
        $productCollection = $this->getCategoryProduct();
        $data              = [];
        foreach ( $productCollection as $product ) {
            $data[] = [
                'entity_id'   => $product->getId(),
                'name'        => $product->getName(),
                'price'       => $this->_priceCurrency->format( $product->getPrice() ),
                'final_price' => ! empty( $product->getFinalPrice() ) && ($product->getPrice() <=> $product->getFinalPrice()  ) ? $this->_priceCurrency->format( $product->getFinalPrice() ) : 0,
                'src'         => $this->_imageHelper->init( $product, 'product_base_image' )->getUrl(),
                'href'        => $product->getProductUrl(),
                'wishlist_url'=> $this->getAddWishlistUrl($product),
                'ratting'     => $this->getRatingSummary($product) ?: 0,
                'review_count'=> $this->getReviewCount($product) ?: 0
            ];
        }
        return $data;
    }

    /**
     * @param $product
     *
     * @return string
     * @throws \Zend_Json_Exception
     * @description 加入心愿单链接
     */
    public function getAddWishlistUrl($product){
        $data = $this->_wishlistHelper->getAddParams($product);
        $data = \Zend_Json::decode($data);
        $url = rtrim($data['action']."product/".$data['data']['product']."/form_key/".$data['data']['uenc'],',');
        return $url;
    }
}