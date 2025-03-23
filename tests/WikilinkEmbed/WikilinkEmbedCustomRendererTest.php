<?php

declare(strict_types=1);

namespace Semmelsamu\CommonmarkExtensions\Tests\WikilinkEmbed;

use Semmelsamu\CommonmarkExtensions\Tests\CommonMarkTest;
use Semmelsamu\CommonmarkExtensions\WikilinkEmbed\WikilinkEmbedExtension;

class WikilinkEmbedCustomRendererTest extends CommonMarkTest
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->configureEnvironment([
            'wikilink_embed' => [
                'resolve' => fn(string $wikilink) => $wikilink,
                'renderers' => [
                    [
                        'pattern' => '/\.(jpg|jpeg|png|gif)$/i',
                        'renderer' => function (string $source, ?string $caption) {
                            return sprintf('<img src="%s" alt="%s">', $source, $caption ?? '');
                        }
                    ]
                ]
            ]
        ], [
            new WikilinkEmbedExtension()
        ]);
    }

    public function testCustomImageRenderer(): void
    {
        $this->assertMarkdown(
            '![[image.jpg]]',
            '<img src="image.jpg" alt="">'
        );
    }

    public function testCustomImageRendererWithCaption(): void
    {
        $this->assertMarkdown(
            '![[image.jpg|Image Text]]',
            '<img src="image.jpg" alt="Image Text">'
        );
    }

    public function testNonImageWikilinkFallsBackToDefault(): void
    {
        $markdown = <<<'MARKDOWN'
        ![[document.pdf]]
        MARKDOWN;

        $expected = <<<'HTML'
        <div class="embed">
            <a href="document.pdf" target="_blank">document.pdf</a>
        </div>
        HTML;

        $this->assertMarkdown($markdown, $expected);
    }
}
