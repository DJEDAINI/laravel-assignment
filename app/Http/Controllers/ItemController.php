<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Serializers\ItemSerializer;
use App\Serializers\ItemsSerializer;
use App\Http\Requests\ItemRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use League\CommonMark\CommonMarkConverter;

class ItemController extends Controller
{

    /**
     * Display a listing of the items [paginated].
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $items = Item::paginate(10);

        return JsonResponse::create(['items' => (new ItemsSerializer($items))->getData()]);
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

        return new JsonResponse(['item' => (new ItemSerializer($item))->getData()]);
    }

    /**
     * Show specific item.
     *
     * @param Item $item
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Item $item)
    {
        return new JsonResponse(['item' => (new ItemSerializer($item))->getData()]);
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

        return new JsonResponse(['item' => (new ItemSerializer($item))->getData()]);
    }
}
