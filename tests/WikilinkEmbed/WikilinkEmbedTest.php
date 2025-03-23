<?php

declare(strict_types=1);

namespace Semmelsamu\CommonmarkExtensions\Tests\WikilinkEmbed;

use Semmelsamu\CommonmarkExtensions\Tests\CommonMarkTest;
use Semmelsamu\CommonmarkExtensions\WikilinkEmbed\WikilinkEmbedExtension;

class WikilinkEmbedTest extends CommonMarkTest
{
    protected function setUp(): void
    {
        parent::configureEnvironment(extensions: [new WikilinkEmbedExtension()]);
    }

    public function testBasicEmbed(): void
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

    public function testEmbedWithCaption(): void
    {
        $markdown = <<<'MARKDOWN'
        ![[document.pdf|View PDF Document]]
        MARKDOWN;

        $expected = <<<'HTML'
        <div class="embed">
            <a href="document.pdf" target="_blank">View PDF Document</a>
        </div>
        HTML;

        $this->assertMarkdown($markdown, $expected);
    }
}
