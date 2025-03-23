<?php

declare(strict_types=1);

namespace Semmelsamu\CommonmarkExtensions\Tests;

use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\MarkdownConverter;
use PHPUnit\Framework\TestCase;

/**
 * Utility class which provides some boilerplate for asserting rendered HTML
 * output from CommonMark. Intended to be extended by specific test classes.
 */
class CommonMarkTest extends TestCase
{
    protected MarkdownConverter $converter;

    protected function configureEnvironment(array $config = [], array $extensions = []): void
    {
        $environment = new Environment($config);

        $environment->addExtension(new CommonMarkCoreExtension());
        foreach ($extensions as $extension) {
            $environment->addExtension($extension);
        }

        $this->converter = new MarkdownConverter($environment);
    }

    protected function assertMarkdown(string $markdown, string $expected): void
    {
        $this->assertEquals(
            $this->processHtml($expected),
            $this->processHtml($this->converter->convert($markdown)->getContent())
        );
    }

    /**
     * Post-process the HTML to make it easier to compare with the expected output.
     */
    private function processHtml(string $html): string
    {
        // Strip whitespace from start and end
        $trimmedHtml = trim($html);

        // Remove newlines and indentations
        $noNewLines = preg_replace("/\s*\n\s*/", '', $trimmedHtml);

        // From this processed string, we can now add in some newlines
        return str_replace(">", ">\n", $noNewLines);
    }

    /**
     * The CommonMarkTest class needs at least one test, else we get a warning.
     */
    public function testBase(): void
    {
        $this->assertTrue(true);
    }
}
