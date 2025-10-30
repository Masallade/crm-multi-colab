<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DatabaseContextService
{
    /**
     * Execute a SQL query safely (only SELECT statements allowed)
     */
    public static function executeQuery($sql)
    {
        try {
            // Only allow SELECT statements for security
            if (!preg_match('/^\s*SELECT\s+/i', trim($sql))) {
                return [
                    'success' => false,
                    'error' => 'Only SELECT queries are allowed for security reasons.'
                ];
            }

            // Additional security checks
            $forbiddenKeywords = [
                'INSERT', 'UPDATE', 'DELETE', 'DROP', 'CREATE', 'ALTER', 
                'TRUNCATE', 'REPLACE', 'LOAD_FILE', 'INTO OUTFILE', 'INTO DUMPFILE'
            ];

            foreach ($forbiddenKeywords as $keyword) {
                if (stripos($sql, $keyword) !== false) {
                    return [
                        'success' => false,
                        'error' => "Query contains forbidden keyword: {$keyword}"
                    ];
                }
            }

            $results = DB::select($sql);
            
            return [
                'success' => true,
                'data' => $results,
                'count' => count($results)
            ];
        } catch (\Exception $e) {
            Log::error('Database query error: ' . $e->getMessage());
            Log::error('SQL Query: ' . $sql);
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Get table structure information
     */
    public static function getTableStructure($tableName)
    {
        try {
            $columns = DB::select("DESCRIBE {$tableName}");
            return $columns;
        } catch (\Exception $e) {
            Log::error('Error getting table structure for ' . $tableName . ': ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Get sample data from a table
     */
    public static function getSampleData($tableName, $limit = 5)
    {
        try {
            $data = DB::select("SELECT * FROM {$tableName} LIMIT {$limit}");
            return $data;
        } catch (\Exception $e) {
            Log::error('Error getting sample data for ' . $tableName . ': ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Get database context for AHHAM
     */
    public static function getDatabaseContext()
    {
        $tables = ['attendances', 'employees', 'office_shifts'];
        $context = [];

        foreach ($tables as $table) {
            $context[$table] = [
                'structure' => self::getTableStructure($table),
                'sample_data' => self::getSampleData($table, 3)
            ];
        }

        return $context;
    }

    /**
     * Validate SQL query before execution
     */
    public static function validateQuery($sql)
    {
        $sql = trim($sql);
        
        // Must start with SELECT
        if (!preg_match('/^\s*SELECT\s+/i', $sql)) {
            return false;
        }

        // Check for forbidden keywords
        $forbiddenKeywords = [
            'INSERT', 'UPDATE', 'DELETE', 'DROP', 'CREATE', 'ALTER', 
            'TRUNCATE', 'REPLACE', 'LOAD_FILE', 'INTO OUTFILE', 'INTO DUMPFILE',
            'EXEC', 'EXECUTE', 'CALL', 'PROCEDURE', 'FUNCTION'
        ];

        foreach ($forbiddenKeywords as $keyword) {
            if (stripos($sql, $keyword) !== false) {
                return false;
            }
        }

        return true;
    }
}

