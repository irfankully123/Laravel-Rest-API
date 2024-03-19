<?php
namespace App\Filters;
use Closure;
class ProductSearch
{
    public function handle($request, Closure $next)
    {
        if (!request()->has('search')) {
          return $next($request);
        }
        if(request()->has('filter') &&  !empty(request()->input('filter'))){
          return $next($request)->where(request()->input('filter'),'like','%'.request()->input('search').'%');
        }
        return $next($request)
                ->where('id','like','%'.request()->input('search').'%')
                ->Orwhere('name','like','%'.request()->input('search').'%')
                ->Orwhere('quantity','like','%'.request()->input('search').'%')
                ->Orwhere('brand','like','%'.request()->input('search').'%')
                ->Orwhere('model','like','%'.request()->input('search').'%')
                ->Orwhere('category','like','%'.request()->input('search').'%')
                ->Orwhere('stock','like','%'.request()->input('search').'%')
                ->Orwhere('price','like','%'.request()->input('search').'%');
    }
}