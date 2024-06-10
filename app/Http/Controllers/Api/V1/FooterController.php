<?php

namespace App\Http\Controllers\Api\V1;

use App\Exceptions\ApiErrorException;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\AgreementResource;
use App\Http\Resources\V1\FooterCategoryResource;
use App\Http\Resources\V1\FooterContactResource;
use App\Http\Resources\V1\MenuResource;
use App\Http\Resources\V1\SocialResource;
use App\Models\Agreement;
use App\Models\Category;
use App\Models\Contact;
use App\Models\SeoPage;
use App\Models\Social;
use Illuminate\Http\JsonResponse;

class FooterController extends Controller
{
    /**
     * @throws ApiErrorException
     */
    public function __invoke(): JsonResponse
    {
        try {
            $menus = cache()->remember('apiMenus', SeoPage::CACHE_TIME, function () {
                return SeoPage::query()->withTranslations()->isActive()->get();
            });

            $categories = cache()->remember('apiFooterCategories', Category::CACHE_TIME, function () {
                return Category::query()->withTranslations()->isActive()->notIsNew()->get();
            });

            $socials = cache()->remember('apiFooterSocials', Social::CACHE_TIME, function () {
                return Social::query()->isActive()->get();
            });

            $contact = cache()->remember('apiFooterContact', Contact::CACHE_TIME, function () {
                return Contact::query()->withTranslations()->first();
            });

            $agreements = cache()->remember('agreements', Agreement::CACHE_TIME, function () {
                return Agreement::query()->with('fileTranslate')->get();
            });

            return new JsonResponse([
                'footerMenus' => MenuResource::collection($menus),
                'footerCategories' => FooterCategoryResource::collection($categories),
                'socials' => SocialResource::collection($socials),
                'footerContact' => $contact ? new FooterContactResource($contact) : null,
                'agreements' => AgreementResource::collection($agreements),
            ]);
        } catch (\Exception $exception) {
            return throw new ApiErrorException($exception->getMessage());
        }
    }
}
