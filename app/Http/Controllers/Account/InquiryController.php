<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use App\Http\Requests\Account\InquiryRequest;
use App\Models\Post;
use App\Services\InquiryService;

class InquiryController extends Controller
{

    protected $inquiryService;

    public function __construct(InquiryService $inquiryService)
    {
        $this->inquiryService = $inquiryService; 
    }

    public function index(Request $request)
    {
        $query = $this->inquiryService->index($request);
        $inquiries = $query->paginate(20);

        foreach ($inquiries as $inquiry) {
            $inquiry->status = config('const.status')[$inquiry->status] ?? $inquiry->status;
        }

        return view('account.InquiryList', compact('inquiries'));
    }

    public function edit(Post $inquiry)
    {
        $statusOptions = Config::get('const.status');
        $inquiry->status = $statusOptions[$inquiry->status] ?? $inquiry->status;
        $inquiry->gender = config('const.gender.' . $inquiry->gender);
        $inquiry->profession = config('const.profession.' . $inquiry->profession);

        return view('account.InquiryEdit', compact('inquiry', 'statusOptions'));
    }

    public function update(InquiryRequest $request, Post $inquiry)
    {
        $inquiry->update($request->only(['status', 'comment']));

        return redirect()->route('inquiry.list')->with('success', 'お問い合わせ情報が更新されました。');
    }
}
