<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Throwable;

class BackupDatabase extends Command
{
    protected $signature = 'backup:database {--keep=14 : Number of days of backups to keep}';

    protected $description = 'Create a compressed SQL backup of the configured database';

    public function handle(): int
    {
        $backupDirectory = storage_path('app/backups');
        File::ensureDirectoryExists($backupDirectory);

        $timestamp = now()->format('Y-m-d_H-i-s');
        $backupPath = $backupDirectory . DIRECTORY_SEPARATOR . 'database-' . $timestamp . '.sql.gz';
        $handle = gzopen($backupPath, 'wb9');

        if ($handle === false) {
            $this->error('Unable to create the backup file. Check storage permissions.');
            return self::FAILURE;
        }

        try {
            $database = DB::getDatabaseName();
            $this->write($handle, '-- Wiratama database backup' . PHP_EOL);
            $this->write($handle, '-- Database: ' . $database . PHP_EOL);
            $this->write($handle, '-- Created: ' . now()->toIso8601String() . PHP_EOL . PHP_EOL);
            $this->write($handle, "SET FOREIGN_KEY_CHECKS=0;\nSTART TRANSACTION;\n\n");

            $tables = DB::select('SHOW FULL TABLES WHERE Table_type = "BASE TABLE"');
            foreach ($tables as $tableRow) {
                $table = (array) $tableRow;
                $tableName = reset($table);
                $create = DB::selectOne('SHOW CREATE TABLE `' . str_replace('`', '``', $tableName) . '`');
                $createSql = (array) $create;
                $createStatement = str_replace(['\\r\\n', '\\n', '\\r'], PHP_EOL, (string) end($createSql));

                $this->write($handle, "DROP TABLE IF EXISTS `{$tableName}`;\n");
                $this->write($handle, $createStatement . ";\n\n");

                DB::table($tableName)->orderByRaw('1')->chunk(500, function ($rows) use ($handle, $tableName): void {
                    foreach ($rows as $row) {
                        $values = [];
                        foreach ((array) $row as $value) {
                            $values[] = $value === null ? 'NULL' : DB::getPdo()->quote((string) $value);
                        }
                        $this->write($handle, 'INSERT INTO `' . $tableName . '` VALUES (' . implode(', ', $values) . ");\n");
                    }
                });
                $this->write($handle, PHP_EOL);
            }

            $this->write($handle, "COMMIT;\nSET FOREIGN_KEY_CHECKS=1;\n");
            gzclose($handle);
            $this->removeOldBackups($backupDirectory, (int) $this->option('keep'));
        } catch (Throwable $exception) {
            gzclose($handle);
            File::delete($backupPath);
            $this->error('Database backup failed: ' . $exception->getMessage());
            return self::FAILURE;
        }

        $this->info('Database backup created: ' . $backupPath);
        return self::SUCCESS;
    }

    private function write($handle, string $content): void
    {
        gzwrite($handle, $content);
    }

    private function removeOldBackups(string $directory, int $keepDays): void
    {
        $cutoff = now()->subDays(max(1, $keepDays))->getTimestamp();
        foreach (File::files($directory) as $file) {
            if ($file->getExtension() === 'gz' && $file->getMTime() < $cutoff) {
                File::delete($file->getPathname());
            }
        }
    }
}
