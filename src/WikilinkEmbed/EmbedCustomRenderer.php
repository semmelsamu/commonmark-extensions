<?php

declare(strict_types=1);

namespace Semmelsamu\CommonmarkExtensions\WikilinkEmbed;

use League\CommonMark\Renderer\NodeRendererInterface;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Node\Node;

class EmbedCustomRenderer implements NodeRendererInterface
{
    private $renderer;

    public function __construct(callable $renderer)
    {
        $this->renderer = $renderer;
    }

    /**
     * @param Embed $node
     */
    public function render(Node $node, ChildNodeRendererInterface $childRenderer)
    {
        return ($this->renderer)($node->src, $node->caption);
    }
}
