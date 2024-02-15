<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Requests\InquiryRequest;

class InquiryController extends Controller
{
    public function index(Request $request)
    {
        $inquiries = Post::orderBy('created_at', 'asc')
            ->where(function ($query) use ($request) {
                if ($searchStatus = $request->input('search_status')) {
                    $statusValue = null;

                    switch ($searchStatus) {
                        case '未対応':
                            $statusValue = 'default';
                            break;
                        case '対応中':
                            $statusValue = 'checking';
                            break;
                        case '対応済み':
                            $statusValue = 'checked';
                            break;
                        case 'default':
                        case 'checking':
                        case 'checked':
                            $statusValue = $searchStatus;
                            break;
                    }

                    if ($statusValue !== null) {
                        $query->where('status', $statusValue);
                    }
                }

                if ($searchCompany = $request->input('search_company')) {
                    $query->where('company', 'LIKE', "%{$searchCompany}%");
                }

                if ($searchTel = $request->input('search_tel')) {
                    $query->where('tel', 'LIKE', "%{$searchTel}%");
                }
            })->paginate(20);

        return view('account.InquiryList', compact('inquiries'));
    }

    public function edit(Post $inquiry)
    {
        return view('account.InquiryEdit', compact('inquiry'));
    }

    public function update(InquiryRequest $request, Post $inquiry)
    {
        $inquiry->update($request->only(['status', 'comment']));

        return redirect()->route('inquiry.list')->with('success', 'お問い合わせ情報が更新されました。');
    }
}
