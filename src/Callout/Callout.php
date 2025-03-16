<?php

namespace Semmelsamu\CommonmarkExtensions\Callout;

use League\CommonMark\Node\Block\AbstractBlock;

class Callout extends AbstractBlock
{
    public function __construct(public readonly string $type, public readonly ?string $title = null) {}
}
