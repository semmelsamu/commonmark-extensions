<?php

declare(strict_types=1);

namespace App\MarkdownExtensions\LaTex;

use League\CommonMark\Node\Block\AbstractBlock;
use League\CommonMark\Parser\Block\AbstractBlockContinueParser;
use League\CommonMark\Parser\Block\BlockContinue;
use League\CommonMark\Parser\Block\BlockContinueParserInterface;
use League\CommonMark\Parser\Cursor;

final class LaTexBlockParser extends AbstractBlockContinueParser
{
    const REGEX_LATEX_END = '/\$\$/';

    /** @psalm-readonly */
    private LaTexBlock $block;

    private string $content = '';

    public function __construct()
    {
        $this->block = new LaTexBlock();
    }

    /**
     * Each instance of a BlockContinueParserInterface is associated with a new 
     * block that is being parsed. This method here returns that block.
     */
    public function getBlock(): AbstractBlock
    {
        return $this->block;
    }

    /**
     * This method returns whether or not the block is a “container” capable of 
     * containing other blocks as children.
     */
    public function isContainer(): bool
    {
        return false;
    }

    /**
     * This method returns whether the current block being parsed can contain 
     * the given child block.
     */
    public function canContain(AbstractBlock $childBlock): bool
    {
        return false;
    }

    /**
     * If canHaveLazyContinuationLines() returned true, this method will be 
     * called with the additional lines of content.
     */
    public function addLine(string $line): void
    {
        $this->content .= rtrim($line, "$");
    }

    /**
     * This method allows you to try and parse an additional line of Markdown.
     */
    public function tryContinue(Cursor $cursor, BlockContinueParserInterface $activeBlockParser): ?BlockContinue
    {
        if ($cursor->match(self::REGEX_LATEX_END)) {
            return BlockContinue::finished();
        }

        return BlockContinue::at($cursor);
    }

    /**
     * This method is called when the block is done being parsed. Any final 
     * adjustments to the block should be made at this time.
     */
    public function closeBlock(): void
    {
        $this->block->setContent($this->content);
    }
}
