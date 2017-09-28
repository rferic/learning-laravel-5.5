<?php

namespace App\Http\Helpers;

class CategoryHelper
{
    public static function showCategories ($categories, $label)
    {
        $data = [];

        if (COUNT($categories))
        {
            foreach ($categories AS $category)
            {
                array_push($data, $category->name);
            }
        }

        if (!empty($data))
        {
            return sprintf('%s: %s:', $label, join(', ', $data));
        }
    }
}
