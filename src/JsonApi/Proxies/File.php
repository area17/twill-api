<?php

namespace A17\Twill\API\JsonApi\Proxies;

use A17\Twill\API\Models\Fileable;
use LaravelJsonApi\Eloquent\Proxy;

class File extends Proxy
{

    /**
     * Media constructor.
     *
     * @param Fileable|null $fileable
     */
    public function __construct(Fileable $fileable = null)
    {
        parent::__construct($fileable ?: new Fileable());
    }
}
