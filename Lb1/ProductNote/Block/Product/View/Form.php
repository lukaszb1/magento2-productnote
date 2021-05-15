<?php

namespace Lb1\ProductNote\Block\Product\View;

use Magento\Framework\View\Element\Template;

class Form
    extends Template
{
    /**
     * Returns current product id.
     *
     * @return int
     */
    public function getProductId(): int
    {
        return (int)$this->getRequest()->getParam('id');
    }

    /**
     * Get note product post action url.
     *
     * @return string
     */
    public function getAction(): string
    {
        return $this->getUrl(
            'productnote/product/post',
            [
                '_secure' => $this->getRequest()->isSecure(),
            ]
        );
    }
}
