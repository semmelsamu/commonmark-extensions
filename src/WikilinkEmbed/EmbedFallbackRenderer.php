<?php

declare(strict_types=1);

namespace Semmelsamu\CommonmarkExtensions\WikilinkEmbed;

use League\CommonMark\Renderer\NodeRendererInterface;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Node\Node;
use League\CommonMark\Util\HtmlElement;

class EmbedFallbackRenderer implements NodeRendererInterface
{
    /**
     * @param Embed $node
     */
    public function render(Node $node, ChildNodeRendererInterface $childRenderer)
    {
        Embed::assertInstanceOf($node);

        return new HtmlElement(
            'div',
            ['class' => 'embed'],
            new HtmlElement(
                'a',
                ['href' => $node->src, 'target' => '_blank'],
                $node->caption ?? $node->src
            )
        );
    }
}
