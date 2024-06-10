<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Instruction\DeleteInstructionFileRequest;
use App\Http\Requests\Admin\Instruction\StoreInstructionRequest;
use App\Http\Requests\Admin\Instruction\UpdateInstructionRequest;
use App\Http\Requests\Admin\Instruction\UpdateIsActiveRequest;
use App\Models\Instruction;
use App\Services\Admin\Instruction\InstructionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class InstructionController extends Controller
{
    public InstructionService $service;

    public function __construct(InstructionService $instructionService)
    {
        $this->service = $instructionService;
    }

    public function index()
    {
        try {
            return view('admin.instructions.index', $this->service->getInstructions());
        } catch (\Exception $exception) {
            return backPageError($exception->getMessage());
        }
    }

    public function create()
    {
        try {
            $data['lastPosition'] = Instruction::lastPosition();
            return view('admin.instructions.create', $data);
        } catch (\Exception $exception) {
            return backPageError($exception->getMessage());
        }
    }

    public function store(StoreInstructionRequest $request)
    {
        try {
            return DB::transaction(function () use ($request) {
                $this->service->create($request->validated());
                return redirectPage('admin.instructions.index', trans('messages.success_created'));
            });
        } catch (\Exception $exception) {
            return back()->withInput()->withErrors($exception->getMessage());
        }
    }

    public function edit(Instruction $instruction)
    {
        try {
            $data['instruction'] = $instruction->load('titleTranslate', 'fileTranslate');
            return view('admin.instructions.edit', $data);
        } catch (\Exception $exception) {
            return backPageError($exception->getMessage());
        }
    }

    public function update(Instruction $instruction, UpdateInstructionRequest $request)
    {
        try {
            return DB::transaction(function () use ($instruction, $request) {
                $this->service->update($instruction, $request->validated());
                return redirectPage('admin.instructions.index', trans('messages.success_updated'));
            });
        } catch (\Exception $exception) {
            return back()->withInput()->withErrors($exception->getMessage());
        }
    }

    public function destroy(Instruction $instruction)
    {
        try {
            return DB::transaction(function () use ($instruction) {
                $this->service->delete($instruction->load('fileTranslate'));
                return redirectPage('admin.instructions.index', trans('messages.success_deleted'));
            });
        } catch (\Exception $exception) {
            return back()->withErrors($exception->getMessage());
        }
    }

    public function deleteFile(Instruction $instruction, DeleteInstructionFileRequest $request)
    {
        try {
            $this->service->deleteFile($instruction->load('fileTranslate'), $request->validated()['language']);
            return back()->with('success', trans('messages.success_deleted'));
        } catch (\Exception $exception) {
            return back()->withErrors($exception->getMessage());
        }
    }

    public function updateIsActive(UpdateIsActiveRequest $request): JsonResponse
    {
        try {
            Instruction::query()
                ->find($request->input('data_id'))
                ->update([
                    'is_active' => $request->input('is_active') == 1 ? 1 : 0
                ]);
            return new JsonResponse(['status' => true]);
        } catch (\Exception $exception) {
            return new JsonResponse(['status' => false, 'message' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
