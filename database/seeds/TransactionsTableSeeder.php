<?php

use Illuminate\Database\Seeder;

class TransactionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('transactions')->insert([
            [
                'transaction_type_id' => 1,
                'merchant_id' => 1,
                'amount' => 30000.00
            ], [
                'transaction_type_id' => 2,
                'merchant_id' => 1,
                'amount' => 1000.00
            ], [
                'transaction_type_id' => 2,
                'merchant_id' => 1,
                'amount' => 1000.00
            ]
        ]);
    }
}
