@extends('layouts.backend')

@section('content')
    <div class="admin-content">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h2 class="mb-0">Edit FAQ Category</h2>
            <a href="{{ route('backend.faq.categories.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back to FAQ Categories
            </a>
        </div>

        <div class="row g-3">
            <div class="col-12 col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <strong>FAQ Category Details</strong>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('backend.faq.categories.update', $category->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}" placeholder="e.g., General, Payments & Billing, Shipping & Delivery" required>
                                <small class="text-muted">The FAQ category name will be displayed in FAQ forms and frontend.</small>
                                @error('name')
                                    <small class="text-danger d-block">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Slug</label>
                                <input type="text" class="form-control" value="{{ $category->slug }}" disabled>
                                <small class="text-muted">Slug is auto-generated from name and cannot be edited directly.</small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" rows="3" class="form-control" placeholder="Optional description for this FAQ category">{{ old('description', $category->description) }}</textarea>
                                @error('description')
                                    <small class="text-danger d-block">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Order</label>
                                    <input type="number" name="order" class="form-control" value="{{ old('order', $category->order) }}" min="0">
                                    <small class="text-muted">Lower numbers appear first.</small>
                                    @error('order')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Status</label>
                                    <div class="form-check form-switch mt-2">
                                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">
                                            Active
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i> Update FAQ Category
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

