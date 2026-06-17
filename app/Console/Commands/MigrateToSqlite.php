<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class MigrateToSqlite extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:migrate-to-sqlite';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate database from MySQL to SQLite and copy all existing data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('====================================================');
        $this->info('  Memulai Proses Migrasi MySQL -> SQLite');
        $this->info('====================================================');

        $sqlitePath = database_path('database.sqlite');

        // 1. Buat file SQLite baru
        $this->info("1. Menyiapkan database file SQLite di: $sqlitePath");
        if (File::exists($sqlitePath)) {
            $this->warn("   File SQLite sudah ada. Menimpa file lama...");
        }
        File::put($sqlitePath, '');

        // 2. Daftarkan koneksi SQLite sementara secara dinamis
        Config::set('database.connections.sqlite_temp', [
            'driver' => 'sqlite',
            'database' => $sqlitePath,
            'prefix' => '',
            'foreign_key_constraints' => false, // Nonaktifkan foreign key selama import untuk menghindari error urutan
        ]);

        // 3. Jalankan migrasi pada database SQLite baru
        $this->info('2. Menjalankan migrasi tabel ke database SQLite...');
        Artisan::call('migrate:fresh', [
            '--database' => 'sqlite_temp',
            '--force' => true,
        ]);
        $this->info(Artisan::output());

        // 4. Dapatkan daftar semua tabel dari MySQL
        $this->info('3. Mendapatkan daftar tabel dari MySQL...');
        try {
            $activeDb = DB::connection('mysql')->getDatabaseName();
            $tables = DB::connection('mysql')->getSchemaBuilder()->getTableListing();
            $this->info("   Koneksi MySQL database name: $activeDb");
        } catch (\Exception $e) {
            $this->error('   Gagal membaca daftar tabel MySQL: ' . $e->getMessage());
            return 1;
        }

        // Filter tabel-tabel milik database aktif dan hilangkan prefiks database
        $filteredTables = [];
        foreach ($tables as $table) {
            if (str_contains($table, '.')) {
                [$dbName, $pureTable] = explode('.', $table, 2);
                if ($dbName === $activeDb) {
                    $filteredTables[] = $pureTable;
                }
            } else {
                $filteredTables[] = $table;
            }
        }

        // Filter tabel-tabel sistem yang tidak perlu disalin data fisiknya
        $skipTables = ['migrations', 'sessions', 'cache', 'jobs', 'failed_jobs', 'job_batches', 'cache_locks', 'password_reset_tokens', 'personal_access_tokens'];
        $tablesToCopy = array_diff($filteredTables, $skipTables);

        // 5. Salin data baris demi baris untuk setiap tabel
        $this->info('4. Menyalin data antar database...');
        
        foreach ($tablesToCopy as $table) {
            // Gunakan query langsung ke sqlite_master untuk memeriksa keberadaan tabel
            $tableExists = DB::connection('sqlite_temp')
                ->select("SELECT 1 FROM sqlite_master WHERE type='table' AND name = ?", [$table]);

            if (empty($tableExists)) {
                $this->warn("   Tabel [$table] tidak ditemukan di target SQLite. Dilewati.");
                continue;
            }

            $this->info("   > Menyalin tabel: [$table]");

            // Ambil semua data dari MySQL menggunakan nama tabel murni
            $rows = DB::connection('mysql')->table($table)->get()->map(function ($row) {
                return (array) $row;
            })->toArray();

            $count = count($rows);
            if ($count === 0) {
                $this->info("     Tabel kosong. Tidak ada data disalin.");
                continue;
            }

            // Lakukan insert secara chunk agar hemat memori dan tidak terkena limit SQLite parameter query
            $chunks = array_chunk($rows, 100);
            $inserted = 0;
            
            foreach ($chunks as $chunk) {
                DB::connection('sqlite_temp')->table($table)->insert($chunk);
                $inserted += count($chunk);
            }

            $this->info("     Berhasil menyalin $inserted baris.");
        }

        $this->info('====================================================');
        $this->info('  Migrasi Data Selesai dengan Sukses!');
        $this->info('====================================================');
        $this->info('Silakan ubah variabel DB_CONNECTION=sqlite di file .env Anda.');
        
        return 0;
    }
}
