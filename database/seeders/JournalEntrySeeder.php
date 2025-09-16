<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\JournalEntry;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use App\Models\JournalEntryLine;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class JournalEntrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil akun berdasarkan kode
        $cash = Account::where('code', '101')->first(); // Cash
        $revenue = Account::where('code', '401')->first(); // Revenue

        // Validasi kalau data account harus ada
        if (!$cash || !$revenue) {
            $this->command->warn('Cash or Revenue account not found. Please seed accounts first.');
            return;
        }

        // Buat 1 jurnal: penerimaan pendapatan tunai
        $entry = JournalEntry::create([
            'reference' => 'TRX-0002',
            'description' => 'Income from service payment',
            'date' => Carbon::now()->format('Y-m-d'),
        ]);

        // Baris debit (kas bertambah)
        JournalEntryLine::create([
            'journal_entry_id' => $entry->id,
            'account_id' => $cash->id,
            'debit' => 200000,
            'credit' => 0,
            'note' => 'Receive cash',
        ]);

        // Baris kredit (pendapatan bertambah)
        JournalEntryLine::create([
            'journal_entry_id' => $entry->id,
            'account_id' => $revenue->id,
            'debit' => 0,
            'credit' => 200000,
            'note' => 'Service revenue',
        ]);
    }
}
