<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * This middleware handles the preprocessing of idea submissions.
 *
 * It cleans up the title field on the request before the controller
 * sees it so that everything downstream gets a consistent string.
 */
class PreprocessIdeaSubmission
{
    public function handle(Request $request, Closure $next): Response
    {
        $data = $request->input('title');

        if (is_string($data)) {
            // trim and collapse whitespace
            $data = trim($data);
            $data = (string) preg_replace('/\s+/', ' ', $data);

            // strip common prefixes that users tend to type
            $data = (string) preg_replace('/^(feature request|idea|suggestion)\s*[:\-]\s*/i', '', $data);

            // capitalize the first letter for consistency
            if ($data !== '') {
                $data = mb_strtoupper(mb_substr($data, 0, 1)).mb_substr($data, 1);
            }

            $request->merge(['title' => $data]);
        }

        return $next($request);
    }
}
