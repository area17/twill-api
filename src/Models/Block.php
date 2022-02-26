<?php

namespace A17\Twill\API\Models;

use A17\Twill\Models\Block as TwillBlock;
use A17\Twill\API\Models\Traits\HasMediables;

class Block extends TwillBlock
{
    use HasMediables;

    public function getMorphClass()
    {
        return 'blocks';
    }
}
