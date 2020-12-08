<?php

namespace Team1\FeaturedCategory\Block\Widget;

use Magento\Catalog\Helper\Image;

/**
 * Class FeaturedCategory
 * @package Team1\FeaturedCategory\Block\Widget
 */
class FeaturedCategory extends \Magento\Framework\View\Element\Template implements \Magento\Widget\Block\BlockInterface
{
    /**
     * @var \Magento\Catalog\Model\CategoryFactory
     */
    protected $_categoryFactory;
    protected $helperData;
    protected $_template = 'widget/FeaturedCategory.phtml';

    /**
     * FeaturedCategory constructor.
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Catalog\Model\CategoryFactory $categoryFactory
     * @param \Team1\FeaturedCategory\Helper\Data $helperData
     * @param Image $imageHelper
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Catalog\Model\CategoryFactory $categoryFactory,
        \Team1\FeaturedCategory\Helper\Data $helperData,
        Image $imageHelper,
        array $data = []
    ) {
        $this->_categoryFactory = $categoryFactory;
        $this->helperData = $helperData;
        $this->imageHelper = $imageHelper;
        parent::__construct($context, $data);
    }
    /**
     * @return collection
     */
    public function getCategoryProductCollection()
    {
        $categoryId = $this->helperData->getGeneralConfig('latest_category');
        $category = $this->_categoryFactory->create()->load($categoryId);

        $collection = $category->getProductCollection()
            ->addAttributeToSelect('*')
            ->setPageSize($this->helperData->getGeneralConfig('limit_product'));

        return $collection;
    }

    /**
     * @return values Name
     */
    public function getNameCategory()
    {
        return $this->helperData->getGeneralConfig('category_name');
    }

    /**
     * @param $product
     * @return string
     */
    public function getProductImageUrl($product)
    {
        $url = $this->imageHelper->init($product, 'product_page_image_small')->getUrl();
        return $url;
    }

    /**
     * @param $product
     * @return mixed
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getRatingSummary($product)
    {
        $this->_reviewFactory->create()->getEntitySummary($product, $this->_storeManager->getStore()->getId());
        $ratingSummary = $product->getRatingSummary()->getRatingSummary();
        return $ratingSummary;
    }

    /**
     * @param \Magento\Catalog\Model\Product $product
     * @param null $priceType
     * @param string $renderZone
     * @param array $arguments
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getProductPriceHtml(
        \Magento\Catalog\Model\Product $product,
        $priceType = null,
        $renderZone = \Magento\Framework\Pricing\Render::ZONE_ITEM_LIST,
        array $arguments = []
    ) {
        if (!isset($arguments['zone'])) {
            $arguments['zone'] = $renderZone;
        }
        $arguments['zone'] = isset($arguments['zone'])
            ? $arguments['zone']
            : $renderZone;
        $arguments['price_id'] = isset($arguments['price_id'])
            ? $arguments['price_id']
            : 'old-price-' . $product->getId() . '-' . $priceType;
        $arguments['include_container'] = isset($arguments['include_container'])
            ? $arguments['include_container']
            : true;
        $arguments['display_minimal_price'] = isset($arguments['display_minimal_price'])
            ? $arguments['display_minimal_price']
            : true;

        /** @var \Magento\Framework\Pricing\Render $priceRender */
        $priceRender = $this->getLayout()->getBlock('product.price.render.default');

        $price = '';
        if ($priceRender) {
            $price = $priceRender->render(
                \Magento\Catalog\Pricing\Price\FinalPrice::PRICE_CODE,
                $product,
                $arguments
            );
        }
        return $price;
    }
}
