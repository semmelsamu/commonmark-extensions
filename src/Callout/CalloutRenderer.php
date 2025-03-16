<?php

declare(strict_types=1);

namespace Semmelsamu\CommonmarkExtensions\Callout;

use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;
use League\CommonMark\Util\HtmlElement;

final class CalloutRenderer implements NodeRendererInterface
{
    private $renderIcon;

    public function __construct(callable $renderIcon)
    {
        $this->renderIcon = $renderIcon;
    }

    /**
     * @param Callout $node
     */
    public function render(Node $node, ChildNodeRendererInterface $childRenderer): \Stringable
    {
        Callout::assertInstanceOf($node);

        $type = strtolower($node->type);
        $title = $node->title ?? ucfirst($type);
        $content = $childRenderer->renderNodes($node->children());

        $titleHtml = new HtmlElement(
            'div',
            ['class' => 'callout-title flex items-center gap-2'],
            [
                ($this->renderIcon)($type),
                new HtmlElement('strong', ['class' => 'callout-title-inner'], $title, false)
            ],
            false
        );

        $contentHtml = new HtmlElement(
            'div',
            ['class' => 'callout-content'],
            $content
        );

        return new HtmlElement(
            'blockquote',
            ['class' => "callout callout-{$type}"],
            [$titleHtml, $contentHtml]
        );
    }
}
