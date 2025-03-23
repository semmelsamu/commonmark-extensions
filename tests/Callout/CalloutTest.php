<?php

declare(strict_types=1);

namespace Semmelsamu\CommonmarkExtensions\Tests\Callout;

use Semmelsamu\CommonmarkExtensions\Tests\CommonMarkTest;

class CalloutTest extends CommonMarkTest
{
    public function testBasicCallout(): void
    {
        $markdown = "> [!NOTE]\n> This is a note callout";
        $expected = '<blockquote class="callout callout-note"><div class="callout-title flex items-center gap-2">note<strong class="callout-title-inner">Note</strong></div><div class="callout-content"><p>This is a note callout</p></div></blockquote>';

        $this->assertMarkdown($markdown, $expected);
    }

    public function testCalloutWithMultipleLines(): void
    {
        $markdown = "> [!WARNING]\n> First line\n> Second line\n> Third line";
        $expected = '<blockquote class="callout callout-warning"><div class="callout-title flex items-center gap-2">warning<strong class="callout-title-inner">Warning</strong></div><div class="callout-content"><p>First line' . "\n" . 'Second line' . "\n" . 'Third line</p></div></blockquote>';

        $this->assertMarkdown($markdown, $expected);
    }

    public function testCalloutWithNestedContent(): void
    {
        $markdown = "> [!TIP]\n> # Heading\n> - List item 1\n> - List item 2";
        $expected = '<blockquote class="callout callout-tip"><div class="callout-title flex items-center gap-2">tip<strong class="callout-title-inner">Tip</strong></div><div class="callout-content"><h1>Heading</h1>' . "\n" . '<ul>' . "\n" . '<li>List item 1</li>' . "\n" . '<li>List item 2</li>' . "\n" . '</ul></div></blockquote>';

        $this->assertMarkdown($markdown, $expected);
    }

    public function testInvalidCallout(): void
    {
        $markdown = "> This is not a callout";
        $expected = '<blockquote>' . "\n" . '<p>This is not a callout</p>' . "\n" . '</blockquote>';

        $this->assertMarkdown($markdown, $expected);
    }
}
