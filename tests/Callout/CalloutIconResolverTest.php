<?php

declare(strict_types=1);

namespace Semmelsamu\CommonmarkExtensions\Tests\Callout;

use Semmelsamu\CommonmarkExtensions\Tests\CommonMarkTest;
use Semmelsamu\CommonmarkExtensions\Callout\CalloutExtension;

class CalloutIconResolverTest extends CommonMarkTest
{
    protected function setUp(): void
    {
        parent::configureEnvironment(extensions: [new CalloutExtension()], config: [
            "callout" => [
                "render_icon" => function (string $callout_type) {
                    return '<i>' . strtoupper($callout_type) . ' ICON</i>';
                }
            ]
        ]);
    }

    public function testCalloutWithCustomIcon(): void
    {
        $markdown = <<<'MARKDOWN'
        > [!NOTE]
        > This is a note callout
        MARKDOWN;

        $expected = <<<'HTML'
        <blockquote class="callout callout-note">
            <div class="callout-title">
                <i>NOTE ICON</i>
                <strong class="callout-title-inner">Note</strong>
            </div>
            <div class="callout-content">
                <p>This is a note callout</p>
            </div>
        </blockquote>
        HTML;

        $this->assertMarkdown($markdown, $expected);
    }
}
