<?php

declare(strict_types=1);

namespace Semmelsamu\CommonmarkExtensions\WikilinkEmbed\Embed;

use League\CommonMark\Renderer\NodeRendererInterface;
use League\CommonMark\Util\HtmlElement;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Node\Node;
use Illuminate\Support\Facades\Blade;

class EmbedRenderer implements NodeRendererInterface
{
    /**
     * @param Embed $node
     */
    public function render(Node $node, ChildNodeRendererInterface $childRenderer)
    {
        Embed::assertInstanceOf($node);
        return '<div class="embed"><a href="' . $node->src . '" target="_blank">' . $node->caption . '</a></div>';
    }
}
