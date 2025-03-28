# CommonMark Extensions

Custom extensions for the [CommonMark PHP](https://commonmark.thephpleague.com/) Markdown parser. Extensions contained:

-   **Callout** - Renders obsidian-like callout and github-like alarm blockquotes
-   **CodeHighlighting** - Highlights code blocks using [highlight.php](https://github.com/scrivo/highlight.php)
-   **LaTex** - Escapes inline- and block-level latex code between dollar signs (`$`)
-   **Wikilink** - Processes Wikilinks like in Obsidian
-   **WikilinkEmbed** - Embeds Wikilinks prefixed with a `!`

## Installation

You can install this package with [Composer](https://getcomposer.org/) (recommended):

```bash
composer require semmelsamu/commonmark-extensions
```

Alternatively (not recommended), refer to the latest stable [release](https://github.com/semmelsamu/commonmark-extensions/releases) and download the source code manually.

## Setup

```php
use League\CommonMark\Environment\Environment;

// Create the converter environment:
$environment = new Environment($config);

// Add the extensions you wish:
$environment->addExtension(new CommonmarkExtension());

// Go forth and convert you some Markdown!
$converter = new MarkdownConverter($environment);
```

## Usage

### Callout

```php
use Semmelsamu\CommonmarkExtensions\Callout\CalloutExtension;
```

You may want to configure the extension:

```php
$config = [
    "callout" => [
        "render_icon" => fn(string) => string;
    ],
    // other configuration ...
]
```

-   `render_icon` - A closure expecting the callout type and returning valid HTML which will be rendered as the icon of the callout.

### CodeHighlighting

```php
use Semmelsamu\CommonmarkExtensions\CodeHighlighting\CodeHighlightingExtension;
```

You may want to download one of the various [highlight.js themes](https://highlightjs.org/examples) in order to actually see any code highlighting, as **this extension does not apply any colors to the code by itself, it only applies CSS classes**. Download the css files [here](https://github.com/highlightjs/highlight.js/tree/main/src/styles) and load them in your HTML.

### LaTex

```php
use Semmelsamu\CommonmarkExtensions\LaTex\LaTexExtension;
```

You may want to download a LaTex highlighting engine like [MathJax](https://www.mathjax.org/), as **this extension does not render LaTex, but escapes it**. Use the code below to load MathJax into your HTML:

```html
<script>
    MathJax = {
        tex: {
            inlineMath: [
                ["$", "$"],
                ["\\(", "\\)"],
            ],
            displayMath: [["$$", "$$"]],
        },
        options: {
            enableMenu: false,
        },
    };
</script>
<script
    id="MathJax-script"
    async
    src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"
></script>
```

### Wikilink

```php
use Semmelsamu\CommonmarkExtensions\Wikilink\WikilinkExtension;
```

You may want to configure the extension:

```php
$config = [
    'wikilink' => [
        'resolve' => fn (string) => string
    ]
]
```

-   `resolve` - A closure expecting the wikilink text and returning the resolved href value which will be used in the `<a>` tag.

### WikilinkEmbed

```php
use Semmelsamu\CommonmarkExtensions\WikilinkEmbed\WikilinkEmbedExtension;
```

You may want to configure the extension:

```php
$config = [
    'wikilink_embed' => [
        'resolve' => fn(string) => string
    ]
];
```

-   `resolve` - A closure expecting the wikilink text and returning the resolved href value which will be used in the `<a>` tag.

As a fallback, this extension already provides a basic iframe renderer for Embeds. You may add your own renderers with higher priority to extend this functionality. The example below shows an image renderer, so that images can also be written as wikilinks:

```php
/**
 * Don't forget to also add this renderer to your environment:
 * `$environment->addRenderer(new WikilinkEmbedImageRenderer())`
 */
class WikilinkEmbedImageRenderer implements NodeRendererInterface
{
    public function render(Node $node, ChildNodeRendererInterface $childRenderer)
    {
        Embed::assertInstanceOf($node);

        if (!preg_match('/\.(jpg|jpeg|png|gif)$/i', $src)) {
            // Not an image, let this embed be handled by some other renderer
            return null;
        }

        $attributes = ['href' => $node->src];

        if ($node->caption) {
            $attributes['alt'] = $node->caption;
        }

        return new HtmlElement(
            'image',
            $attributes
        );
    }
}

```

## Testing

```bash
./vendor/bin/phpunit --do-not-cache-result
```

## License

This project is licenced under the MIT license. See the [`LICENSE`](LICENSE) file for more information.
