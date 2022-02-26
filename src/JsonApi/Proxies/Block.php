<?php

namespace A17\Twill\API\JsonApi\Proxies;

use LaravelJsonApi\Eloquent\Proxy;
use A17\Twill\API\Models\Block as TwillApiBlock;

class Block extends Proxy
{
    public function __construct(object $block = null)
    {
        parent::__construct($block ?: new TwillApiBlock());
    }
}
