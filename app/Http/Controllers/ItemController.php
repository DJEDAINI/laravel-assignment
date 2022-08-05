<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\ItemRequest;
use App\Http\Resources\ItemResource;
use App\Http\Resources\ItemCollection;

class ItemController extends ApiController
{

    /**
     * Display items statistics.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function statistics(Request $request): JsonResponse
    {
        $response = [];
        $filter = $request->filter;

        if(empty($filter) || $filter == 'total_items') {
            $response['total_items'] = Item::count();
        }

        if(empty($filter) || $filter == 'average_price') {
            $response['average_price'] = (double) Item::avg('price');
        }

        if(empty($filter) || $filter == 'website_high_prices') {

            $websiteWithHighPrices = Item::selectRaw("sum(price) as total_prices, SUBSTRING_INDEX(SUBSTRING_INDEX(url, '://', -1),'/',1) as website")
            ->groupBy('website')
            ->orderBy('total_prices', 'desc')->first();

            $response['website_high_prices'] = $websiteWithHighPrices['website'] ?? 0;
        }

        if(empty($filter) || $filter == 'total_price_this_month') {
            $response['total_price_this_month'] = Item::whereMonth('created_at', Carbon::now()->month)->sum('price');
        }

        return $this->success($response);
    }

    /**
     * Display a listing of the items [paginated].
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        $items = Item::paginate(10);

        return $this->success((new ItemCollection($items))->response()->getData(true));
    }

    /**
     * Show specific item.
     *
     * @param Item $item
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Item $item): JsonResponse
    {
        return $this->success([
            'item' => new ItemResource($item)
        ]);
    }

    /**
     * Add new item.
     *
     * @param \App\Http\Requests\ItemRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ItemRequest $request): JsonResponse
    {
        $item = Item::create($request->data());

        return $this->success(
            ['item' => new ItemResource($item)],
            'item created with success',
        );
    }

    /**
     * Update an existiing item.
     *
     * @param Item $item
     * @param \App\Http\Requests\ItemRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ItemRequest $request, Item $item): JsonResponse
    {
        $item->update($request->data());

        return $this->success(
            ['item' => new ItemResource($item)],
            'item updated with success',
        );
    }
}
