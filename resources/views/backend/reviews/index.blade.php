@extends('layouts.backend')

@section('content')
    <div class="admin-content">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h2 class="mb-0">Reviews</h2>
            <a href="{{ route('backend.reviews.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Add New
            </a>
        </div>

        <div class="row g-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <strong>All Reviews</strong>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle datatable-no-ordering">
                                <thead>
                                    <tr>
                                        <th style="width: 70px;">Image</th>
                                        <th>Name</th>
                                        <th>Location</th>
                                        <th>Rating</th>
                                        <th>Comment</th>
                                        <th style="width: 90px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($reviews as $review)
                                        <tr>
                                            <td>
                                                <img src="{{ asset('assets/images/reviews/' . ($review->image ?: 'blank-profile.jpg')) }}" alt="{{ $review->name }}" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                                            </td>
                                            <td>{{ $review->name }}</td>
                                            <td>{{ $review->location }}</td>
                                            <td>
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= (int) $review->rating)
                                                        <i class="fas fa-star text-warning"></i>
                                                    @else
                                                        <i class="far fa-star text-muted"></i>
                                                    @endif
                                                @endfor
                                            </td>
                                            <td>{{ Str::limit($review->comment, 120) }}</td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-danger" onclick="delete_warning('{{ route('backend.reviews.destroy', $review->id) }}')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">No reviews found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
