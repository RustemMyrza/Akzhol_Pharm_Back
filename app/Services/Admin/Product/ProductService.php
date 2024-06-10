<?php

namespace App\Services\Admin\Product;

use App\Models\Category;
use App\Models\Feature;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\SubCategory;
use App\Models\Translate;
use App\Services\Admin\Filter\FilterService;
use App\Services\Admin\Service;
use App\Services\FileService;
use App\Services\MediaTranslateService;
use App\Services\TranslateService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use OpenSpout\Common\Entity\Style\Style;
use OpenSpout\Common\Exception\InvalidArgumentException;
use ZipArchive;

class ProductService extends Service
{
    public FilterService $filterService;

    public function __construct(TranslateService      $translateService,
                                MediaTranslateService $mediaTranslateService,
                                FileService           $fileService,
                                FilterService         $filterService)
    {
        parent::__construct($translateService, $mediaTranslateService, $fileService);
        $this->filterService = $filterService;
    }

    public function getProducts(Request $request)
    {
        return [
            'categories' => cache()->remember('productCategories', Category::CACHE_TIME, function () {
                return Category::query()->withTranslations()->isActive()->get();
            }),
            'products' => Product::query()
                ->when($request->filled('search'), function ($query) use ($request) {
                    $keywords = explode(' ', $request->search);

                    $query->where(function ($subQuery) use ($keywords) {
                        foreach ($keywords as $keyword) {
                            $subQuery->where('id', 'like', "%$keyword%")
                                ->orWhere('vendor_code', 'like', "%$keyword%");

                            $subQuery->orWhereHas('titleTranslate', function ($titleQuery) use ($keyword) {
                                foreach (Translate::LANGUAGES as $language) {
                                    $titleQuery->where("$language", 'like', "%$keyword%");
                                }
                            });

                            $subQuery->orWhereHas('descriptionTranslate', function ($descriptionQuery) use ($keyword) {
                                foreach (Translate::LANGUAGES as $language) {
                                    $descriptionQuery->where($language, 'like', "%$keyword%");
                                }
                            });
                        }
                    });
                })
                ->when($request->filled('category_id'), function ($query) use ($request) {
                    $query->where('category_id', '=', $request->input('category_id'));
                })
                ->withTranslations()
                ->paginate()
        ];
    }

    public function getDefaultData(): array
    {
        return [
            'categories' => cache()->remember('productCategories', Category::CACHE_TIME, function () {
                return Category::query()->withTranslations()->isActive()->get();
            }),
            'subCategories' => [],
            'features' => cache()->remember('productFeatures', Feature::CACHE_TIME, function () {
                return Feature::query()->withTranslations()->with(['featureItems.titleTranslate'])->isActive()->get();
            }),
            'statuses' => Product::statuses(),
            'lastPosition' => Product::lastPosition(),
            'filters' => $this->filterService->getFiltersByCategoryId(Category::firstCategoryId())
        ];
    }

    public function create(array $data)
    {
        $product = Product::query()
            ->create([
                'title' => $this->translateService->createTranslate($data['title']),
                'description' => $data['description'] ? $this->translateService->createTranslate($data['description']) : null,
                'instruction' => $data['instruction'] ? $this->translateService->createTranslate($data['instruction']) : null,
                'vendor_code' => $data['vendor_code'],
                'category_id' => $data['category_id'] ?? null,
                'sub_category_id' => $data['sub_category_id'] ?? null,
                'is_active' => $data['is_active'] ?? 0,
                'price' => $data['price'],
                'bulk_price' => $data['bulk_price'] ?? 0,
                'stock_quantity' => $data['stock_quantity'] ?? 0,
                'discount' => $data['discount'],
                'status' => $data['status'],
                'position' => $data['position'] ?? Product::lastPosition(),
                'image' => isset($data['image']) ? $this->fileService->saveFile($data['image'], Product::IMAGE_PATH) : null,
//                'feature_image' => isset($data['feature_image']) ? $this->fileService->saveFile($data['feature_image'], Product::IMAGE_PATH) : null,
                'document' => isset($data['document']) ? $this->fileService->saveFile($data['document'], Product::DOCUMENT_PATH) : null,
            ]);

        if (isset($data['product_filter_items'])) {
            $product->productFilterItems()?->sync($data['product_filter_items']);
        }

        if (isset($data['product_feature_items'])) {
            $product->productFeatureItems()?->sync($data['product_feature_items']);
        }

        return $product;
    }

    public function update(Product $product, array $data)
    {
        if ($product->title) {
            $product->title = $this->translateService->updateTranslate($product->title, $data['title']);
        } else {
            $product->title = $this->translateService->createTranslate($data['title']);
        }

        if ($product->description) {
            $this->translateService->updateTranslate($product->description, $data['description']);
        } else {
            $product->description = $this->translateService->createTranslate($data['description']);
        }

        if ($product->instruction) {
            $this->translateService->updateTranslate($product->instruction, $data['instruction']);
        } else {
            $product->instruction = $this->translateService->createTranslate($data['instruction']);
        }

//        if ($product->specification_table) {
//            $this->translateService->updateTranslate($product->specification_table, $data['specification_table']);
//        } else {
//            $product->specification_table = $this->translateService->createTranslate($data['specification_table']);
//        }

        $product->vendor_code = $data['vendor_code'];
        $product->category_id = $data['category_id'] ?? null;
        $product->sub_category_id = $data['sub_category_id'] ?? null;
        $product->status = $data['status'] ?? 0;
        $product->is_active = $data['is_active'] ?? 0;
        $product->position = $data['position'] ?? Product::lastPosition();

        $product->price = $data['price'];
        $product->discount = $data['discount'] ?? 0;
//      $product->bulk_price = $data['bulk_price'] ?? 0;
//      $product->stock_quantity = $data['stock_quantity'] ?? 0;

//        $product->collapsible_diagram = $this->getFilteredCollapsibleDiagram($data['collapsible_diagram'], (array)$product->collapsible_diagram);

        if (isset($data['image'])) {
            $product->image = $this->fileService->saveFile($data['image'], Product::IMAGE_PATH, $product->image);
        }

//      if (isset($data['feature_image'])) {
//          $product->feature_image = $this->fileService->saveFile($data['feature_image'], Product::IMAGE_PATH, $product->feature_image);
//      }

//        if (isset($data['size_image'])) {
//            $product->size_image = $this->fileService->saveFile($data['size_image'], Product::IMAGE_PATH, $product->size_image);
//        }

//        if (isset($data['installation_image'])) {
//            $product->installation_image = $this->fileService->saveFile($data['installation_image'], Product::IMAGE_PATH, $product->installation_image);
//        }

        if (isset($data['document'])) {
            $product->document = $this->fileService->saveFile($data['document'], Product::DOCUMENT_PATH, $product->document);
        }

        if (isset($data['product_filter_items'])) {
            $product->productFilterItems()->sync($data['product_filter_items']);
        } else {
            $product->productFilterItems()->sync([]);
        }

        if (isset($data['product_feature_items'])) {
            $product->productFeatureItems()->sync($data['product_feature_items']);
        } else {
            $product->productFeatureItems()->sync([]);
        }

        return $product->save();
    }

//    private function getFilteredCollapsibleDiagram(array $collapsibleDiagram, array $oldCollapsibleDiagram): array
//    {
//        foreach ($collapsibleDiagram as $language => $item) {
//            if (isset($item['image'])) {
//                if (!empty($oldCollapsibleDiagram[$language]['image'])) {
//                    $this->fileService->deleteFile($oldCollapsibleDiagram[$item]['image'], Product::IMAGE_PATH);
//                }
//                $oldCollapsibleDiagram[$language]['image'] = $this->fileService->saveFile($item['image'], Product::IMAGE_PATH);
//            } else {
//                $oldCollapsibleDiagram[$language]['image'] = $oldCollapsibleDiagram[$language]['image'] ?? null;
//            }
//            $oldCollapsibleDiagram[$language]['table'] = $item['table'];
//        }
//        return $oldCollapsibleDiagram;
//    }

    public function delete(Product $product)
    {
        $product->titleTranslate?->delete();
        $product->descriptionTranslate?->delete();
        $product->instructionTranslate?->delete();
        $product->metaTitleTranslate?->delete();
        $product->metaDescriptionTranslate?->delete();
        $product->metaKeywordTranslate?->delete();

        if ($product->image != null) {
            $this->fileService->deleteFile($product->image, Product::IMAGE_PATH);
        }
        if ($product->document != null) {
            $this->fileService->deleteFile($product->document, Product::DOCUMENT_PATH);
        }
//        if ($product->feature_image != null) {
//            $this->fileService->deleteFile($product->feature_image, Product::IMAGE_PATH);
//        }
        foreach ($product->productImages as $productImage) {
            $this->fileService->deleteFile($productImage->image, ProductImage::IMAGE_PATH);
            $productImage->delete();
        }
        $product->productFilterItems()?->sync([]);
        $product->productFeatureItems()?->sync([]);
        return $product->delete();
    }

    public function updateSeo(Product $product, array $data)
    {
        if ($product->meta_title) {
            $this->translateService->updateTranslate($product->meta_title, $data['meta_title']);
        } else {
            $product->meta_title = $this->translateService->createTranslate($data['meta_title']);
        }

        if ($product->meta_description) {
            $this->translateService->updateTranslate($product->meta_description, $data['meta_description']);
        } else {
            $product->meta_description = $this->translateService->createTranslate($data['meta_description']);
        }

        if ($product->meta_keyword) {
            $this->translateService->updateTranslate($product->meta_keyword, $data['meta_keyword']);
        } else {
            $product->meta_keyword = $this->translateService->createTranslate($data['meta_keyword']);
        }

        return $product->save();
    }

    function productsGenerator()
    {
        $products = Product::query()
            ->withTranslations()
            ->with(['category.titleTranslate'])
            ->get();

        foreach ($products as $product) {
            yield [
                'Загаловок' => $product->titleTranslate?->ru,
                'Артикул' => $product->vendor_code,
                'Цена в розницу' => $product->price,
                'Скидка' => $product->discount,
//                'Цена оптом' => $product->bulk_price,
//                'Количество на складе' => $product->stock_quantity,
                'Статус на складе' => $product->status_name,
                'Категорий' => $product->category?->titleTranslate?->ru ?? '-',
                'Подкатегорий' => $product->subCategory?->titleTranslate?->ru ?? '-',
            ];
        }
    }

    /**
     * @throws InvalidArgumentException
     */
    public function headerStyles()
    {
        return (new Style())
            ->setFontSize(11)
            ->setCellAlignment('left')
            ->setShouldWrapText(false)
            ->setCellVerticalAlignment('center')
            ->setFontBold();
    }

    /**
     * @throws InvalidArgumentException
     */
    public function rowsStyles()
    {
        return (new Style())
            ->setFontSize(11)
            ->setCellAlignment('left')
            ->setCellVerticalAlignment('center')
            ->setShouldWrapText(false);
    }

    public function getProduct(Product $product)
    {
        return array_merge($this->getDefaultData(), [
            'product' => $product->load('titleTranslate', 'descriptionTranslate', 'instructionTranslate'),
            'subCategories' => $product->category_id
                ? $this->getSubCategoriesByCategoryId($product->category_id)
                : [],
            'filters' => $product->category_id ? $this->filterService->getFiltersByCategoryId($product->category_id) : [],
            'productFilterItems' => $product->productFilterItems?->pluck('id')->toArray(),
            'productFeatureItems' => $product->productFeatureItems?->pluck('id')->toArray()
        ]);
    }

    public function getSubCategories(Request $request)
    {
        return [
            'subCategories' => $request->filled('category_id')
                ? $this->getSubCategoriesByCategoryId($request->category_id)
                : []
        ];
    }

    public function getSubCategoriesByCategoryId(int $categoryId)
    {
        return SubCategory::query()
            ->where('category_id', '=', $categoryId)
            ->withTranslations()
            ->isActive()
            ->get();
    }

    public function getFiltersData(Request $request)
    {
        return [
            'filters' => $request->filled('category_id')
                ? $this->filterService->getFiltersByCategoryId($request->category_id)
                : []
        ];
    }

    public function importProducts(array $excelFields)
    {
        $lineCount = 0;
        $creatingCount = 0;
        $updatingCount = 0;
        $errorsCount = 0;
        $errorRows = [];
        $errorLine = '';

        foreach ($excelFields as $excelField) {
            try {
                $find = Product::query()
                    ->where('vendor_code', '=', trim($excelField['Артикул']))
                    ->with(['titleTranslate', 'descriptionTranslate', 'instructionTranslate', 'productFeatureItems', 'productFilterItems'])
                    ->first();

                if ($find) {
                    $find->update([
                        'price' => trim($excelField['Цена в розницу']),
                        'discount' => trim($excelField['Скидка']),
//                        'bulk_price' => trim($excelField['Цена оптом']),
//                        'stock_quantity' => trim($excelField['Количество на складе']),
                        'status' => trim($excelField['Статус на складе']),
                        'category_id' => trim($excelField['ID Категории']),
                        'sub_category_id' => !empty(trim($excelField['ID Подкатегории'])) ? trim($excelField['ID Подкатегории']) : null,
                    ]);

                    $find->productFilterItems()->sync($this->getIds($excelField['ID Фильтра'] ?? null) ?? []);
                    $find->productFeatureItems()->sync($this->getIds($excelField['ID Характеристики товара'] ?? null) ?? []);

                    if ($find->title) {
                        $find->title = $this->translateService->updateTranslate($find->title, [
                            'ru' => trim($excelField['Загаловок ru']),
                            'en' => trim($excelField['Загаловок en']),
                        ]);
                    } else {
                        $find->title = $this->translateService->createTranslate([
                            'ru' => trim($excelField['Загаловок ru']),
                            'en' => trim($excelField['Загаловок en']),
                        ]);
                    }

                    if ($find->description) {
                        $this->translateService->updateTranslate($find->description, [
                            'ru' => trim($excelField['Описание ru']),
                            'en' => trim($excelField['Описание en']),
                        ]);
                    } else {
                        $find->description = $this->translateService->createTranslate([
                            'ru' => trim($excelField['Описание ru']),
                            'en' => trim($excelField['Описание en']),
                        ]);
                    }

                    if ($find->instruction) {
//                        $this->translateService->updateTranslate($find->instruction, [
//                            'ru' => trim($excelField['Инструкция ru']),
//                            'en' => trim($excelField['Инструкция en']),
//                            'ru' => '',
//                            'en' => '',
//                        ]);
                    } else {
                        $find->instruction = $this->translateService->createTranslate([
//                            'ru' => trim($excelField['Инструкция ru']),
//                            'en' => trim($excelField['Инструкция en']),
                            'ru' => '',
                            'en' => '',
                        ]);
                    }

                    $updatingCount++;
                } else {
                    $title = [
                        'ru' => trim($excelField['Загаловок ru']) ?? null,
                        'en' => trim($excelField['Загаловок en']) ?? null,
                    ];

                    $description = [
                        'ru' => trim($excelField['Описание ru']) ?? null,
                        'en' => trim($excelField['Описание en']) ?? null,
                    ];

                    $instruction = [
//                        'ru' => trim($excelField['Инструкция ru']) ?? null,
//                        'en' => trim($excelField['Инструкция en']) ?? null,

                        'ru' => '',
                        'en' => '',
                    ];

                    $product = Product::query()
                        ->create([
                            'title' => $this->translateService->createTranslate($title),
                            'description' => $this->translateService->createTranslate($description),
                            'instruction' => $this->translateService->createTranslate($instruction),
                            'vendor_code' => trim($excelField['Артикул']),
                            'price' => trim($excelField['Цена в розницу']),
                            'discount' => trim($excelField['Скидка']),
//                            'bulk_price' => trim($excelField['Цена оптом']),
//                            'stock_quantity' => trim($excelField['Количество на складе']),
                            'status' => trim($excelField['Статус на складе']),
                            'category_id' => trim($excelField['ID Категории']),
                            'sub_category_id' => !empty(trim($excelField['ID Подкатегории'])) ? trim($excelField['ID Подкатегории']) : null,
                        ]);

                    $product->productFilterItems()->sync($this->getIds($excelField['ID Фильтра']) ?? []);
                    $product->productFeatureItems()->sync($this->getIds($excelField['ID Характеристики товара']) ?? []);

                    $creatingCount++;
                }
                unset($find);
                unset($excelField);
                $lineCount++;
            } catch (\Exception $exception) {
                throw new Exception($exception->getMessage());
                $errorsCount++;
                $errorRows[] = trim($excelField['Артикул']);
                unset($excelField);
            }
        }

        if (count($errorRows)) {
            $errorLine = implode(', ', $errorRows);
        }

        return [
            'success_import' => trans('messages.success_created'),
            'lineCount' => $lineCount,
            'creatingCount' => $creatingCount,
            'updatingCount' => $updatingCount,
            'errorsCount' => $errorsCount,
            'errorLine' => $errorLine,
        ];
    }

    private function getIds(?string $filed)
    {
        return !empty(trim($filed)) ? explode(',', trim($filed)) : null;
    }

    /**
     * @throws Exception
     */
    public function deleteImage(Product $product, array $request)
    {
        if (!isset($request['type_image']) && is_null($request['type_image'])) {
            throw new Exception('Тип не найдено!');
        }

//        if ($request['type_image'] == 'collapsible_diagram') {
//            $language = $request['language'];
//            $languageData = (array)$product->collapsible_diagram;
//            $this->fileService->deleteFile($languageData[$language]['image'], Product::IMAGE_PATH);
//
//            $languageData[$language]['image'] = null;
//
//            $product->collapsible_diagram = $languageData;
//            return $product->save();
//        }

        $this->fileService->deleteFile($product->{$request['type_image']}, Product::IMAGE_PATH);
        return $product->update([$request['type_image'] => null]);
    }

    public function deleteDocument(Product $product)
    {
        if (!is_null($product->document)) {
            $this->fileService->deleteFile($product->document, Product::DOCUMENT_PATH);

            $product->document = null;
            return $product->save();
        }
        return 0;
    }

    /**
     * @throws \Exception
     */
    public function importProductImages(object $zipDocument)
    {
        $lineCount = 0;
        $creatingCount = 0;
        $updatingCount = 0;
        $errorsCount = 0;
        $errorRows = [];
        $errorLine = '';
        $tempExtractPath = storage_path('app/public/zip/');
        $uploadProductPath = public_path('uploads/' . Product::IMAGE_PATH . '/');
        $uploadProductImagePath = public_path('uploads/' . ProductImage::IMAGE_PATH . '/');

        $zipArchive = new ZipArchive;

        if (!$zipArchive->open($zipDocument->getRealPath())) {
            throw new Exception('Недействительный ZIP');
        }

        if ($zipArchive->numFiles > 0) {
            for ($index = 0; $index < $zipArchive->numFiles; $index++) {
                $file = $zipArchive->getNameIndex($index);
                $fileExtension = pathinfo($file)['extension'];

                if (isImageFile($fileExtension)) {
                    $vendorCode = getVendorCode($file);
                    $zipArchive->extractTo($tempExtractPath, $file);

                    $product = Product::query()->where('vendor_code', '=', $vendorCode)->first();
                    if ($product) {
                        $fileName = Str::random(28) . '.' . $fileExtension;

                        if (!str_contains($file, '_')) {
                            rename($tempExtractPath . $file, $uploadProductPath . $fileName);
                            if ($product->image != null) {
                                $this->fileService->deleteFile($product->image, Product::IMAGE_PATH);
                            }
                            $product->image = $fileName;
                            $product->save();
                            $updatingCount++;
                        } else {
                            rename($tempExtractPath . $file, $uploadProductImagePath . $fileName);
                            ProductImage::query()
                                ->create([
                                    'product_id' => $product->id,
                                    'position' => ProductImage::lastPosition(),
                                    'image' => $fileName
                                ]);
                            $creatingCount++;
                        }

                        unset($product);
                        $lineCount++;
                    } else {
                        $errorsCount++;
                        $errorRows[] = trim($file);
                    }
                }
                $zipArchive->extractTo($tempExtractPath, $file);
            }
            $zipArchive->close();
        }

        if (count($errorRows)) {
            $errorLine = implode(', ', $errorRows);
        }

        return [
            'success_import' => trans('messages.success_created'),
            'lineCount' => $lineCount,
            'creatingCount' => $creatingCount,
            'updatingCount' => $updatingCount,
            'errorsCount' => $errorsCount,
            'errorLine' => $errorLine,
        ];
    }

    /**
     * @throws \Exception
     */
    public function importProductDocuments(object $zipDocument)
    {
        $lineCount = 0;
        $creatingCount = 0;
        $updatingCount = 0;
        $errorsCount = 0;
        $errorRows = [];
        $errorLine = '';
        $tempExtractPath = storage_path('app/public/zip/files/');
        $uploadProductPath = public_path('uploads/' . Product::DOCUMENT_PATH . '/');
//        $uploadProductDocumentPath = public_path('uploads/' . Product::DOCUMENT_PATH . '/');

        $zipArchive = new ZipArchive;

        if (!$zipArchive->open($zipDocument->getRealPath())) {
            throw new Exception('Недействительный ZIP');
        }

        if ($zipArchive->numFiles > 0) {
            for ($index = 0; $index < $zipArchive->numFiles; $index++) {
                $file = $zipArchive->getNameIndex($index);
                $fileExtension = pathinfo($file)['extension'];

                if ($this->isDocumentFile($fileExtension)) {
                    $vendorCode = $this->getDocumentVendorCode($file);
                    $zipArchive->extractTo($tempExtractPath, $file);

                    $product = Product::query()->where('vendor_code', '=', $vendorCode)->first();

                    if ($product) {
                        $fileName = Str::random(28) . '.' . $fileExtension;

                        if (!str_contains($file, '_')) {

                            rename($tempExtractPath . $file, $uploadProductPath . $fileName);
                            if ($product->document != null) {
                                $this->fileService->deleteFile($product->document, Product::DOCUMENT_PATH);
                            }
                            $product->document = $fileName;
                            $product->save();
                            $updatingCount++;
                        }

//                        else {
//                            rename($tempExtractPath . $file, $uploadProductImagePath . $fileName);
//                            ProductImage::query()
//                                ->create([
//                                    'product_id' => $product->id,
//                                    'position' => ProductImage::lastPosition(),
//                                    'image' => $fileName
//                                ]);
//                            $creatingCount++;
//                        }

                        unset($product);
                        $lineCount++;
                    } else {
                        $errorsCount++;
                        $errorRows[] = trim($file);
                    }
                }
                $zipArchive->extractTo($tempExtractPath, $file);
            }
            $zipArchive->close();
        }

        if (count($errorRows)) {
            $errorLine = implode(', ', $errorRows);
        }

        return [
            'success_import' => trans('messages.success_created'),
            'lineCount' => $lineCount,
            'creatingCount' => $creatingCount,
            'updatingCount' => $updatingCount,
            'errorsCount' => $errorsCount,
            'errorLine' => $errorLine,
        ];
    }

    function isDocumentFile(string $fileExtension): bool
    {
        $imageExtensions = ['pdf', 'docx', 'doc', 'pptx', 'ppt', 'xlsx', 'xlx'];
        return in_array(strtolower($fileExtension), $imageExtensions);
    }

    function getDocumentVendorCode(string $fileName): string
    {
        $patterns = ['/_.*/s', '/.pdf/s', '/.docx/s', '/.doc/s', '/.pptx/s', '/.ppt/s', '/.xlsx/s', '/.xlx/s'];
        return preg_replace($patterns, '', $fileName);
    }

    public function getImageUrl(string $image): ?string
    {
        return $image
            ? Storage::disk('custom')->url(Product::IMAGE_PATH . '/' . $image)
            : null;
    }

//    public function addDescriptionList(Product $product, array $request)
//    {
//        $language = $request['language'];
//        $productDescriptionLists = (array)$product->description_lists;
//
//        $descriptionLists[$language] = isset($product->description_lists[$language])
//            ? $product->description_lists[$language]
//            : [];
//        $descriptionList = [
//            'title' => $request['title'],
//            'text' => $request['text'],
//            'image' => isset($request['image'])
//                ? $this->fileService->saveFile($request['image'], Product::IMAGE_PATH)
//                : null
//        ];
//        $descriptionLists[$language][] = $descriptionList;
//
//        unset($productDescriptionLists[$language]);
//
//        $product->description_lists = array_merge($productDescriptionLists, $descriptionLists);
//        $product->save();
//
//        return array(
//            'language' => $language,
//            'descriptionLists' => $this->getLists($descriptionLists[$language])
//        );
//    }

//    public function updateDescriptionList(Product $product, array $request)
//    {
//        $language = $request['language'];
//        $key = $request['key'];
//        $productDescriptionLists = (array)$product->description_lists;
//
//        $descriptionLists[$language] = isset($product->description_lists[$language])
//            ? $product->description_lists[$language]
//            : [];
//
//        $descriptionList = $descriptionLists[$language][$key];
//        $descriptionLists[$language][$key] = [
//            'title' => $request['title'],
//            'text' => $request['text'],
//            'image' => isset($request['image'])
//                ? $this->fileService->saveFile($request['image'], Product::IMAGE_PATH, $descriptionList['image'])
//                : $descriptionList['image']
//        ];
//
//        unset($productDescriptionLists[$language]);
//
//        $product->description_lists = array_merge($productDescriptionLists, $descriptionLists);
//        $product->save();
//
//        return array(
//            'language' => $language,
//            'descriptionLists' => $this->getLists($descriptionLists[$language])
//        );
//    }


//    public function deleteDescriptionList(Product $product, array $request)
//    {
//        $language = $request['language'];
//        $key = $request['key'];
//        $productDescriptionLists = (array)$product->description_lists;
//
//        $descriptionLists[$language] = isset($product->description_lists[$language])
//            ? $product->description_lists[$language]
//            : [];
//
//        $descriptionList = $descriptionLists[$language][$key];
//        if ($descriptionList['image']) {
//            $this->fileService->deleteFile($descriptionList['image'], Product::IMAGE_PATH);
//        }
//
//        array_splice($descriptionLists[$language], $key, 1);
//
//        $product->description_lists = array_merge($productDescriptionLists, $descriptionLists);
//        $product->save();
//
//        return array(
//            'language' => $language,
//            'descriptionLists' => $this->getLists($descriptionLists[$language])
//        );
//    }

//    public function addInstructionList(Product $product, array $request)
//    {
//        $language = $request['language'];
//        $productInstructionLists = (array)$product->instruction_lists;
//
//        $instructionLists[$language] = isset($product->instruction_lists[$language])
//            ? $product->instruction_lists[$language]
//            : [];
//        $instructionList = [
//            'title' => $request['title'],
//            'text' => $request['text'],
//        ];
//        $instructionLists[$language][] = $instructionList;
//
//        unset($productInstructionLists[$language]);
//
//        $product->instruction_lists = array_merge($productInstructionLists, $instructionLists);
//        $product->save();
//
//        return array(
//            'language' => $language,
//            'instructionLists' => $this->getLists($instructionLists[$language])
//        );
//    }

//    public function updateInstructionList(Product $product, array $request)
//    {
//        $language = $request['language'];
//        $key = $request['key'];
//        $productInstructionLists = (array)$product->instruction_lists;
//
//        $instructionLists[$language] = isset($product->instruction_lists[$language])
//            ? $product->instruction_lists[$language]
//            : [];
//
//        $instructionLists[$language][$key] = [
//            'title' => $request['title'],
//            'text' => $request['text'],
//        ];
//
//        unset($productInstructionLists[$language]);
//
//        $product->instruction_lists = array_merge($productInstructionLists, $instructionLists);
//        $product->save();
//
//        return array(
//            'language' => $language,
//            'instructionLists' => $this->getLists($instructionLists[$language])
//        );
//    }

//    public function deleteInstructionList(Product $product, array $request)
//    {
//        $language = $request['language'];
//        $key = $request['key'];
//        $productInstructionLists = (array)$product->instruction_lists;
//
//        $instructionLists[$language] = isset($product->instruction_lists[$language])
//            ? $product->instruction_lists[$language]
//            : [];
//
//        array_splice($instructionLists[$language], $key, 1);
//
//        $product->instruction_lists = array_merge($productInstructionLists, $instructionLists);
//        $product->save();
//
//        return array(
//            'language' => $language,
//            'instructionLists' => $this->getLists($instructionLists[$language])
//        );
//    }

//    public function getLists(array $arrayLists)
//    {
//        return array_map(function ($item) {
//            if (isset($item['image'])) {
//                $item['image'] = !is_null($item['image']) ? $this->getImageUrl($item['image']) : null;
//            }
//            return $item;
//        }, $arrayLists);
//    }
}
