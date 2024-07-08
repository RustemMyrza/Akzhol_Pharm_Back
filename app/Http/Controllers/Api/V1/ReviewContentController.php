<?php

namespace App\Http\Controllers\Api\V1;

use App\Exceptions\ApiErrorException;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\ReviewsContentResource;
use App\Models\ReviewsContent;
use stdClass;
use App\Http\Resources\V1\SeoPageResource;
use App\Models\SeoPage;
use Illuminate\Http\JsonResponse;

class ReviewContentController extends Controller
{
     /**
     * @throws ApiErrorException
     */
    public function __invoke(): JsonResponse
    {
        try {
            $reviewsContent = ReviewsContent::query()->with('descriptionTranslate', 'contentTranslate')->get();

            foreach ($reviewsContent as $key => $item)
            {
                switch($key)
                {
                    case 0:
                        $title = new ReviewsContentResource($item);
                        break;
                    case 1:
                        $formTitle = new ReviewsContentResource($item);
                        break;
                    case 2:
                        $namePlaceholder = new ReviewsContentResource($item);
                        break;
                    case 3:
                        $phonePlaceholder = new ReviewsContentResource($item);
                        break;
                    case 4:
                        $mailPlaceholder = new ReviewsContentResource($item);
                        break;
                    case 5:
                        $messagePlaceholder = new ReviewsContentResource($item);
                        break;
                    case 6:
                        $gradeLabel = new ReviewsContentResource($item);
                        break;
                    case 7:
                        $submitButton = new ReviewsContentResource($item);
                        break;
                    case 8:
                        $actualReviews = new ReviewsContentResource($item);
                        break;
                }
            }

            $reviewsContentApi = new stdClass;
            $reviewsContentApi->form = new stdClass;
            $reviewsContentApi->form->inputs = new stdClass;
            $reviewsContentApi->title = $title;
            $reviewsContentApi->form->title = $formTitle;
            $reviewsContentApi->form->inputs->name = $namePlaceholder;
            $reviewsContentApi->form->inputs->phone = $phonePlaceholder;
            $reviewsContentApi->form->inputs->email = $mailPlaceholder;
            $reviewsContentApi->form->inputs->message = $messagePlaceholder;
            $reviewsContentApi->form->inputs->grade = $gradeLabel;
            $reviewsContentApi->form->inputs->submit = $submitButton;
            $reviewsContentApi->actualReviews = $actualReviews;

            $seoPage = SeoPage::query()->withMetaTranslations()->wherePage('about')->first();

            return new JsonResponse([
                'reviewsContent' => $reviewsContentApi ? $reviewsContentApi : null,
                'seoPage' => $seoPage ? new SeoPageResource($seoPage) : null
            ]);
        } catch (\Exception $exception) {
            return throw new ApiErrorException($exception->getMessage());
        }
    }
}
