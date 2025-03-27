<?php

declare(strict_types=1);

namespace Semmelsamu\CommonmarkExtensions\Tests\Callout;

use Semmelsamu\CommonmarkExtensions\Tests\CommonMarkTest;
use Semmelsamu\CommonmarkExtensions\Callout\CalloutExtension;
use Semmelsamu\CommonmarkExtensions\CodeHighlighting\CodeHighlightingExtension;
use Semmelsamu\CommonmarkExtensions\LaTex\LaTexExtension;
use Semmelsamu\CommonmarkExtensions\Wikilink\WikilinkExtension;
use Semmelsamu\CommonmarkExtensions\WikilinkEmbed\WikilinkEmbedExtension;

class IntegrationTest extends CommonMarkTest
{
    protected function setUp(): void
    {
        parent::configureEnvironment(extensions: [
            new CalloutExtension(),
            new CodeHighlightingExtension(),
            new LaTexExtension(),
            new WikilinkExtension(),
            new WikilinkEmbedExtension()
        ]);
    }

    protected function assertMarkdownFile(string $filePath): void
    {
        $markdownFile = __DIR__ . '/Files/' . $filePath . '.md';
        $htmlFile = __DIR__ . '/Files/' . $filePath . '.html';

        if (!file_exists($markdownFile)) {
            $this->fail("Markdown file not found for file: $filePath");
            return;
        }

        if (!file_exists($htmlFile)) {
            $this->fail("HTML file not found for file: $filePath");
            return;
        }

        $markdown = file_get_contents($markdownFile);
        $expectedHtml = file_get_contents($htmlFile);

        $this->assertMarkdown($markdown, $expectedHtml);
    }

    public function testVektor(): void
    {
        $this->assertMarkdownFile('Vektor');
    }
}
