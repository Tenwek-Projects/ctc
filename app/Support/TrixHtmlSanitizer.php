<?php

namespace App\Support;

class TrixHtmlSanitizer
{
    public static function sanitize(string $html): string
    {
        $html = trim($html);
        if ($html === '') {
            return '';
        }

        $allowedTags = [
            'p', 'br', 'div', 'strong', 'em', 'b', 'i',
            'ul', 'ol', 'li',
            'blockquote',
            'h1', 'h2', 'h3', 'h4',
            'a',
        ];

        $dom = new \DOMDocument('1.0', 'UTF-8');
        libxml_use_internal_errors(true);
        $dom->loadHTML('<?xml encoding="utf-8" ?>'.$html, \LIBXML_HTML_NOIMPLIED | \LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();

        $walker = function (\DOMNode $node) use (&$walker, $allowedTags) {
            if ($node->nodeType === XML_ELEMENT_NODE) {
                $tag = strtolower($node->nodeName);
                if (! in_array($tag, $allowedTags, true)) {
                    $parent = $node->parentNode;
                    if ($parent) {
                        while ($node->firstChild) {
                            $parent->insertBefore($node->firstChild, $node);
                        }
                        $parent->removeChild($node);

                        return;
                    }
                } else {
                    if ($node->hasAttributes()) {
                        $attrs = [];
                        foreach (iterator_to_array($node->attributes) as $attr) {
                            $attrs[] = $attr->name;
                        }
                        foreach ($attrs as $attrName) {
                            $node->removeAttribute($attrName);
                        }
                    }

                    if ($tag === 'a') {
                        $href = $node->getAttribute('href');
                        $href = trim((string) $href);
                        if ($href === '' || preg_match('/^\s*javascript:/i', $href)) {
                            $node->removeAttribute('href');
                        } else {
                            $node->setAttribute('href', $href);
                            if (preg_match('/^mailto:/i', $href)) {
                                $node->removeAttribute('target');
                                $node->removeAttribute('rel');
                            } else {
                                $node->setAttribute('rel', 'noopener noreferrer');
                                $node->setAttribute('target', '_blank');
                            }
                        }
                    }
                }
            }

            $children = [];
            foreach (iterator_to_array($node->childNodes) as $child) {
                $children[] = $child;
            }
            foreach ($children as $child) {
                $walker($child);
            }
        };

        $walker($dom);

        $clean = $dom->saveHTML() ?: '';
        $clean = preg_replace('/^<\?xml[^>]*>\s*/', '', $clean) ?? $clean;

        return trim($clean);
    }

    /**
     * Convert Trix-style bare <div> blocks into semantic headings/paragraphs
     * so public prose CSS (h2/h3/p) can style CMS content consistently.
     */
    public static function normalizeBlocksForDisplay(string $html): string
    {
        $html = trim($html);
        if ($html === '') {
            return '';
        }

        $dom = new \DOMDocument('1.0', 'UTF-8');
        libxml_use_internal_errors(true);
        $dom->loadHTML(
            '<?xml encoding="utf-8" ?><div id="ctc-rt-root">'.$html.'</div>',
            \LIBXML_HTML_NOIMPLIED | \LIBXML_HTML_NODEFDTD
        );
        libxml_clear_errors();

        $root = $dom->getElementById('ctc-rt-root');
        if (! $root) {
            return $html;
        }

        foreach (iterator_to_array($root->childNodes) as $node) {
            self::promoteBareDiv($dom, $node);
        }

        $out = '';
        foreach ($root->childNodes as $child) {
            $out .= $dom->saveHTML($child);
        }

        return trim($out);
    }

    private static function promoteBareDiv(\DOMDocument $dom, \DOMNode $node): void
    {
        if ($node->nodeType !== XML_ELEMENT_NODE || strtolower($node->nodeName) !== 'div') {
            return;
        }

        foreach ($node->childNodes as $child) {
            if ($child->nodeType !== XML_ELEMENT_NODE) {
                continue;
            }

            $childTag = strtolower($child->nodeName);
            if (in_array($childTag, ['div', 'p', 'ul', 'ol', 'h1', 'h2', 'h3', 'h4', 'blockquote', 'table'], true)) {
                return;
            }
        }

        $text = trim(preg_replace('/\s+/u', ' ', $node->textContent ?? '') ?? '');
        if ($text === '') {
            return;
        }

        $replacement = $dom->createElement(self::inferBlockTag($text));
        while ($node->firstChild) {
            $replacement->appendChild($node->firstChild);
        }
        $node->parentNode?->replaceChild($replacement, $node);
    }

    private static function inferBlockTag(string $text): string
    {
        $len = mb_strlen($text);

        if ($len <= 120 && str_ends_with($text, '?')) {
            return 'h3';
        }

        // Short title-like lines (section headings from Trix plain text)
        if ($len <= 80 && ! preg_match('/[.!;]/u', $text)) {
            return 'h2';
        }

        return 'p';
    }
}
