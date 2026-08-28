<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use RuntimeException;
use Throwable;

class RestoreDatabase extends Command
{
    protected $signature = 'restore:database {file : Path to a .sql or .sql.gz backup} {--force : Skip the confirmation prompt}';

    protected $description = 'Restore a database from a SQL or compressed SQL backup';

    public function handle(): int
    {
        $file = (string) $this->argument('file');
        if (!File::exists($file)) {
            $this->error('Backup file not found: ' . $file);
            return self::FAILURE;
        }

        if (!$this->option('force') && !$this->confirm('This will replace database tables with the backup. Continue?')) {
            $this->warn('Restore cancelled.');
            return self::SUCCESS;
        }

        try {
            $sql = str_ends_with(strtolower($file), '.gz')
                ? gzdecode(File::get($file))
                : File::get($file);
            $sql = str_replace(['\\r\\n', '\\n', '\\r'], PHP_EOL, (string) $sql);

            if ($sql === false || trim($sql) === '') {
                throw new RuntimeException('The backup file is empty or invalid.');
            }

            $statements = $this->splitStatements($sql);
            $insertCount = 0;
            foreach ($statements as $statement) {
                if (trim($statement) !== '') {
                    if (str_starts_with(ltrim($statement), 'INSERT INTO')) {
                        $insertCount++;
                    }
                    DB::unprepared($statement);
                }
            }
            $this->line('Processed ' . count($statements) . ' SQL statements, including ' . $insertCount . ' inserts.');
        } catch (Throwable $exception) {
            $this->error('Database restore failed: ' . $exception->getMessage());
            return self::FAILURE;
        }

        $this->info('Database restored from: ' . $file);
        return self::SUCCESS;
    }

    private function splitStatements(string $sql): array
    {
        $statements = [];
        $statement = '';
        $inSingleQuote = false;
        $inDoubleQuote = false;
        $length = strlen($sql);

        for ($index = 0; $index < $length; $index++) {
            $character = $sql[$index];
            $previous = $index > 0 ? $sql[$index - 1] : '';

            if ($character === "'" && !$inDoubleQuote && $previous !== '\\') {
                $inSingleQuote = !$inSingleQuote;
            } elseif ($character === '"' && !$inSingleQuote && $previous !== '\\') {
                $inDoubleQuote = !$inDoubleQuote;
            }

            if ($character === ';' && !$inSingleQuote && !$inDoubleQuote) {
                $statements[] = $statement;
                $statement = '';
                continue;
            }

            $statement .= $character;
        }

        if (trim($statement) !== '') {
            $statements[] = $statement;
        }

        return $statements;
    }
}
