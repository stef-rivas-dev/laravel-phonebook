<?php

namespace App\Http\Middleware;

use Illuminate\Http\Response;
use Closure;

class JsonApiMiddleware
{
    const JSON_HEADER = 'application/vnd.api+json';
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Ensure JSON:API compliant headers
        if ($request->header('Content-Type') !== self::JSON_HEADER) {
            $this->setHeader();
            return response(['errors' => ['Content-type header MUST only contain JSON:API compliant media type']], 415);
        } else if ($request->header('Accept') && $request->header('Accept') !== self::JSON_HEADER) {
            $this->setHeader();
            return response(['errors' => ['Accept header MUST only expect JSON:API compliant media type']], 406);
        }

        $response = $next($request);

        $response->header('Content-Type', self::JSON_HEADER);

        return $response;
    }

    protected function setHeader()
    {
        header_remove('Content-Type');
        header('Content-Type: ' . self::JSON_HEADER);
    }
}
