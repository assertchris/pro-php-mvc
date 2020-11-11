<?php

namespace Framework\Database\Migration;

use Framework\Database\Connection\MysqlConnection;
use Framework\Database\Exception\MigrationException;
use Framework\Database\Migration\Field\Field;
use Framework\Database\Migration\Field\BoolField;
use Framework\Database\Migration\Field\DateTimeField;
use Framework\Database\Migration\Field\FloatField;
use Framework\Database\Migration\Field\IdField;
use Framework\Database\Migration\Field\IntField;
use Framework\Database\Migration\Field\StringField;
use Framework\Database\Migration\Field\TextField;

class MysqlMigration extends Migration
{
    protected MysqlConnection $connection;
    protected string $table;
    protected string $type;

    public function __construct(MysqlConnection $connection, string $table, string $type)
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

        $primary = array_filter($this->fields, fn($field) => $field instanceof IdField);
        $primaryKey = isset($primary[0]) ? "PRIMARY KEY (`{$primary[0]->name}`)" : '';

        $query = "
            {$command} `{$this->table}` (
                {$fields},
                {$primaryKey}
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
        ";

        $statement = $this->connection->pdo()->prepare($query);
        $statement->execute();
    }

    private function stringForField(Field $field): string
    {
        if ($field instanceof BoolField) {
            $template = "`{$field->name}` tinyint(4)";

            if ($field->nullable) {
                $template .= " DEFAULT NULL";
            }
            
            if ($field->default !== null) {
                $default = (int) $field->default;
                $template .= " DEFAULT {$default}";
            }

            return $template;
        }

        if ($field instanceof DateTimeField) {
            $template = "`{$field->name}` datetime";

            if ($field->nullable) {
                $template .= " DEFAULT NULL";
            }
            
            if ($field->default === 'CURRENT_TIMESTAMP') {
                $template .= " DEFAULT CURRENT_TIMESTAMP";
            } else if ($field->default !== null) {
                $template .= " DEFAULT '{$field->default}'";
            }

            return $template;
        }

        if ($field instanceof FloatField) {
            $template = "`{$field->name}` float";

            if ($field->nullable) {
                $template .= " DEFAULT NULL";
            }
            
            if ($field->default !== null) {
                $template .= " DEFAULT '{$field->default}'";
            }

            return $template;
        }

        if ($field instanceof IdField) {
            return "`{$field->name}` int(11) unsigned NOT NULL AUTO_INCREMENT";
        }

        if ($field instanceof IntField) {
            $template = "`{$field->name}` int(11)";

            if ($field->nullable) {
                $template .= " DEFAULT NULL";
            }
            
            if ($field->default !== null) {
                $template .= " DEFAULT '{$field->default}'";
            }

            return $template;
        }

        if ($field instanceof StringField) {
            $template = "`{$field->name}` varchar(255)";

            if ($field->nullable) {
                $template .= " DEFAULT NULL";    
            }
            
            if ($field->default !== null) {
                $template .= " DEFAULT '{$field->default}'";    
            }

            return $template;
        }

        if ($field instanceof TextField) {
            return "`{$field->name}` text";
        }

        throw new MigrationException("Unrecognised field type for {$field->name}");
    }
}
