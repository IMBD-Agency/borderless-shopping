@extends('layouts.backend')

@section('content')
    <div class="admin-content">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h2 class="mb-0">Add New FAQ</h2>
            <a href="{{ route('backend.faqs.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back to FAQs
            </a>
        </div>

        <div class="row g-3">
            <div class="col-12 col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <strong>FAQ Details</strong>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('backend.faqs.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">FAQ Category <span class="text-danger">*</span></label>
                                <select name="category_id" class="form-select" required>
                                    <option value="">Select a FAQ category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Select a FAQ category or <a href="{{ route('backend.faq.categories.create') }}" target="_blank">create a new one</a>.</small>
                                @error('category_id')
                                    <small class="text-danger d-block">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Question <span class="text-danger">*</span></label>
                                <textarea name="question" rows="2" class="form-control" required>{{ old('question') }}</textarea>
                                @error('question')
                                    <small class="text-danger d-block">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Answer <span class="text-danger">*</span></label>
                                <textarea name="answer" rows="5" class="form-control" required>{{ old('answer') }}</textarea>
                                @error('answer')
                                    <small class="text-danger d-block">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Order</label>
                                    <input type="number" name="order" class="form-control" value="{{ old('order', 0) }}" min="0">
                                    <small class="text-muted">Lower numbers appear first within the same FAQ category.</small>
                                    @error('order')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Status</label>
                                    <div class="form-check form-switch mt-2">
                                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">
                                            Active
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i> Save FAQ
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

