<?php

declare(strict_types=1);

namespace Semmelsamu\CommonmarkExtensions\WikilinkEmbed\Embed;

use League\CommonMark\Node\Block\AbstractBlock;

class Image extends AbstractBlock
{
    public function __construct(
        public readonly string $src,
        public readonly ?string $caption = null
    ) {}
}
