<?php

namespace App\Services;

use App\Models\Post;

class InquiryService
{
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