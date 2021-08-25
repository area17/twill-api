<?php

namespace App\JsonApi\V1\Blocks;

use A17\Twill\API\JsonApi\V1\Blocks\BlockSchema as Schema;

class BlockSchema extends Schema
{
    public array $blockable = ['books', 'pages'];
}
