<?php

declare(strict_types=1);

namespace Semmelsamu\CommonmarkExtensions\Tests\Callout;

use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\MarkdownConverter;
use PHPUnit\Framework\TestCase;
use Semmelsamu\CommonmarkExtensions\Callout\CalloutExtension;

class CalloutTest extends TestCase
{
    private MarkdownConverter $converter;

    protected function setUp(): void
    {
        $environment = new Environment();
        $environment->addExtension(new CommonMarkCoreExtension());
        $environment->addExtension(new CalloutExtension());

        $this->converter = new MarkdownConverter($environment);
    }

    public function testBasicCallout(): void
    {
        $markdown = "> [!NOTE]\n> This is a note callout";
        $expected = '<blockquote class="callout callout-note"><div class="callout-title flex items-center gap-2">note<strong class="callout-title-inner">Note</strong></div><div class="callout-content"><p>This is a note callout</p></div></blockquote>';

        $html = trim($this->converter->convert($markdown)->getContent());
        $this->assertEquals($expected, $html);
    }

    public function testCalloutWithMultipleLines(): void
    {
        $markdown = "> [!WARNING]\n> First line\n> Second line\n> Third line";
        $expected = '<blockquote class="callout callout-warning"><div class="callout-title flex items-center gap-2">warning<strong class="callout-title-inner">Warning</strong></div><div class="callout-content"><p>First line' . "\n" . 'Second line' . "\n" . 'Third line</p></div></blockquote>';

        $html = trim($this->converter->convert($markdown)->getContent());
        $this->assertEquals($expected, $html);
    }

    public function testCalloutWithNestedContent(): void
    {
        $markdown = "> [!TIP]\n> # Heading\n> - List item 1\n> - List item 2";
        $expected = '<blockquote class="callout callout-tip"><div class="callout-title flex items-center gap-2">tip<strong class="callout-title-inner">Tip</strong></div><div class="callout-content"><h1>Heading</h1>' . "\n" . '<ul>' . "\n" . '<li>List item 1</li>' . "\n" . '<li>List item 2</li>' . "\n" . '</ul></div></blockquote>';

        $html = trim($this->converter->convert($markdown)->getContent());
        $this->assertEquals($expected, $html);
    }

    public function testInvalidCallout(): void
    {
        $markdown = "> This is not a callout";
        $expected = '<blockquote>' . "\n" . '<p>This is not a callout</p>' . "\n" . '</blockquote>';

        $html = trim($this->converter->convert($markdown)->getContent());
        $this->assertEquals($expected, $html);
    }
}
