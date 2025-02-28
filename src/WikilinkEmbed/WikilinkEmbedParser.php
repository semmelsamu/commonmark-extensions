<?php

declare(strict_types=1);

namespace App\MarkdownExtensions\WikilinkEmbed;

use League\CommonMark\Parser\Block\AbstractBlockContinueParser;
use League\CommonMark\Parser\Block\BlockContinue;
use League\CommonMark\Parser\Block\BlockContinueParserInterface;
use League\CommonMark\Parser\Cursor;
use App\MarkdownExtensions\WikilinkEmbed\Embed\Image;
use League\CommonMark\Node\Block\AbstractBlock;
use App\MarkdownExtensions\WikilinkEmbed\Embed\Embed;

class WikilinkEmbedParser extends AbstractBlockContinueParser
{
    private AbstractBlock $block;

    public function __construct(string $source, ?string $caption)
    {
        $extension = pathinfo($source, PATHINFO_EXTENSION);

        $this->block = match ($extension) {
            "jpg", "png" => new Image($source, $caption),
            default => new Embed($source, $caption),
        };
    }

    public function getBlock(): AbstractBlock
    {
        return $this->block;
    }

    public function tryContinue(Cursor $cursor, BlockContinueParserInterface $activeBlockParser): ?BlockContinue
    {
        return BlockContinue::none();
    }
}
