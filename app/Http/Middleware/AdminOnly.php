public function handle(Request $request, Closure $next): Response
{
    abort_unless($request->user() && $request->user()->isAdmin(), 403, 'Admins only.');

    return $next($request);
}
