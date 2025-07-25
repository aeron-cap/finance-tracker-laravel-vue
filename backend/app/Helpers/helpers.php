<?php

use Illuminate\Support\Facades\Schema;

if (!function_exists('auto_create')) {
    /**
     * Automatically create a model instance with fields that match table columns
     * 
     * @param string $modelClass The model class name
     * @param array $fields The input fields
     * @param array $additionalFields Additional fields to merge
     * @param array $excludeColumns Columns to exclude from auto-mapping
     * @return \Illuminate\Database\Eloquent\Model
     */
    function auto_create($modelClass, array $fields, array $additionalFields = [], array $excludeColumns = ['id', 'created_at', 'updated_at'])
    {
        $model = new $modelClass;
        $tableColumns = Schema::getColumnListing($model->getTable());
        
        // Remove excluded columns
        $allowedColumns = array_diff($tableColumns, $excludeColumns);
        
        // Filter fields to only include existing table columns
        $filteredFields = array_intersect_key($fields, array_flip($allowedColumns));
        
        // Merge with additional fields
        $allFields = array_merge($filteredFields, $additionalFields);

        // fill
        $model->fill($allFields);
        
        return $model;
    }
}

if (!function_exists('auto_update')) {
    /**
     * Automatically update a model instance with fields that match table columns
     * 
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param array $fields The input fields
     * @param array $excludeColumns Columns to exclude from auto-mapping
     * @return bool
     */
    function auto_update($model, array $fields, array $excludeColumns = ['id', 'created_at', 'updated_at'])
    {
        $tableColumns = Schema::getColumnListing($model->getTable());
        
        // Remove excluded columns
        $allowedColumns = array_diff($tableColumns, $excludeColumns);
        
        // Filter fields to only include existing table columns
        $filteredFields = array_intersect_key($fields, array_flip($allowedColumns));

        $model->fill($filteredFields);

        return $model;
    }
}
