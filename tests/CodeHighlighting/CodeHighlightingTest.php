<?php

declare(strict_types=1);

namespace Semmelsamu\CommonmarkExtensions\Tests\CodeHighlighting;

use Semmelsamu\CommonmarkExtensions\Tests\CommonMarkTest;
use Semmelsamu\CommonmarkExtensions\CodeHighlighting\CodeHighlightingExtension;

class CodeHighlightingTest extends CommonMarkTest
{
    protected function setUp(): void
    {
        parent::configureEnvironment(extensions: [new CodeHighlightingExtension()]);
    }

    public function testCodeHighlighting(): void
    {
        $markdown = <<<'MARKDOWN'
        ```php
        echo "Hello, world!";
        ```
        MARKDOWN;

        $expected = <<<'HTML'
        <pre><code class="hljs php"><span class="hljs-keyword">echo</span> <span class="hljs-string">"Hello, world!"</span>;
        </code></pre>
        HTML;

        $this->assertEquals(
            trim(str_replace("\r", '', $expected)),
            trim(str_replace("\r", '', $this->converter->convert($markdown)->getContent()))
        );
    }

    public function testCodeHighlightingWithoutLanguage(): void
    {
        $markdown = <<<'MARKDOWN'
        ```
        echo "Hello, world!";
        ```
        MARKDOWN;

        $expected = <<<'HTML'
        <pre><code>echo &quot;Hello, world!&quot;;
        </code></pre>
        HTML;

        $this->assertEquals(
            trim(str_replace("\r", '', $expected)),
            trim(str_replace("\r", '', $this->converter->convert($markdown)->getContent()))
        );
    }
}
