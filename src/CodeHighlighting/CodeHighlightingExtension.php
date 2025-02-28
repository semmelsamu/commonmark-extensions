<?php

declare(strict_types=1);

namespace Semmelsamu\CommonmarkExtensions\CodeHighlighting;

use League\CommonMark\Environment\EnvironmentBuilderInterface;
use League\CommonMark\Extension\CommonMark\Node\Block\FencedCode;
use League\CommonMark\Extension\ExtensionInterface;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;
use Illuminate\Support\Facades\Blade;

class CodeHighlightingExtension implements ExtensionInterface, NodeRendererInterface
{
    private readonly \Highlight\Highlighter $highlighter;

    public function __construct()
    {
        $this->highlighter = new \Highlight\Highlighter();
    }

    public function register(EnvironmentBuilderInterface $environment): void
    {
        $environment->addRenderer(FencedCode::class, $this, 100);
    }

    public function render(Node $node, ChildNodeRendererInterface $childRenderer)
    {
        /** @var FencedCode $node */

        try {
            $language = $node->getInfo();
            $highlighted = $this->highlighter->highlight($language, $node->getLiteral());

            $result = "<pre><code class=\"hljs {$highlighted->language}\">";
            $result .= $highlighted->value;
            $result .= "</code></pre>";

            return $result;
        } catch (\Exception $e) {
            return sprintf(
                '<pre><code>%s</code></pre>',
                htmlspecialchars($node->getLiteral(), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8')
            );
        }
    }
}
