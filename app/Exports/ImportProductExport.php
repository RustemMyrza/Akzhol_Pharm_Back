<?php

namespace App\Exports;

use App\Exports\Sheets\FeatureSheet;
use App\Exports\Sheets\FilterSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\Sheets\ProductsSheet;
use App\Exports\Sheets\CategoriesSheet;

class ImportProductExport implements WithMultipleSheets
{
    use Exportable;

    public function sheets(): array
    {
        return [
            'products' => new ProductsSheet(),
            'categories' => new CategoriesSheet(),
            'filters' => new FilterSheet(),
            'features' => new FeatureSheet(),
        ];
    }
}
