@extends('layouts.backend')

@section('content')
    <div class="admin-content">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h2 class="mb-0">FAQs</h2>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addFaqModal">
                <i class="fas fa-plus me-1"></i> Add New FAQ
            </button>
        </div>

        <div class="row g-3">
            @php
                $groupedFaqs = collect($faqs)->groupBy(function ($faq) {
                    return optional($faq->category)->name ?? 'Uncategorized';
                });
            @endphp

            @foreach ($groupedFaqs as $categoryName => $faqsInCategory)
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <strong>{{ $categoryName }}</strong>
                            <span class="badge bg-primary">{{ $faqsInCategory->count() }} FAQ(s)</span>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle datatable-no-ordering">
                                    <thead>
                                        <tr>
                                            <th>Question</th>
                                            <th style="width: 80px;">Order</th>
                                            <th style="width: 100px;">Status</th>
                                            <th style="width: 150px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($faqsInCategory as $faq)
                                            <tr>
                                                <td>{{ Str::limit($faq->question, 100) }}</td>
                                                <td>{{ $faq->order }}</td>
                                                <td>
                                                    @if ($faq->is_active)
                                                        <span class="badge bg-success">Active</span>
                                                    @else
                                                        <span class="badge bg-secondary">Inactive</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-primary me-1 btn-edit-faq" title="Edit" data-id="{{ $faq->id }}" data-category_id="{{ $faq->category_id }}" data-question="{{ e($faq->question) }}" data-answer="{{ e($faq->answer) }}" data-order="{{ $faq->order }}" data-active="{{ $faq->is_active ? 1 : 0 }}">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-danger" onclick="delete_warning('{{ route('backend.faqs.destroy', $faq->id) }}')" title="Delete">
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
            @endforeach
        </div>
    </div>

    <!-- Add FAQ Modal -->
    <div class="modal fade" id="addFaqModal" tabindex="-1" aria-labelledby="addFaqModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addFaqModalLabel">
                        <i class="fas fa-plus me-2"></i>Add New FAQ
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addFaqForm">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">FAQ Category <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-select" required id="faq_category_select">
                                <option value="">Select a FAQ category</option>
                                @foreach (\App\Models\Category::active()->ordered()->get() as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <small class="text-muted">Select a FAQ category.</small>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Question <span class="text-danger">*</span></label>
                            <textarea name="question" rows="2" class="form-control" required></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Answer <span class="text-danger">*</span></label>
                            <textarea name="answer" rows="5" class="form-control" required></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Order</label>
                                <input type="number" name="order" class="form-control" value="0" min="0">
                                <small class="text-muted">Lower numbers appear first within the same category.</small>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="is_active" id="faq_is_active" value="1" checked>
                                    <label class="form-check-label" for="faq_is_active">
                                        Active
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Save FAQ
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit FAQ Modal -->
    <div class="modal fade" id="editFaqModal" tabindex="-1" aria-labelledby="editFaqModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editFaqModalLabel">
                        <i class="fas fa-edit me-2"></i>Edit FAQ
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editFaqForm">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="id" id="edit_faq_id">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">FAQ Category <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-select" required id="edit_faq_category_select"></select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Question <span class="text-danger">*</span></label>
                            <textarea name="question" rows="2" class="form-control" required id="edit_faq_question"></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Answer <span class="text-danger">*</span></label>
                            <textarea name="answer" rows="5" class="form-control" required id="edit_faq_answer"></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Order</label>
                                <input type="number" name="order" class="form-control" value="0" min="0" id="edit_faq_order">
                                <small class="text-muted">Lower numbers appear first within the same FAQ category.</small>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="is_active" id="edit_faq_is_active" value="1">
                                    <label class="form-check-label" for="edit_faq_is_active">
                                        Active
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Update FAQ
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                // Refresh category dropdown when FAQ modal is shown
                $('#addFaqModal').on('show.bs.modal', function() {
                    refreshCategoryDropdown();
                });

                // Also refresh when FAQ modal is already shown
                if ($('#addFaqModal').hasClass('show')) {
                    refreshCategoryDropdown();
                }

                function refreshCategoryDropdown() {
                    $.ajax({
                        url: '{{ route('backend.faq.categories.index') }}?ajax-list=1',
                        type: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        dataType: 'json',
                        success: function(response) {
                            var select = $('#faq_category_select');
                            select.find('option:not(:first)').remove();
                            $.each(response.categories, function(index, category) {
                                select.append('<option value="' + category.id + '">' + category.name + '</option>');
                            });
                        },
                        error: function() {
                            // If endpoint doesn't exist, just keep current categories
                            console.log('Could not refresh categories');
                        }
                    });
                }

                function refreshEditCategoryDropdown(selectedId) {
                    $.ajax({
                        url: '{{ route('backend.faq.categories.index') }}?ajax-list=1',
                        type: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        dataType: 'json',
                        success: function(response) {
                            var select = $('#edit_faq_category_select');
                            select.empty();
                            select.append('<option value="">Select a FAQ category</option>');
                            $.each(response.categories, function(index, category) {
                                var opt = $('<option/>').val(category.id).text(category.name);
                                if (parseInt(selectedId) === parseInt(category.id)) {
                                    opt.attr('selected', 'selected');
                                }
                                select.append(opt);
                            });
                        }
                    });
                }

                $('#addFaqForm').on('submit', function(e) {
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
                        url: '{{ route('backend.faqs.store') }}',
                        type: 'POST',
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: 'FAQ added successfully.',
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
                                    var feedback = input.siblings('.invalid-feedback');
                                    if (feedback.length === 0) {
                                        feedback = input.parent().find('.invalid-feedback');
                                    }
                                    feedback.text(errors[field][0]);
                                }
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: xhr.responseJSON?.message || 'Failed to add FAQ. Please try again.'
                                });
                            }
                        }
                    });
                });
                // Open Edit FAQ modal with data
                $(document).on('click', '.btn-edit-faq', function() {
                    var btn = $(this);
                    var id = btn.data('id');
                    var categoryId = btn.data('category_id');
                    $('#edit_faq_id').val(id);
                    $('#edit_faq_question').val(btn.data('question'));
                    $('#edit_faq_answer').val(btn.data('answer'));
                    $('#edit_faq_order').val(btn.data('order'));
                    $('#edit_faq_is_active').prop('checked', parseInt(btn.data('active')) === 1);
                    refreshEditCategoryDropdown(categoryId);

                    var modal = new bootstrap.Modal(document.getElementById('editFaqModal'));
                    modal.show();
                });

                // Submit Edit FAQ form
                $('#editFaqForm').on('submit', function(e) {
                    e.preventDefault();

                    var form = $(this);
                    var id = $('#edit_faq_id').val();
                    var formData = form.serialize();
                    var submitBtn = form.find('button[type="submit"]');
                    var originalText = submitBtn.html();

                    submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> Updating...');
                    form.find('.is-invalid').removeClass('is-invalid');
                    form.find('.invalid-feedback').text('');

                    $.ajax({
                        url: '{{ url('/dashboard/faqs/update') }}' + '/' + id,
                        type: 'POST',
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function() {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: 'FAQ updated successfully.',
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
                                    var feedback = input.siblings('.invalid-feedback');
                                    if (feedback.length === 0) {
                                        feedback = input.parent().find('.invalid-feedback');
                                    }
                                    feedback.text(errors[field][0]);
                                }
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: xhr.responseJSON?.message || 'Failed to update FAQ. Please try again.'
                                });
                            }
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
