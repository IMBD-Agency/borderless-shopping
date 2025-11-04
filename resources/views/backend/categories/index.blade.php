@extends('layouts.backend')

@section('content')
    <div class="admin-content">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h2 class="mb-0">FAQ Categories</h2>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                <i class="fas fa-plus me-1"></i> Add New FAQ Category
            </button>
        </div>

        <div class="row g-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <strong>All FAQ Categories</strong>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle datatable-no-ordering">
                                <thead>
                                    <tr>
                                        <th style="width: 200px;">Name</th>
                                        <th>Description</th>
                                        <th style="width: 80px;">Order</th>
                                        <th style="width: 100px;">Status</th>
                                        <th style="width: 100px;">FAQs Count</th>
                                        <th style="width: 150px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $category)
                                        <tr>
                                            <td>
                                                <strong>{{ $category->name }}</strong>
                                                <br>
                                                <small class="text-muted">Slug: {{ $category->slug }}</small>
                                            </td>
                                            <td>{{ Str::limit($category->description, 100) }}</td>
                                            <td>{{ $category->order }}</td>
                                            <td>
                                                @if ($category->is_active)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-secondary">Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-info">{{ $category->faqs()->count() }}</span>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-primary me-1 btn-edit-category" title="Edit" data-id="{{ $category->id }}" data-name="{{ $category->name }}" data-description="{{ $category->description }}" data-order="{{ $category->order }}" data-active="{{ $category->is_active ? 1 : 0 }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-danger" onclick="delete_warning('{{ route('backend.faq.categories.destroy', $category->id) }}')" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add FAQ Category Modal -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel">
                        <i class="fas fa-plus me-2"></i>Add New FAQ Category
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addCategoryForm">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" placeholder="e.g., General, Payments & Billing, Shipping & Delivery" required>
                            <small class="text-muted">The category name will be displayed in FAQ forms and frontend.</small>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" rows="3" class="form-control" placeholder="Optional description for this category"></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Order</label>
                                <input type="number" name="order" class="form-control" value="0" min="0">
                                <small class="text-muted">Lower numbers appear first.</small>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="is_active" id="modal_is_active" value="1" checked>
                                    <label class="form-check-label" for="modal_is_active">
                                        Active
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Save FAQ Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit FAQ Category Modal -->
    <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCategoryModalLabel">
                        <i class="fas fa-edit me-2"></i>Edit FAQ Category
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editCategoryForm">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="id" id="edit_category_id">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="edit_category_name" class="form-control" required>
                            <small class="text-muted">The FAQ category name will be displayed in FAQ forms and frontend.</small>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" id="edit_category_description" rows="3" class="form-control" placeholder="Optional description for this FAQ category"></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Order</label>
                                <input type="number" name="order" id="edit_category_order" class="form-control" value="0" min="0">
                                <small class="text-muted">Lower numbers appear first.</small>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="is_active" id="edit_category_is_active" value="1">
                                    <label class="form-check-label" for="edit_category_is_active">
                                        Active
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Update FAQ Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#addCategoryForm').on('submit', function(e) {
                    e.preventDefault();

                    var form = $(this);
                    var formData = form.serialize();
                    var submitBtn = form.find('button[type="submit"]');
                    var originalText = submitBtn.html();

                    // Disable submit button and show loading
                    submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> Saving...');

                    // Clear previous errors
                    form.find('.is-invalid').removeClass('is-invalid');
                    form.find('.invalid-feedback').text('');

                    $.ajax({
                        url: '{{ route('backend.faq.categories.store') }}',
                        type: 'POST',
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: 'FAQ Category added successfully.',
                                timer: 1500,
                                showConfirmButton: false
                            }).then(function() {
                                location.reload();
                            });
                        },
                        error: function(xhr) {
                            submitBtn.prop('disabled', false).html(originalText);

                            if (xhr.status === 422) {
                                // Validation errors
                                var errors = xhr.responseJSON.errors;
                                for (var field in errors) {
                                    var input = form.find('[name="' + field + '"]');
                                    input.addClass('is-invalid');
                                    input.siblings('.invalid-feedback').text(errors[field][0]);
                                }
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: xhr.responseJSON?.message || 'Failed to add category. Please try again.'
                                });
                            }
                        }
                    });
                });

                // Open edit modal with prefilled data
                $('.btn-edit-category').on('click', function() {
                    var btn = $(this);
                    $('#edit_category_id').val(btn.data('id'));
                    $('#edit_category_name').val(btn.data('name'));
                    $('#edit_category_description').val(btn.data('description'));
                    $('#edit_category_order').val(btn.data('order'));
                    $('#edit_category_is_active').prop('checked', parseInt(btn.data('active')) === 1);

                    var modal = new bootstrap.Modal(document.getElementById('editCategoryModal'));
                    modal.show();
                });

                // Handle edit form submission
                $('#editCategoryForm').on('submit', function(e) {
                    e.preventDefault();

                    var form = $(this);
                    var id = $('#edit_category_id').val();
                    var formData = form.serialize();
                    var submitBtn = form.find('button[type="submit"]');
                    var originalText = submitBtn.html();

                    submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> Updating...');

                    form.find('.is-invalid').removeClass('is-invalid');
                    form.find('.invalid-feedback').text('');

                    $.ajax({
                        url: '{{ url('/dashboard/faq/categories/update') }}/' + id,
                        type: 'POST',
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: 'FAQ Category updated successfully.',
                                timer: 1500,
                                showConfirmButton: false
                            }).then(function() {
                                location.reload();
                            });
                        },
                        error: function(xhr) {
                            submitBtn.prop('disabled', false).html(originalText);

                            if (xhr.status === 422) {
                                var errors = xhr.responseJSON.errors;
                                for (var field in errors) {
                                    var input = form.find('[name="' + field + '"]');
                                    input.addClass('is-invalid');
                                    input.siblings('.invalid-feedback').text(errors[field][0]);
                                }
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: xhr.responseJSON?.message || 'Failed to update FAQ Category. Please try again.'
                                });
                            }
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
