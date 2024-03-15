<?php

namespace App\Highlight\Tokens;

use App\Highlight\Language;
use App\Highlight\Patterns\Php\GenericPattern;

final readonly class ParseTokens
{
    /**
     * @return \App\Highlight\Tokens\Token[]
     */
    public function __invoke(string $content, Language $language): array
    {
        $tokens = [];

        foreach ($language->getPatterns() as $key => $pattern) {
            if ($pattern instanceof TokenType) {
                $pattern = new GenericPattern(
                    $key,
                    $pattern,
                );
            }

            $matches = $pattern->match($content);

            $match = $matches['match'] ?? null;

            if (! $match) {
                continue;
            }

            foreach ($match as $item) {
                $offset = $item[1];
                $value = $item[0];

                $token = new Token(
                    offset: $offset,
                    value: $value,
                    type: $pattern->getTokenType(),
                    pattern: $pattern,
                );

                if (! $this->tokenAlreadyPresent($tokens, $token)) {
                    $tokens[] = $token;
                }
            }
        }

        return $tokens;
    }

    private function tokenAlreadyPresent(array $tokens, Token $token): bool
    {
        foreach ($tokens as $tokenToCompare) {
            if ($tokenToCompare->equals($token)) {
                return true;
            }
        }

        return false;
    }
}