<?php

namespace App\Console;

use App\Product;
use App\EComWebStat;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        $schedule -> call(function() {
          $products = Product::getProducts() -> all();
          if (count($products) > 0) {
            $maxUnitsSoldProduct = Product::getProducts() -> all();
            $maxUnitsSoldProductID = $maxUnitsSoldProduct[0] -> id;
            $maxUnitsSoldProductUnitsSold =  $maxUnitsSoldProduct[0] -> units_sold;
            foreach ($maxUnitsSoldProduct as $product) {
              if ($product -> units_sold > $maxUnitsSoldProductUnitsSold) {
                $maxUnitsSoldProductID = $product -> id;
                $maxUnitsSoldProductUnitsSold = $product -> units_sold;
              }
            }
            if ($maxUnitsSoldProductUnitsSold != 0) {
              EComWebStat::addEComWebStat(['product_id' => $maxUnitsSoldProductID, 'units_sold' => $maxUnitsSoldProductUnitsSold]);
            } else {
              EComWebStat::addEComWebStat(['product_id' => null, 'units_sold' => null]);
            }
            echo $products;
          } else {
            // EComWebStat::addEComWebStat(['product_id' => null, 'units_sold' => null]);
          }
        }) -> everyFiveMinutes();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
