<?php

namespace App\Http\Controllers\Api\V1;

use App\Exceptions\ApiErrorException;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\ContactResource;
use App\Http\Resources\V1\SeoPageResource;
use App\Models\Contact;
use App\Models\SeoPage;
use Illuminate\Http\JsonResponse;

class ContactController extends Controller
{
    public function __invoke(): JsonResponse
    {
        try {
            $contact = cache()->remember('apiContact', Contact::CACHE_TIME, function () {
                return Contact::query()->withTranslations()->first();
            });

            $seoPage = cache()->remember('apiSeoContacts', SeoPage::CACHE_TIME, function () {
                return SeoPage::query()->withMetaTranslations()->wherePage('contacts')->first();
            });

            return new JsonResponse([
                'contact' => $contact ? new ContactResource($contact) : null,
                'seoPage' => $seoPage ? new SeoPageResource($seoPage) : null,
            ]);
        }catch (\Exception $exception) {
            return throw new ApiErrorException($exception->getMessage());
        }
    }
}
