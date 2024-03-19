<?php
namespace App\Filters;
use Closure;
class ProductOrderBy
{
    public function handle($request, Closure $next)
    {
        if (!request()->has('sorting')) {
          return $next($request)->orderBy('id','desc');
        }
        if (request()->has('sorting')) {
          return $next($request)->orderBy('id',request()->input('sorting'));
        }
        return $next($request)->orderBy('id','desc');
    }
}