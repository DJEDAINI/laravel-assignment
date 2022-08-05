<?php

namespace App\Console\Commands;

use Illuminate\Http\Request;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\ItemController;

class ItemsStatistics extends Command
{
    /**
     * @var string
     */
    protected $signature = 'items:statistics
                            {--filter= : specify with information should be displayed from the statistics}';

    /**
     * @var string
     */
    protected $description = 'Show items statistics';

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return mixed
     */
    public function handle()
    {
        // use validator to validate command options
        $validator = Validator::make(
            $this->options(),
            [
                'filter' => 'nullable|in:total_items,average_price,website_high_prices,total_price_this_month',
            ],
            [
                'filter.in' => 'Unknown filtering provided!, contact me: da_djedaini@esi.dz is you want more statistics...',
            ]
        );

        // if the data is not valid, display errors message and stop handling process.
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
            return;
        }

        // get data from cmd options
        $filter = $this->option('filter');
        $response = app(ItemController::class)->statistics(new Request(['filter' => $filter]))->getData(true);

        foreach ($response['data'] as $key => $value) {
            $statistics[]  = [$key,$value];
        }

        $this->table(
            ['Criteria', 'Data'],
            $statistics
        );
    }
}
