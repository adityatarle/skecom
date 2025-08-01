@include('dashboard.layout.header')

<style>
    /* Fix dark mode table issues */
    .table {
        margin-bottom: 0;
    }
    
    .table tbody tr:last-child {
        border-bottom: none;
    }
    
    /* Ensure proper spacing in dark mode */
    .card-footer {
        background: transparent !important;
        border-top: 1px solid rgba(255, 255, 255, 0.1) !important;
    }
    
    /* Fix table row spacing */
    .table tbody tr {
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .table tbody tr:last-child {
        border-bottom: none;
    }
    
    /* Ensure proper card spacing */
    .card {
        margin-bottom: 1.5rem;
    }
    
    /* Fix pagination styling in dark mode */
    .pagination {
        margin-bottom: 0;
    }
    
    .page-link {
        background-color: transparent;
        border-color: rgba(255, 255, 255, 0.1);
        color: #a1a5b7;
    }
    
    .page-link:hover {
        background-color: rgba(255, 255, 255, 0.05);
        border-color: rgba(255, 255, 255, 0.2);
        color: #ffffff;
    }
    
    .page-item.active .page-link {
        background-color: #667eea;
        border-color: #667eea;
        color: #ffffff;
    }
</style>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <!-- Header Section -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-gradient-primary text-white py-3">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h3 class="card-title mb-0">
                                <i class="fas fa-layer-group me-2"></i>Category Management
                            </h3>
                            <small class="opacity-90">Manage your product categories with hierarchy support</small>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.category.create', ['level' => 1]) }}" class="btn btn-light btn-sm">
                                    <i class="fas fa-plus me-1"></i>Top Level
                                </a>
                                <a href="{{ route('admin.category.create', ['level' => 2]) }}" class="btn btn-light btn-sm">
                                    <i class="fas fa-plus me-1"></i>Parent Category
                                </a>
                                <a href="{{ route('admin.category.create', ['level' => 3]) }}" class="btn btn-light btn-sm">
                                    <i class="fas fa-plus me-1"></i>Child Category
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters Section -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body py-3">
                    <form method="GET" action="{{ route('admin.category.index') }}" class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label small fw-bold">Search</label>
                            <input type="text" name="search" class="form-control" 
                                   placeholder="Search categories..." 
                                   value="{{ request('search') }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label small fw-bold">Level</label>
                            <select name="level" class="form-select">
                                <option value="">All Levels</option>
                                <option value="1" {{ request('level') == '1' ? 'selected' : '' }}>Top Level</option>
                                <option value="2" {{ request('level') == '2' ? 'selected' : '' }}>Parent</option>
                                <option value="3" {{ request('level') == '3' ? 'selected' : '' }}>Child</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-bold">Parent Category</label>
                            <select name="parent_id" class="form-select">
                                <option value="">All Parents</option>
                                @foreach($parentCategories as $parent)
                                    <option value="{{ $parent->id }}" {{ request('parent_id') == $parent->id ? 'selected' : '' }}>
                                        {{ $parent->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary me-2">
                                <i class="fas fa-search me-1"></i>Filter
                            </button>
                            <a href="{{ route('admin.category.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-1"></i>Clear
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Categories Table -->
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(isset($error))
                        <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>{{ $error }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th class="px-4 py-3">
                                        <i class="fas fa-image me-1"></i>Image
                                    </th>
                                    <th class="px-4 py-3">
                                        <i class="fas fa-tag me-1"></i>Name & Hierarchy
                                    </th>
                                    <th class="px-4 py-3">
                                        <i class="fas fa-layer-group me-1"></i>Level
                                    </th>
                                    <th class="px-4 py-3">
                                        <i class="fas fa-box me-1"></i>Products
                                    </th>
                                    <th class="px-4 py-3">
                                        <i class="fas fa-sitemap me-1"></i>Children
                                    </th>
                                    <th class="px-4 py-3">
                                        <i class="fas fa-toggle-on me-1"></i>Status
                                    </th>
                                    <th class="px-4 py-3">
                                        <i class="fas fa-sort me-1"></i>Order
                                    </th>
                                    <th class="px-4 py-3 text-center">
                                        <i class="fas fa-cogs me-1"></i>Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categories as $category)
                                    <tr class="{{ !$category->is_active ? 'table-secondary' : '' }}">
                                        <td class="px-4 py-3">
                                            @if($category->image)
                                                <img src="{{ asset($category->image) }}" 
                                                     alt="{{ $category->name }}" 
                                                     class="img-thumbnail" 
                                                     style="width: 60px; height: 60px; object-fit: cover;">
                                            @else
                                                <div class="bg-light d-flex align-items-center justify-content-center" 
                                                     style="width: 60px; height: 60px; border-radius: 0.375rem;">
                                                    <i class="fas fa-image text-muted"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="d-flex align-items-center">
                                                @if($category->level == 2)
                                                    <span class="text-muted me-2">├─</span>
                                                @elseif($category->level == 3)
                                                    <span class="text-muted me-2">└──</span>
                                                @endif
                                                <div>
                                                    <h6 class="mb-1 fw-semibold">{{ $category->name }}</h6>
                                                    @if($category->parent)
                                                        <small class="text-muted">
                                                            <i class="fas fa-arrow-up me-1"></i>{{ $category->parent->name }}
                                                        </small>
                                                    @endif
                                                    @if($category->description)
                                                        <p class="mb-0 small text-muted">{{ Str::limit($category->description, 50) }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3">
                                            @switch($category->level)
                                                @case(1)
                                                    <span class="badge bg-primary">Top Level</span>
                                                    @break
                                                @case(2)
                                                    <span class="badge bg-success">Parent</span>
                                                    @break
                                                @case(3)
                                                    <span class="badge bg-info">Child</span>
                                                    @break
                                            @endswitch
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="badge bg-secondary">{{ $category->products_count ?? $category->products->count() }}</span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="badge bg-warning">{{ $category->children_count ?? $category->children->count() }}</span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input status-toggle" 
                                                       type="checkbox" 
                                                       {{ $category->is_active ? 'checked' : '' }}
                                                       data-category-id="{{ $category->id }}">
                                            </div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="badge bg-light text-dark">{{ $category->sort_order }}</span>
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.category.show', $category) }}" 
                                                   class="btn btn-sm btn-outline-info" 
                                                   title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.category.edit', $category) }}" 
                                                   class="btn btn-sm btn-outline-warning" 
                                                   title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.category.destroy', $category) }}" 
                                                      method="POST" 
                                                      class="d-inline" 
                                                      onsubmit="return confirm('Are you sure you want to delete this category?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-sm btn-outline-danger" 
                                                            title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-4 py-5 text-center text-muted">
                                            <i class="fas fa-folder-open fa-3x mb-3 d-block text-muted opacity-50"></i>
                                            <h5>No categories found</h5>
                                            <p class="mb-3">Get started by creating your first category.</p>
                                            <a href="{{ route('admin.category.create', ['level' => 1]) }}" class="btn btn-primary">
                                                <i class="fas fa-plus me-1"></i>Create Top Level Category
                                            </a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($categories instanceof \Illuminate\Pagination\LengthAwarePaginator && $categories->hasPages())
                        <div class="card-footer bg-transparent border-top-0">
                            {{ $categories->appends(request()->query())->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Status toggle functionality
    document.querySelectorAll('.status-toggle').forEach(function(toggle) {
        toggle.addEventListener('change', function() {
            const categoryId = this.dataset.categoryId;
            const isActive = this.checked;
            
            fetch(`/admin/categories/${categoryId}/toggle-status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message
                    const alert = document.createElement('div');
                    alert.className = 'alert alert-success alert-dismissible fade show position-fixed';
                    alert.style.cssText = 'top: 20px; right: 20px; z-index: 9999;';
                    alert.innerHTML = `
                        <i class="fas fa-check-circle me-2"></i>${data.message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    `;
                    document.body.appendChild(alert);
                    
                    // Auto remove after 3 seconds
                    setTimeout(() => {
                        alert.remove();
                    }, 3000);
                } else {
                    // Revert toggle on error
                    this.checked = !isActive;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Revert toggle on error
                this.checked = !isActive;
            });
        });
    });
});
</script>

@include('dashboard.layout.footer')