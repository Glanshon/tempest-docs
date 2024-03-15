<?php

namespace App\Highlight\Injections;

use App\Highlight\Highlighter;

trait IsInjection
{
    abstract public function getPattern(): string;

    abstract public function parseContent(string $content, Highlighter $highlighter): string;

    public function parse(string $content, Highlighter $highlighter): string
    {
        $pattern = $this->getPattern();

        if (! str_starts_with($pattern, '/')) {
            $pattern = "/{$pattern}/";
        }

        return preg_replace_callback(
            pattern: $pattern,
            callback: function ($matches) use ($highlighter) {
                $content = $matches['match'] ?? null;

                if (! $content) {
                    return $matches[0];
                }

                return str_replace(
                    search: $content,
                    replace: $this->parseContent($content, $highlighter),
                    subject: $matches[0],
                );
            },
            subject: $content,
        );
    }
}