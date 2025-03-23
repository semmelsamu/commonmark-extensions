<?php

declare(strict_types=1);

namespace Semmelsamu\CommonmarkExtensions\Tests\Callout;

use Semmelsamu\CommonmarkExtensions\Tests\CommonMarkTest;
use Semmelsamu\CommonmarkExtensions\Callout\CalloutExtension;

class CalloutTest extends CommonMarkTest
{
    protected function setUp(): void
    {
        parent::configureEnvironment(extensions: [new CalloutExtension()]);
    }

    public function testBasicCallout(): void
    {
        $markdown = <<<'MARKDOWN'
        > [!NOTE]
        > This is a note callout
        MARKDOWN;

        $expected = <<<'HTML'
        <blockquote class="callout callout-note">
            <div class="callout-title">
                note
                <strong class="callout-title-inner">Note</strong>
            </div>
            <div class="callout-content">
                <p>This is a note callout</p>
            </div>
        </blockquote>
        HTML;

        $this->assertMarkdown($markdown, $expected);
    }

    public function testCalloutWithMultipleLines(): void
    {
        $markdown = <<<'MARKDOWN'
        > [!WARNING]
        > First line
        > Second line
        > Third line
        MARKDOWN;

        $expected = <<<'HTML'
        <blockquote class="callout callout-warning">
            <div class="callout-title">
                warning
                <strong class="callout-title-inner">Warning</strong>
            </div>
            <div class="callout-content">
                <p>
                    First line
                    Second line
                    Third line
                </p>
            </div>
        </blockquote>
        HTML;

        $this->assertMarkdown($markdown, $expected);
    }

    public function testCalloutWithNestedContent(): void
    {
        $markdown = <<<'MARKDOWN'
        > [!TIP]
        > # Heading
        > - List item 1
        > - List item 2
        MARKDOWN;

        $expected = <<<'HTML'
        <blockquote class="callout callout-tip">
            <div class="callout-title">
                tip
                <strong class="callout-title-inner">Tip</strong>
            </div>
            <div class="callout-content">
                <h1>Heading</h1>
                <ul>
                    <li>List item 1</li>
                    <li>List item 2</li>
                </ul>
            </div>
        </blockquote>
        HTML;

        $this->assertMarkdown($markdown, $expected);
    }

    public function testInvalidCallout(): void
    {
        $markdown = <<<'MARKDOWN'
        > This is not a callout
        MARKDOWN;

        $expected = <<<'HTML'
        <blockquote>
            <p>This is not a callout</p>
        </blockquote>
        HTML;

        $this->assertMarkdown($markdown, $expected);
    }
}
