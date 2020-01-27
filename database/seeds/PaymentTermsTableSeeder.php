<?php

use Illuminate\Database\Seeder;

class PaymentTermsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('payment_terms')->insert([
            [
                'payment_term_name' => '3 Months',
                'no_of_months' => 3
            ], [
                'payment_term_name' => '6 Months',
                'no_of_months' => 6
            ], [
                'payment_term_name' => '12 Months',
                'no_of_months' => 12
            ], [
                'payment_term_name' => '14 Months',
                'no_of_months' => 14
            ], [
                'payment_term_name' => '24 Months',
                'no_of_months' => 24
            ]
        ]);
    }
}
