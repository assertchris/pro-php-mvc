<?php

namespace Framework\Database\Migration;

use Framework\Database\Connection\SqliteConnection;
use Framework\Database\Exception\MigrationException;
use Framework\Database\Migration\Field\Field;
use Framework\Database\Migration\Field\BoolField;
use Framework\Database\Migration\Field\DateTimeField;
use Framework\Database\Migration\Field\FloatField;
use Framework\Database\Migration\Field\IdField;
use Framework\Database\Migration\Field\IntField;
use Framework\Database\Migration\Field\StringField;
use Framework\Database\Migration\Field\TextField;

class SqliteMigration extends Migration
{
    protected SqliteConnection $connection;
    protected string $table;
    protected string $type;

    public function __construct(SqliteConnection $connection, string $table, string $type)
    {
        $this->connection = $connection;
        $this->table = $table;
        $this->type = $type;
    }

    public function execute()
    {
        $command = $this->type === 'create' ? 'CREATE TABLE' : 'ALTER TABLE';

        $fields = array_map(fn($field) => $this->stringForField($field), $this->fields);
        $fields = join(',' . PHP_EOL, $fields);

        $query = "
            {$command} \"{$this->table}\" (
                {$fields}
            );
        ";

        $statement = $this->connection->pdo()->prepare($query);
        $statement->execute();
    }

    private function stringForField(Field $field): string
    {
        if ($field instanceof BoolField) {
            $template = "\"{$field->name}\" INTEGER";

            if (!$field->nullable) {
                $template .= " NOT NULL";
            }
            
            if ($field->default !== null) {
                $default = (int) $field->default;
                $template .= " DEFAULT {$default}";
            }

            return $template;
        }

        if ($field instanceof DateTimeField) {
            $template = "`{$field->name}` TEXT";

            if (!$field->nullable) {
                $template .= " NOT NULL";
            }
            
            if ($field->default === 'CURRENT_TIMESTAMP') {
                $template .= " DEFAULT CURRENT_TIMESTAMP";
            } else if ($field->default !== null) {
                $template .= " DEFAULT '{$field->default}'";
            }

            return $template;
        }

        if ($field instanceof FloatField) {
            $template = "`{$field->name}` REAL";

            if (!$field->nullable) {
                $template .= " NOT NULL";
            }
            
            if ($field->default !== null) {
                $template .= " DEFAULT {$field->default}";
            }

            return $template;
        }

        if ($field instanceof IdField) {
            return "`{$field->name}` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE";
        }

        if ($field instanceof IntField) {
            $template = "`{$field->name}` INTEGER";

            if (!$field->nullable) {
                $template .= " NOT NULL";
            }
            
            if ($field->default !== null) {
                $template .= " DEFAULT {$field->default}";
            }

            return $template;
        }

        if ($field instanceof StringField || $field instanceof TextField) {
            $template = "`{$field->name}` TEXT";

            if (!$field->nullable) {
                $template .= " NOT NULL";    
            }
            
            if ($field->default !== null) {
                $template .= " DEFAULT '{$field->default}'";    
            }

            return $template;
        }

        throw new MigrationException("Unrecognised field type for {$field->name}");
    }
}
