<?php

declare(strict_types=1);

namespace Semmelsamu\CommonmarkExtensions\Tests;

use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\MarkdownConverter;
use PHPUnit\Framework\TestCase;
use Semmelsamu\CommonmarkExtensions\Callout\CalloutExtension;

class CommonMarkTest extends TestCase
{
    private MarkdownConverter $converter;

    protected function setUp(): void
    {
        $environment = new Environment();
        $environment->addExtension(new CommonMarkCoreExtension());
        $environment->addExtension(new CalloutExtension());

        $this->converter = new MarkdownConverter($environment);
    }

    protected function assertMarkdown(string $markdown, string $expected): void
    {
        $html = trim($this->converter->convert($markdown)->getContent());
        $this->assertEquals($expected, $html);
    }

    /**
     * The CommonMarkTest class needs at least one test, else we get a warning.
     */
    public function testBase(): void
    {
        $this->assertTrue(true);
    }
}
