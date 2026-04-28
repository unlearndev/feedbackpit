<?php

namespace App\Services;

use App\Models\Idea;

/**
 * This service handles the similarity check for ideas.
 *
 * It looks at the existing ideas in the database and computes a
 * similarity score for each one against the input title, then
 * returns the best match.
 */
class IdeaSimilarityService
{
    /**
     * Find the best match for the given title.
     *
     * Loops through existing ideas and computes a similarity score
     * for each one, then returns the best result.
     *
     * @return array{idea: Idea, score: float}|null
     */
    public function findBestMatch(string $title, ?string $matchKey = null): ?array
    {
        $key = $matchKey !== null && $matchKey !== '' ? $matchKey : $this->normalize($title);

        $tokens = array_values(array_filter(explode(' ', $key), fn ($t) => mb_strlen($t) > 2));

        if ($tokens === []) {
            return null;
        }

        // grab the longest tokens to use for the prefilter query
        usort($tokens, fn ($a, $b) => mb_strlen($b) <=> mb_strlen($a));
        $tokens = array_slice($tokens, 0, 3);

        // run the LIKE prefilter to narrow down candidates
        $query = Idea::query();
        $query->where(function ($q) use ($tokens): void {
            foreach ($tokens as $item) {
                $q->orWhere('title', 'like', '%'.$item.'%');
            }
        });

        $candidates = $query->limit(50)->get();

        if ($candidates->isEmpty()) {
            return null;
        }

        $results = [];

        // loop through the candidates and compute the score
        foreach ($candidates as $item) {
            $temp = $this->normalize($item->title);

            $score = $this->score($key, $temp);

            $results[] = [
                'idea' => $item,
                'score' => $score,
            ];
        }

        // return the best one
        usort($results, fn ($a, $b) => $b['score'] <=> $a['score']);

        return $results[0] ?? null;
    }

    private function score(string $a, string $b): float
    {
        if ($a === '' || $b === '') {
            return 0.0;
        }

        $aTokens = array_values(array_unique(array_filter(explode(' ', $a))));
        $bTokens = array_values(array_unique(array_filter(explode(' ', $b))));

        if ($aTokens === [] || $bTokens === []) {
            return 0.0;
        }

        $intersection = count(array_intersect($aTokens, $bTokens));

        // dice coefficient — symmetric and unaffected by length asymmetry
        $dice = (2 * $intersection) / (count($aTokens) + count($bTokens));

        // containment — 1.0 when one token set is a subset of the other,
        // so substring titles like "Dark mode" / "Dark mode support" match
        $containment = $intersection / min(count($aTokens), count($bTokens));

        return 0.5 * $dice + 0.5 * $containment;
    }

    private function normalize(string $text): string
    {
        $text = mb_strtolower($text);
        $text = (string) preg_replace('/[^a-z0-9 ]+/', ' ', $text);
        $text = (string) preg_replace('/\s+/', ' ', $text);
        $text = trim($text);

        // drop a few common stopwords
        $stop = ['the', 'a', 'an', 'of', 'to', 'and', 'or'];
        $parts = array_filter(explode(' ', $text), fn ($w) => ! in_array($w, $stop, true));

        return implode(' ', $parts);
    }
}
