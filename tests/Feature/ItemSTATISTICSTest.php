<?php

namespace Tests\Feature;

use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ItemSTATISTICSTest extends TestCase
{
    use RefreshDatabase;

    public function test_getting_statistics(): void
    {
        Item::factory()->amazon()->count(3)->create();
        Item::factory()->zid()->count(4)->create();
        Item::factory()->steam()->count(1)->create();

        $response = $this->getJson('/items/statistics');
        $response->assertStatus(200);

        $response->assertJsonStructure(['data' => ['total_items', 'average_price', 'website_high_prices', 'total_price_this_month']]);

        $response->assertJson(function (AssertableJson $json) {
            $json->has('data')->etc();
            $json->has('data', function (AssertableJson $json) {
                $json
                    ->whereType('total_items', 'integer')
                    ->whereType('average_price', 'double')
                    ->whereType('website_high_prices', 'string')
                    ->whereType('total_price_this_month', 'integer');
            });
        });
    }

    public function test_filter_statistics(): void
    {
        $response = $this->getJson('/items/statistics?filter=total_items');

        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => ['total_items']]);

        $response->assertJson(function (AssertableJson $json) {
            $json->has('data')->etc();
            $json->has('data', function (AssertableJson $json) {
                $json->whereType('total_items', 'integer')
                    ->missing('average_price', 'double')
                    ->missing('website_high_prices', 'string')
                    ->missing('total_price_this_month', 'integer');
            });
        });

    }
}
