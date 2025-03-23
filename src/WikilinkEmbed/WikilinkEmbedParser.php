<?php

declare(strict_types=1);

namespace Semmelsamu\CommonmarkExtensions\WikilinkEmbed;

use League\CommonMark\Parser\Block\AbstractBlockContinueParser;
use League\CommonMark\Parser\Block\BlockContinue;
use League\CommonMark\Parser\Block\BlockContinueParserInterface;
use League\CommonMark\Parser\Cursor;
use League\CommonMark\Node\Block\AbstractBlock;
use Semmelsamu\CommonmarkExtensions\WikilinkEmbed\Embed;

class WikilinkEmbedParser extends AbstractBlockContinueParser
{
    private AbstractBlock $block;

    public function __construct(string $source, ?string $caption)
    {
        $this->block = new Embed($source, $caption);
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
