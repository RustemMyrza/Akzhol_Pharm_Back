<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Contact\StoreContactRequest;
use App\Http\Requests\Admin\Contact\UpdateContactRequest;
use App\Models\Contact;
use App\Services\Admin\ContactService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public ContactService $service;

    public function __construct(ContactService $contactService)
    {
        $this->service = $contactService;
    }

    public function index()
    {
        $contact = Contact::query()
            ->withTranslations()
            ->first();

        if ($contact) return redirect()->route('admin.contacts.edit', ['contact' => $contact]);

        $contacts = Contact::query()
            ->withTranslations()
            ->get();

        return view('admin.contacts.index', ['contacts' => $contacts]);
    }

    public function create()
    {
        return view('admin.contacts.create');
    }

    public function store(StoreContactRequest $request)
    {
        try {
            return DB::transaction(function () use ($request) {
                $data['contact'] = $this->service->create($request->validated());
                notify()->success('', trans('messages.success_created'));
                return redirect()->route('admin.contacts.edit', $data);
            });
        } catch (\Exception $exception) {
            return back()->withInput()->withErrors($exception->getMessage());
        }
    }

    public function edit(Contact $contact)
    {
        return view('admin.contacts.edit', ['contact' => $contact->load('addressTranslate', 'workTimeTranslate')]);
    }

    public function update(UpdateContactRequest $request, Contact $contact)
    {
        try {
            return DB::transaction(function () use ($request, $contact) {
                $this->service->update($contact, $request->validated());
                return backPage(trans('messages.success_updated'));
            });
        } catch (\Exception $exception) {
            return back()->withInput()->withErrors($exception->getMessage());
        }
    }
}
