<?php

namespace Semmelsamu\CommonmarkExtensions\LaTex;

use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;

class LaTexInlineRenderer implements NodeRendererInterface
{
    public function render(Node $node, ChildNodeRendererInterface $childRenderer)
    {

        if (!($node instanceof LaTexInline)) {
            throw new \InvalidArgumentException('Wrong node type');
        }

        return '<span class="latex-inline">$' . $node->getExpression() . '$</span>';
    }
}
