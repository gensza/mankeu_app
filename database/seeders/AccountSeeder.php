<?php

namespace Database\Seeders;

use App\Models\Account;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $accounts = [
            // Assets
            ['code' => '100', 'name' => 'Assets', 'type' => 'asset', 'parent_id' => null],
            ['code' => '101', 'name' => 'Cash', 'type' => 'asset', 'parent_code' => '100'],
            ['code' => '102', 'name' => 'Bank', 'type' => 'asset', 'parent_code' => '100'],

            // Liabilities
            ['code' => '200', 'name' => 'Liabilities', 'type' => 'liability', 'parent_id' => null],
            ['code' => '201', 'name' => 'Accounts Payable', 'type' => 'liability', 'parent_code' => '200'],

            // Equity
            ['code' => '300', 'name' => 'Equity', 'type' => 'equity', 'parent_id' => null],
            ['code' => '301', 'name' => 'Owner’s Equity', 'type' => 'equity', 'parent_code' => '300'],

            // Revenue
            ['code' => '400', 'name' => 'Revenue', 'type' => 'revenue', 'parent_id' => null],
            ['code' => '401', 'name' => 'Sales Revenue', 'type' => 'revenue', 'parent_code' => '400'],
            ['code' => '402', 'name' => 'Service Revenue', 'type' => 'revenue', 'parent_code' => '400'],

            // Expense
            ['code' => '500', 'name' => 'Expenses', 'type' => 'expense', 'parent_id' => null],
            ['code' => '501', 'name' => 'Rent Expense', 'type' => 'expense', 'parent_code' => '500'],
            ['code' => '502', 'name' => 'Salary Expense', 'type' => 'expense', 'parent_code' => '500'],
        ];

        $accountMap = [];

        // First pass: insert parents
        foreach ($accounts as $acc) {
            if (!isset($acc['parent_code'])) {
                $account = Account::create([
                    'code' => $acc['code'],
                    'name' => $acc['name'],
                    'type' => $acc['type'],
                    'parent_id' => null,
                ]);
                $accountMap[$acc['code']] = $account->id;
            }
        }

        // Second pass: insert children with parent_id
        foreach ($accounts as $acc) {
            if (isset($acc['parent_code'])) {
                Account::create([
                    'code' => $acc['code'],
                    'name' => $acc['name'],
                    'type' => $acc['type'],
                    'parent_id' => $accountMap[$acc['parent_code']] ?? null,
                ]);
            }
        }
    }
}
