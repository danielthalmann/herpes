<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $now = now();

        $rows = array_map(fn (array $account) => [
            'id' => (string) Str::ulid(),
            'code' => $account['code'],
            'name' => $account['name'],
            'type' => $account['type'],
            'created_at' => $now,
            'updated_at' => $now,
        ], $this->accounts());

        DB::table('accounts')->insert($rows);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('accounts')
            ->whereIn('code', array_column($this->accounts(), 'code'))
            ->delete();
    }

    /**
     * Read the accounts from the Swiss SME chart of accounts CSV file.
     *
     * @return array<int, array{code: string, name: string, type: string}>
     */
    private function accounts(): array
    {
        $handle = fopen(__DIR__ . '/../plan-comptable-suisse-pme.csv', 'r');
        $accounts = [];

        // skip header
        fgetcsv($handle, null, ';');

        while (($line = fgetcsv($handle, null, ';')) !== false) {
            if (count($line) < 3 || trim($line[0]) === '') {
                continue;
            }

            $accounts[] = [
                'code' => trim($line[0]),
                'name' => trim($line[1]),
                'type' => trim($line[2]),
            ];
        }

        fclose($handle);

        return $accounts;
    }
};
