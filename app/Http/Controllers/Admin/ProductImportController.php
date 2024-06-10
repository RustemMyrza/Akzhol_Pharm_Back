<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ImportProductExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\ImportProductImageRequest;
use App\Http\Requests\Admin\Product\ImportProductRequest;
use App\Models\Product;
use App\Services\Admin\Product\ProductService;
use Rap2hpoutre\FastExcel\FastExcel;

class ProductImportController extends Controller
{
    public ProductService $service;

    public function __construct(ProductService $productService)
    {
        $this->service = $productService;
    }

    public function import(ImportProductRequest $request)
    {
        try {
            $excelFields = (new FastExcel)->import($request->file('document'))->toArray();

            if (!count($excelFields)) {
                return backPageError('Excel не корректно');
            }

            $data = $this->service->importProducts($excelFields);

            notify()->success('', trans('messages.success_created'));
            return back()->with($data);
        } catch (\Exception $exception) {
            return backPageError($exception->getMessage());
        }
    }

    public function importImages(ImportProductImageRequest $request)
    {
        try {
            $data = $this->service->importProductImages($request->file('document'));
            notify()->success('', trans('messages.success_created'));
            return back()->with($data);
        } catch (\Exception $exception) {
            return back()->withErrors($exception->getMessage());
        }
    }

    public function importDocuments(ImportProductImageRequest $request)
    {
        try {
            $data = $this->service->importProductDocuments($request->file('document'));
            notify()->success('', trans('messages.success_created'));
            return back()->with($data);
        } catch (\Exception $exception) {
            return back()->withErrors($exception->getMessage());
        }
    }

    public function export()
    {
        try {
            return (new FastExcel($this->service->productsGenerator()))
                ->headerStyle($this->service->headerStyles())
                ->rowsStyle($this->service->rowsStyles())
                ->configureOptionsUsing(function ($writer) {
                    $writer->setColumnWidth(16, 2, 3, 4, 5, 7);
                    $writer->setColumnWidth(20, 6, 8);
                    $writer->setColumnWidth(35, 1);
                })
                ->download('Товары.xlsx');
        } catch (\Exception $exception) {
            return back()->withErrors($exception->getMessage());
        }
    }

    public function importExample()
    {
        try {
            if (Product::query()->count() == 0) {
                return backPageError('Товаров нет!');
            }
            return (new ImportProductExport())->download('Пример импорт товары.xlsx');
        } catch (\Exception $exception) {
            return back()->withInput()->withErrors($exception->getMessage());
        }
    }
}
