<?php

namespace Semmelsamu\CommonmarkExtensions\LaTex;

use League\CommonMark\Parser\Inline\InlineParserInterface;
use League\CommonMark\Parser\Inline\InlineParserMatch;
use League\CommonMark\Parser\InlineParserContext;

class LaTexInlineParser implements InlineParserInterface
{
    /**
     * @var string Matches any string enclosed in single dollar signs
     */
    const INLINE_LATEX_REGEX = '\$([^\$]+?)\$';

    public function getMatchDefinition(): InlineParserMatch
    {
        return InlineParserMatch::regex(self::INLINE_LATEX_REGEX);
    }

    public function parse(InlineParserContext $context): bool
    {
        // Offset 1 = second character
        // If the second character is also a $, it's not inline, it's a block
        if ($context->getCursor()->getCharacter(1) == '$') {
            return false;
        }

        $match = $context->getSubMatches();
        $context->getContainer()->appendChild(new LaTexInline($match[0]));
        $context->getCursor()->advanceBy(strlen($context->getFullMatch()));
        return true;
    }
}
