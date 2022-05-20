<?php

namespace A17\Twill\API\Models\Traits;

trait HasChildBlocks
{
    public function parentBlocks()
    {
        return $this->blocks()->whereNull('parent_id');
    }
}
