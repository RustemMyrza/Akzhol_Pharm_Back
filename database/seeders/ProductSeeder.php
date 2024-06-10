<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use App\Services\FileService;
use App\Services\TranslateService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    protected FileService $fileService;
    private TranslateService $translateService;

    public function __construct(FileService $fileService, TranslateService $translateService)
    {
        $this->translateService = $translateService;
        $this->fileService = $fileService;
    }

    public function run()
    {
        DB::beginTransaction();

        $imageMainPath = public_path('adminlte-assets/dist/img/products/');

        $products = [
            [
                'title' => [
                    'ru' => 'Лайнер для бассейна Aquaviva Danube',
                    'en' => 'Лайнер для бассейна Aquaviva Danube',
                ],
                'description' => [
                    'ru' => 'Lorem Ipsum - это текст-"рыба", часто используемый в печати и вэб-дизайне. Lorem Ipsum является стандартной "рыбой" для текстов на латинице с начала XVI века. В то время некий безымянный печатник создал большую коллекцию размеров и форм шрифтов, используя Lorem Ipsum для распечатки образцов. Lorem Ipsum не только успешно пережил без заметных изменений пять веков

Lorem Ipsum - это текст-"рыба", часто используемый в печати и вэб-дизайне. Lorem Ipsum является стандартной "рыбой" для текстов на латинице с начала XVI века. В то время некий безымянный печатник создал большую коллекцию размеров и форм шрифтов, используя Lorem Ipsum для распечатки образцов. Lorem Ipsum не только успешно пережил без заметных изменений пять веков

Lorem Ipsum - это текст-"рыба", часто используемый в печати и вэб-дизайне. Lorem Ipsum является стандартной "рыбой" для текстов на латинице с начала XVI века. В то время некий безымянный печатник создал большую коллекцию размеров и форм шрифтов, используя Lorem Ipsum для распечатки образцов. Lorem Ipsum не только успешно пережил без заметных изменений пять веков',
                    'en' => 'Lorem Ipsum - это текст-"рыба", часто используемый в печати и вэб-дизайне. Lorem Ipsum является стандартной "рыбой" для текстов на латинице с начала XVI века. В то время некий безымянный печатник создал большую коллекцию размеров и форм шрифтов, используя Lorem Ipsum для распечатки образцов. Lorem Ipsum не только успешно пережил без заметных изменений пять веков

Lorem Ipsum - это текст-"рыба", часто используемый в печати и вэб-дизайне. Lorem Ipsum является стандартной "рыбой" для текстов на латинице с начала XVI века. В то время некий безымянный печатник создал большую коллекцию размеров и форм шрифтов, используя Lorem Ipsum для распечатки образцов. Lorem Ipsum не только успешно пережил без заметных изменений пять веков

Lorem Ipsum - это текст-"рыба", часто используемый в печати и вэб-дизайне. Lorem Ipsum является стандартной "рыбой" для текстов на латинице с начала XVI века. В то время некий безымянный печатник создал большую коллекцию размеров и форм шрифтов, используя Lorem Ipsum для распечатки образцов. Lorem Ipsum не только успешно пережил без заметных изменений пять веков',
                ],
                'instruction' => [
                    'ru' => 'Lorem Ipsum - это текст-"рыба", часто используемый в печати и вэб-дизайне. Lorem Ipsum является стандартной "рыбой" для текстов на латинице с начала XVI века. В то время некий безымянный печатник создал большую коллекцию размеров и форм шрифтов, используя Lorem Ipsum для распечатки образцов. Lorem Ipsum не только успешно пережил без заметных изменений пять веков',
                    'en' => 'Lorem Ipsum - это текст-"рыба", часто используемый в печати и вэб-дизайне. Lorem Ipsum является стандартной "рыбой" для текстов на латинице с начала XVI века. В то время некий безымянный печатник создал большую коллекцию размеров и форм шрифтов, используя Lorem Ipsum для распечатки образцов. Lorem Ipsum не только успешно пережил без заметных изменений пять веков',
                ],
                'position' => 1,
                'vendor_code' => '2424',
                'category_id' => 1,
                'image' => $this->fileService->createUploadedFile($imageMainPath . 'product-image.png'),
                'images' => [
                    [
                        'image' => $this->fileService->createUploadedFile($imageMainPath . 'product-image.png'),
                        'position' => 1,
                    ],
                    [
                        'image' => $this->fileService->createUploadedFile($imageMainPath . 'product-image.png'),
                        'position' => 2,
                    ],
                    [
                        'image' => $this->fileService->createUploadedFile($imageMainPath . 'product-image.png'),
                        'position' => 3,
                    ]
                ],
                'price' => 10000,
                'bulk_price' => 9000,
                'stock_quantity' => 200,
            ],
            [
                'title' => [
                    'ru' => 'Лайнер для бассейна Aquaviva Danube',
                    'en' => 'Лайнер для бассейна Aquaviva Danube',
                ],
                'description' => [
                    'ru' => 'Lorem Ipsum - это текст-"рыба", часто используемый в печати и вэб-дизайне. Lorem Ipsum является стандартной "рыбой" для текстов на латинице с начала XVI века. В то время некий безымянный печатник создал большую коллекцию размеров и форм шрифтов, используя Lorem Ipsum для распечатки образцов. Lorem Ipsum не только успешно пережил без заметных изменений пять веков

Lorem Ipsum - это текст-"рыба", часто используемый в печати и вэб-дизайне. Lorem Ipsum является стандартной "рыбой" для текстов на латинице с начала XVI века. В то время некий безымянный печатник создал большую коллекцию размеров и форм шрифтов, используя Lorem Ipsum для распечатки образцов. Lorem Ipsum не только успешно пережил без заметных изменений пять веков

Lorem Ipsum - это текст-"рыба", часто используемый в печати и вэб-дизайне. Lorem Ipsum является стандартной "рыбой" для текстов на латинице с начала XVI века. В то время некий безымянный печатник создал большую коллекцию размеров и форм шрифтов, используя Lorem Ipsum для распечатки образцов. Lorem Ipsum не только успешно пережил без заметных изменений пять веков',
                    'en' => 'Lorem Ipsum - это текст-"рыба", часто используемый в печати и вэб-дизайне. Lorem Ipsum является стандартной "рыбой" для текстов на латинице с начала XVI века. В то время некий безымянный печатник создал большую коллекцию размеров и форм шрифтов, используя Lorem Ipsum для распечатки образцов. Lorem Ipsum не только успешно пережил без заметных изменений пять веков

Lorem Ipsum - это текст-"рыба", часто используемый в печати и вэб-дизайне. Lorem Ipsum является стандартной "рыбой" для текстов на латинице с начала XVI века. В то время некий безымянный печатник создал большую коллекцию размеров и форм шрифтов, используя Lorem Ipsum для распечатки образцов. Lorem Ipsum не только успешно пережил без заметных изменений пять веков

Lorem Ipsum - это текст-"рыба", часто используемый в печати и вэб-дизайне. Lorem Ipsum является стандартной "рыбой" для текстов на латинице с начала XVI века. В то время некий безымянный печатник создал большую коллекцию размеров и форм шрифтов, используя Lorem Ipsum для распечатки образцов. Lorem Ipsum не только успешно пережил без заметных изменений пять веков',
                ],
                'instruction' => [
                    'ru' => 'Lorem Ipsum - это текст-"рыба", часто используемый в печати и вэб-дизайне. Lorem Ipsum является стандартной "рыбой" для текстов на латинице с начала XVI века. В то время некий безымянный печатник создал большую коллекцию размеров и форм шрифтов, используя Lorem Ipsum для распечатки образцов. Lorem Ipsum не только успешно пережил без заметных изменений пять веков',
                    'en' => 'Lorem Ipsum - это текст-"рыба", часто используемый в печати и вэб-дизайне. Lorem Ipsum является стандартной "рыбой" для текстов на латинице с начала XVI века. В то время некий безымянный печатник создал большую коллекцию размеров и форм шрифтов, используя Lorem Ipsum для распечатки образцов. Lorem Ipsum не только успешно пережил без заметных изменений пять веков',
                ],
                'position' => 2,
                'category_id' => 2,
                'vendor_code' => '242424',
                'image' => $this->fileService->createUploadedFile($imageMainPath . 'product-image-2.png'),
                'images' => [
                    [
                        'image' => $this->fileService->createUploadedFile($imageMainPath . 'product-image-2.png'),
                        'position' => 1,
                    ],
                    [
                        'image' => $this->fileService->createUploadedFile($imageMainPath . 'product-image-2.png'),
                        'position' => 2,
                    ],
                    [
                        'image' => $this->fileService->createUploadedFile($imageMainPath . 'product-image-2.png'),
                        'position' => 3,
                    ]
                ],
                'price' => 12000,
                'bulk_price' => 10000,
                'stock_quantity' => 100,
            ],
        ];

        foreach ($products as $product) {
            $newProduct = Product::query()
                ->create([
                    'title' => $this->translateService->createTranslate($product['title']),
                    'description' => $this->translateService->createTranslate($product['description']),
                    'instruction' => $this->translateService->createTranslate($product['instruction']),
                    'image' => $this->fileService->saveFile($product['image'], Product::IMAGE_PATH),
                    'position' => $product['position'],
                    'category_id' => $product['category_id'],
                    'vendor_code' => $product['vendor_code'],
                    'price' => $product['price'],
                    'bulk_price' => $product['bulk_price'],
                    'stock_quantity' => $product['stock_quantity'],
                    'meta_title' => $this->translateService->createTranslate($product['title']),
                    'meta_description' => $this->translateService->createTranslate($product['title']),
                    'meta_keyword' => $this->translateService->createTranslate($product['title'])
                ]);

            foreach ($product['images'] as $productImage) {
                ProductImage::query()
                    ->create([
                        'product_id' => $newProduct->id,
                        'image' => $this->fileService->saveFile($productImage['image'], ProductImage::IMAGE_PATH),
                        'position' => $productImage['position']
                    ]);
                unset($productImage);
            }
            unset($product);
        }

        DB::commit();
    }
}
