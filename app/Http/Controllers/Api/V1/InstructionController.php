<?php

namespace App\Http\Controllers\Api\V1;

use App\Exceptions\ApiErrorException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\SearchInstructionRequest;
use App\Http\Resources\V1\InstructionResource;
use App\Http\Resources\V1\SeoPageResource;
use App\Library\ResourcePaginator;
use App\Models\Instruction;
use App\Models\SeoPage;
use App\Models\Translate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InstructionController extends Controller
{
    /**
     * @throws ApiErrorException
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $page = $request->filled('page') ? $request->input('page') : 1;

            $instructions = cache()->remember('apiInstructions_' . $page, Instruction::CACHE_TIME, function () {
                return Instruction::query()->withTranslations()->isActive()->paginate(Instruction::DEFAULT_API_PAGINATE);
            });

            $seoPage = cache()->remember('apiSeoInstructions', SeoPage::CACHE_TIME, function () {
                return SeoPage::query()->withMetaTranslations()->wherePage('instructions')->first();
            });

            return new JsonResponse([
                'instructions' => new ResourcePaginator(InstructionResource::collection($instructions)),
                'seoPage' => $seoPage ? new SeoPageResource($seoPage) : null
            ]);
        } catch (\Exception $exception) {
            return throw new ApiErrorException($exception->getMessage());
        }
    }

    /**
     * @throws ApiErrorException
     */
    public function search(SearchInstructionRequest $request)
    {
        try {
            $instructions = Instruction::query()
                ->when($request->filled('text'), function ($query) use ($request) {
                    $keywords = explode(' ', $request->input('text'));

                    $query->where(function ($subQuery) use ($keywords) {
                        foreach ($keywords as $keyword) {

                            $subQuery->orWhereHas('titleTranslate', function ($titleQuery) use ($keyword) {
                                foreach (Translate::LANGUAGES as $language) {
                                    $titleQuery->where("$language", 'like', "%$keyword%");
                                }
                            });

                        }
                    });
                })
                ->withTranslations()
                ->isActive()
                ->paginate(Instruction::DEFAULT_API_PAGINATE);

            return new JsonResponse([
                'instructions' => new ResourcePaginator(
                    InstructionResource::collection($instructions)
                ),
            ]);
        } catch (\Exception $exception) {
            return throw new ApiErrorException($exception->getMessage());
        }
    }
}
