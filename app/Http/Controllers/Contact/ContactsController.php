<?php

namespace App\Http\Controllers\Contact;

use App\Http\Controllers\Controller;
use App\Models\Contact\Post;
use App\Http\Requests\Contact\ContactRequest;


class ContactsController extends Controller
{

    protected $genders;
    protected $professions;

    public function __construct()
    {
        $this->genders = config('const.gender');
        $this->professions = config('const.profession');
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

            $post = Post::create([
                'company' => $request->company,
                'name' => $request->name,
                'tel' => $request->tel,
                'email' => $request->email,
                'birthday' => $request->birthday,
                'gender' => $request->gender,
                'profession' => $request->profession,
                'body' => $request->body
            ]);

            $genders = $this->genders;
            $professions = $this->professions;

            return view('contact.thanks', compact('inputs', 'genders', 'professions'));
        }
    }
}
