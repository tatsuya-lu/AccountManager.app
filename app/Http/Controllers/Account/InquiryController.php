<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Requests\Account\InquiryRequest;
use Illuminate\Support\Facades\Config;

class InquiryController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->input('sort', 'newest');

        $query = Post::query();

        switch ($sort) {
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $inquiries = $query->where(function ($query) use ($request) {
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

        foreach ($inquiries as $inquiry) {
            $inquiry->status = config('const.status')[$inquiry->status] ?? $inquiry->status;
        }

        return view('account.InquiryList', compact('inquiries', 'sort'));
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
