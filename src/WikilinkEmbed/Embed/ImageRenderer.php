<?php

declare(strict_types=1);

namespace Semmelsamu\CommonmarkExtensions\WikilinkEmbed\Embed;

use League\CommonMark\Renderer\NodeRendererInterface;
use League\CommonMark\Util\HtmlElement;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Node\Node;
use Illuminate\Support\Facades\Blade;

class ImageRenderer implements NodeRendererInterface
{
    /**
     * @param Image $node
     */
    public function render(Node $node, ChildNodeRendererInterface $childRenderer)
    {
        Image::assertInstanceOf($node);

        $src = (string) $node->src;
        $caption = $node->caption;

        $imageHtml = new HtmlElement(
            'img',
            [
                'src' => $src,
                'alt' => $caption ?? '',
                'class' => 'image-embed'
            ],
            '',
            false
        );

        $result = new HtmlElement(
            'a',
            ['href' => $src, 'target' => '_blank'],
            $imageHtml
        );

        if (!isset($caption)) {
            return $result;
        }

        return new HtmlElement(
            'figure',
            [],
            [
                $result,
                new HtmlElement(
                    'figcaption',
                    [],
                    $caption,
                    false
                )
            ],
            false
        );
    }
}
