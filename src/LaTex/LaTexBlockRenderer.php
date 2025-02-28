<?php

declare(strict_types=1);

namespace App\MarkdownExtensions\LaTex;

use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;
use League\CommonMark\Util\HtmlElement;

class LaTexBlockRenderer implements NodeRendererInterface
{
    public function render(Node $node, ChildNodeRendererInterface $childRenderer): HtmlElement
    {
        /* @var LaTexBlock $node */

        LaTexBlock::assertInstanceOf($node);

        return new HtmlElement(
            'div',
            ['class' => 'latex-block'],
            "$$" . $node->getLiteral() . "$$"
        );
    }
}
