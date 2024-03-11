<?php

namespace App\Http\Controllers\Contact;

use App\Http\Controllers\Controller;
use App\Http\Requests\Contact\ContactRequest;
use App\Services\ContactService;


class ContactsController extends Controller
{

    protected $genders;
    protected $professions;
    protected $contactService;

    public function __construct(ContactService $contactService)
    {
        $this->genders = config('const.gender');
        $this->professions = config('const.profession');
        $this->contactService = $contactService;
    }

    public function index()
    {
        $genders = $this->genders;
        $professions = $this->professions;

        return view('contact.index', compact('genders', 'professions'));
    }

    public function confirm(ContactRequest $request)
    {

        $validatedData = $request->validated();
        $inputs = $validatedData;
        $genders = $this->genders;
        $professions = $this->professions;

        return view('contact.confirm', compact('inputs', 'genders', 'professions'));
    }

    public function send(ContactRequest $request)
    {

        $action = $request->input('action');

        $inputs = $request->except('action');

        if ($action !== 'submit') {
            return redirect()
                ->route('contact.index')
                ->withInput($inputs);
        } else {
            $request->session()->regenerateToken();
            $post = $this->contactService->store($inputs);

            $genders = $this->genders;
            $professions = $this->professions;

            return view('contact.thanks', compact('inputs', 'genders', 'professions'));
        }
    }
}
