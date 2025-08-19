<?php

namespace App\Exports;

use App\Models\Review;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReviewsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Review::with('product')->get()->map(function ($review) {
            return [
                'id' => $review->id,
                'product' => optional($review->product)->name,
                'name' => $review->name,
                'email' => $review->email,
                'rating' => $review->rating,
                'is_approved' => $review->is_approved ? 'Yes' : 'No',
                'review_text' => $review->review_text,
                'created_at' => optional($review->created_at)->format('Y-m-d H:i:s'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Product',
            'Name',
            'Email',
            'Rating',
            'Approved',
            'Review',
            'Created At',
        ];
    }
}

