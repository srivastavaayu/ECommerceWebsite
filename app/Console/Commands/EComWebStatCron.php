<?php

namespace App\Console\Commands;

use App\Product;
use App\EComWebStat;
use Illuminate\Console\Command;

class EComWebStatCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ecomwebstat:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scheduled maintenance of the statistics of EComWeb!';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

      $products = Product::getProductsCount();
      if ($products > 0) {
        $maxUnitsSoldProduct = Product::getProducts();
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
      } else {
        EComWebStat::addEComWebStat(['product_id' => null, 'units_sold' => null]);
      }

    }
}
