@include('dashboard.layout.header')

<div class="container">
    <div class="d-flex justify-content-between align-items-center mt-2 mb-3">
        <h2 style="font-size: 1.8rem; color: #343a40;">Reviews</h2>
        <a href="{{ route('admin.reviews.export') }}" class="btn btn-success">Export to CSV</a>
    </div>

   @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div style="overflow-x: auto;">
        <table class="table" style="min-width: 800px;">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Review</th>
                    <th>Rating</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reviews as $review)
                <tr>
                   <td>{{ $review->product->name }}</td>
                   <td>{{ $review->name }}</td>
                    <td>{{ $review->email }}</td>
                     <td title="{{ $review->review_text }}" style="max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                        {{ Str::limit($review->review_text, 100) }}
                    </td>
                    <td>{{$review->rating}}</td>
                    <td>
                        @if ($review->is_approved)
                           <span class="badge bg-success">Approved</span>
                        @else
                            <span class="badge bg-secondary">Pending</span>
                         @endif
                   </td>
                    <td>
                       <a href="{{ route('admin.reviews.edit', $review->id) }}" class="btn btn-sm btn-primary">Edit</a>
                       <form method="POST" action="{{ route('admin.reviews.destroy', $review->id) }}" class="d-inline">
                           @csrf
                           @method('DELETE')
                           <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this review?')">Delete</button>
                        </form>
                    </td>
               </tr>
               @empty
                    <tr>
                       <td colspan="6" style="text-align: center;">No reviews yet.</td>
                    </tr>
                @endforelse
            </tbody>
         </table>
   </div>
    <div style="margin-top: 20px;">
       {{ $reviews->links() }}
    </div>
</div>
@include('dashboard.layout.footer')