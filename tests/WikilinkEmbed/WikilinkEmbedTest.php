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
        <iframe src="document.pdf"></iframe>
        HTML;

        $this->assertMarkdown($markdown, $expected);
    }

    public function testEmbedWithCaption(): void
    {
        $markdown = <<<'MARKDOWN'
        ![[document.pdf|View PDF Document]]
        MARKDOWN;

        $expected = <<<'HTML'
        <iframe src="document.pdf" title="View PDF Document"></iframe>
        HTML;

        $this->assertMarkdown($markdown, $expected);
    }
}
