# CommonMark Extensions

Custom extensions for the [CommonMark PHP](https://commonmark.thephpleague.com/) Markdown parser. Extensions contained:

-   **Callout** - Renders obsidian-like callout and github-like alarm blockquotes
-   **CodeHighlighting** - Highlights code blocks using [highlight.php](https://github.com/scrivo/highlight.php)
-   **LaTex** - Escapes inline- and block-level latex code between dollar signs (`$`)
-   **Wikilink** - Processes Wikilinks like in Obsidian
-   **WikilinkEmbed** - Embeds Wikilinks prefixed with a `!`

## Installation

TODO: Upload to Packagist

This library is available through [Composer](https://getcomposer.org/). You can install it using the following command:

```bash
composer require semmelsamu/commonmark-extensions
```

## Setup

TODO: Register in Environment

```php
use League\CommonMark\Environment\Environment;
use Semmelsamu\CommonMark

// Create the converter environment:
$environment = new Environment($config);

// Add the extensions you wish:
$environment->addExtension(new InlinesOnlyExtension());

// Go forth and convert you some Markdown!
$converter = new MarkdownConverter($environment);
```

### Callout

TODO: Register Icon Resolver/Renderer

### CodeHighlighting

TODO: Add css stylesheet to frontend

### LaTex

TODO: Probably add LaTex Renderer (like MathJax) to frontend

### Wikilink

TODO: Add Wikilink resolver

### WikilinkEmbed

TODO: Additional to Wikilink resolver, add custom embed rednerers

## Testing

Run

```bash
./vendor/bin/phpunit --do-not-cache-result
```

## License

This project is licenced under the MIT license. See the [`LICENSE`](LICENSE) file for more information.
