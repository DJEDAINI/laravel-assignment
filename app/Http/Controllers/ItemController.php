<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Serializers\ItemSerializer;
use App\Serializers\ItemsSerializer;
use App\Http\Requests\ItemRequest;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\ItemCollection;
use App\Http\Resources\ItemResource;

class ItemController extends ApiController
{

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

        return $this->success([
            'item' => new ItemResource($item)
        ]);
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

        return $this->success([
            'item' => new ItemResource($item)
        ]);
    }
}
