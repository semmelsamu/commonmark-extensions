<?php

declare(strict_types=1);

namespace Semmelsamu\CommonmarkExtensions\WikilinkEmbed;

use League\CommonMark\Renderer\NodeRendererInterface;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Node\Node;
use League\CommonMark\Util\HtmlElement;

class EmbedIframeRenderer implements NodeRendererInterface
{
    /**
     * @param Embed $node
     */
    public function render(Node $node, ChildNodeRendererInterface $childRenderer)
    {
        Embed::assertInstanceOf($node);

        $attributes = [
            'src' => $node->src
        ];

        if ($node->caption) {
            $attributes['title'] = $node->caption;
        }

        return new HtmlElement(
            'iframe',
            $attributes
        );
    }
}
