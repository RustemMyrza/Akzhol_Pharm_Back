<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\Admin\Product\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductAjaxController extends Controller
{
    public ProductService $service;

    public function __construct(ProductService $productService)
    {
        $this->service = $productService;
    }

//    public function addDescriptionList(Product $product, Request $request)
//    {
//        try {
//            $request->validate([
//                'image' => 'nullable|image|max:4096',
//                'title' => 'required|max:255',
//                'text' => 'nullable|max:255',
//            ]);
//
//            return new JsonResponse($this->service->addDescriptionList($product, $request->all()));
//        } catch (\Exception $exception) {
//            return new JsonResponse(['status' => false, 'message' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
//        }
//    }

//    public function updateDescriptionList(Product $product, Request $request)
//    {
//        try {
//            $request->validate([
//                'image' => 'nullable|image|max:4096',
//                'title' => 'required|max:255',
//                'text' => 'nullable|max:255',
//            ]);
//
//            return new JsonResponse($this->service->updateDescriptionList($product, $request->all()));
//        } catch (\Exception $exception) {
//            return new JsonResponse(['status' => false, 'message' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
//        }
//    }

//    public function deleteDescriptionList(Product $product, Request $request)
//    {
//        try {
//            return new JsonResponse($this->service->deleteDescriptionList($product, $request->all()));
//        } catch (\Exception $exception) {
//            return new JsonResponse(['status' => false, 'message' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
//        }
//    }


//    public function addInstructionList(Product $product, Request $request)
//    {
//        try {
//            $request->validate([
//                'title' => 'required|max:255',
//                'text' => 'nullable|max:255',
//            ]);
//
//            return new JsonResponse($this->service->addInstructionList($product, $request->all()));
//        } catch (\Exception $exception) {
//            return new JsonResponse(['status' => false, 'message' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
//        }
//    }

//    public function updateInstructionList(Product $product, Request $request)
//    {
//        try {
//            $request->validate([
//                'title' => 'required|max:255',
//                'text' => 'nullable|max:255',
//            ]);
//
//            return new JsonResponse($this->service->updateInstructionList($product, $request->all()));
//        } catch (\Exception $exception) {
//            return new JsonResponse(['status' => false, 'message' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
//        }
//    }

//    public function deleteInstructionList(Product $product, Request $request)
//    {
//        try {
//            return new JsonResponse($this->service->deleteInstructionList($product, $request->all()));
//        } catch (\Exception $exception) {
//            return new JsonResponse(['status' => false, 'message' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
//        }
//    }
}
