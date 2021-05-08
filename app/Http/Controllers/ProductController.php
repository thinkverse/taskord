<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductUpdate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class ProductController extends Controller
{
    public function profile($slug)
    {
        $product = Product::where('slug', $slug)
            ->firstOrFail();
        $type = Route::current()->getName();
        $tasks = $product->tasks()
            ->select('created_at')
            ->get()
            ->groupBy(function ($date) {
                return $date->created_at->format('m');
            });

        $taskmcount = [];
        $countArr = [];

        foreach ($tasks as $key => $value) {
            $taskmcount[(int) $key] = count($value);
        }

        for ($i = 1; $i <= 12; $i++) {
            if (! empty($taskmcount[$i])) {
                $countArr[$i] = $taskmcount[$i];
            } else {
                $countArr[$i] = 0;
            }
        }

        $members = $product->members->pluck('id');
        $members->push($product->owner->id);

        $done_count = $product->tasks()
            ->where('done', true)
            ->whereIn('user_id', $members)
            ->count('id');

        $pending_count = $product->tasks()
            ->where('done', false)
            ->whereIn('user_id', $members)
            ->count('id');

        $response = [
            'product' => $product,
            'type' => $type,
            'graph' => $countArr,
            'done_count' => $done_count,
            'pending_count' => $pending_count,
            'updates_count' => ProductUpdate::where([
                ['product_id', $product->id],
            ])
                ->count('id'),
        ];

        if (Auth::check() && auth()->user()->id === $product->owner->id or Auth::check() && auth()->user()->staffShip) {
            return view($type, $response);
        } elseif ($product->owner->isFlagged) {
            abort(404);
        }

        return view($type, $response);
    }

    public function edit($slug)
    {
        $product = Product::where('slug', $slug)
            ->firstOrFail();

        if (
            Auth::check() && auth()->user()->id === $product->owner->id or
            Auth::check() && auth()->user()->staffShip
        ) {
            return view('product.edit', [
                'product' => $product,
            ]);
        } else {
            abort(404);
        }
    }

    public function newest()
    {
        return view('products.products', [
            'type' => 'products.newest',
        ]);
    }

    public function launched()
    {
        return view('products.products', [
            'type' => 'products.launched',
        ]);
    }

    public function mention(Request $request)
    {
        if ($request['query'] >= 0) {
            $products = Product::select('slug', 'name', 'avatar')
                ->where('user_id', auth()->id())
                ->orWhereHas('members', function (Builder $query) {
                    $query->where('user_id', auth()->id());
                })
                ->search($request['query'])
                ->take(10)
                ->get();
        } else {
            $products = '';
        }

        return $products;
    }

    public function popover(Product $product)
    {
        return view('product.popover', [
            'product' => $product,
        ]);
    }
}
