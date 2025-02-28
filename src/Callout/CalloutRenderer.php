<?php

declare(strict_types=1);

namespace Semmelsamu\CommonmarkExtensions\Callout;

use Illuminate\Support\Facades\Blade;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;
use League\CommonMark\Util\HtmlElement;

final class CalloutRenderer implements NodeRendererInterface
{
    /**
     * @param Callout $node
     */
    public function render(Node $node, ChildNodeRendererInterface $childRenderer): \Stringable
    {
        Callout::assertInstanceOf($node);

        $icon = $node->getIcon();

        $title = $node->title ?? ucfirst($node->type);

        $type = strtolower($node->type);

        $content = $childRenderer->renderNodes($node->children());

        return new HtmlElement(
            'blockquote',
            [
                'class' => "callout callout-{$type}",
            ],
            Blade::render(
                '
                <div class="callout-title flex items-center gap-2">
                    <x-icon :name="$icon" class="callout-icon" />
                    <strong class="callout-title-inner">
                        {{ $title }}
                    </strong>
                </div>
                <div class="callout-content">
                    {!! $content !!}
                </div>',
                ['icon' => $icon, 'title' => $title, 'content' => $content]
            )
        );
    }
}
