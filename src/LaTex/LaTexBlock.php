<?php

declare(strict_types=1);

namespace Semmelsamu\CommonmarkExtensions\LaTex;

use League\CommonMark\Node\Block\AbstractBlock;
use League\CommonMark\Node\StringContainerInterface;

class LaTexBlock extends AbstractBlock implements StringContainerInterface
{
    private string $content = '';

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function getLiteral(): string
    {
        return trim($this->content);
    }

    public function setLiteral(string $content): void
    {
        $this->content = $content;
    }
}
