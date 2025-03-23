<?php

declare(strict_types=1);

namespace Semmelsamu\CommonmarkExtensions\WikilinkEmbed;

use League\CommonMark\Renderer\NodeRendererInterface;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Node\Node;

class EmbedCustomRenderer implements NodeRendererInterface
{
    private string $pattern;
    private callable $renderer;

    public function __construct(string $pattern, callable $renderer)
    {
        $this->pattern = $pattern;
        $this->renderer = $renderer;
    }

    /**
     * @param Embed $node
     */
    public function render(Node $node, ChildNodeRendererInterface $childRenderer)
    {
        Embed::assertInstanceOf($node);

        if (preg_match($this->pattern, $node->src)) {
            return ($this->renderer)($node->src, $node->caption);
        }

        return null; // Let other renderers handle this
    }
}
