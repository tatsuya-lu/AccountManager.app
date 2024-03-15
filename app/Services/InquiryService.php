<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Http\Request;

class InquiryService
{

    public function __construct(private Request $request){}

    public function index()
    {
        $sort = $this->request->input('sort', 'newest');

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

        $inquiries = $query->where(function ($query) {
            if ($searchStatus = $this->request->input('search_status')) {
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

            if ($searchCompany = $this->request->input('search_company')) {
                $query->where('company', 'LIKE', "%{$searchCompany}%");
            }

            if ($searchTel = $this->request->input('search_tel')) {
                $query->where('tel', 'LIKE', "%{$searchTel}%");
            }
        })->paginate(20);

        return $inquiries;
    }
    
    public function unresolvedInquiryCount()
    {
        return Post::where('status', 'default')->count();
    }

    public function unresolvedInquiries()
    {
        return Post::where('status', 'default')
            ->orderBy('created_at', 'desc')
            ->paginate(5, ['*'], 'page');
    }
}