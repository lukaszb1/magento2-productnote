<?php

namespace Lb1\ProductNote\Block\Product\View;

use Magento\Framework\App\Http\Context;
use Magento\Framework\View\Element\Template;

class Tab
    extends Template
{
    /**
     * @var Context
     */
    protected $httpContext;

    /**
     * @param Template\Context $context
     * @param Context $httpContext
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        Context $httpContext,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->httpContext = $httpContext;
    }

    /**
     * @return string
     */
    protected function _toHtml(): string
    {
        if ($this->isCustomerLoggedIn()) {
            return parent::_toHtml(); 
        }
        return '';
    }

    /**
     * @return bool
     */
    public function isCustomerLoggedIn(): bool
    {
        return $this->httpContext->getValue(\Magento\Customer\Model\Context::CONTEXT_AUTH);
    }
}
