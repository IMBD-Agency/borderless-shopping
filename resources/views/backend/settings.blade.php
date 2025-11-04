@extends('layouts.backend')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Settings</h1>
        <p class="page-description">Manage your settings</p>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header">Contact Information</div>
                <div class="card-body">
                    <form action="{{ route('backend.settings.contact.update') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', optional($contact)->email) }}" required>
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone', optional($contact)->phone) }}" required>
                            @error('phone')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">WhatsApp</label>
                            <input type="text" name="whatsapp" class="form-control" value="{{ old('whatsapp', optional($contact)->whatsapp) }}" required>
                            @error('whatsapp')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Youtube Tutorial</label>
                            <input type="text" name="youtube_tutorial" class="form-control" value="{{ old('youtube_tutorial', optional($contact)->youtube_tutorial) }}" required>
                            @error('youtube_tutorial')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Save Contact</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header">Social Media Links</div>
                <div class="card-body">
                    <form action="{{ route('backend.settings.social-media.update') }}" method="POST">
                        @csrf
                        <div id="social-media-list">
                            @php $oldItems = collect(old('items', [])); @endphp
                            @foreach ($oldItems->isNotEmpty() ? $oldItems : $socialMedia ?? collect() as $index => $item)
                                <div class="border rounded p-3 mb-3">
                                    <input type="hidden" name="items[{{ $index }}][id]" value="{{ is_array($item) ? $item['id'] ?? '' : $item->id }}">
                                    <input type="hidden" name="items[{{ $index }}][_delete]" value="0">
                                    <div class="mb-2">
                                        <label class="form-label">Name</label>
                                        <input type="text" name="items[{{ $index }}][name]" class="form-control" value="{{ is_array($item) ? $item['name'] ?? '' : $item->name }}" required>
                                        @error('items.' . $index . '.name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">URL</label>
                                        <input type="url" name="items[{{ $index }}][url]" class="form-control" value="{{ is_array($item) ? $item['url'] ?? '' : $item->url }}" required>
                                        @error('items.' . $index . '.url')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">Icon class</label>
                                        <input type="text" name="items[{{ $index }}][icon]" class="form-control" value="{{ is_array($item) ? $item['icon'] ?? '' : $item->icon }}" placeholder="e.g. fab fa-facebook" required>
                                        @error('items.' . $index . '.icon')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <button type="button" class="btn btn-sm btn-danger" onclick="removeSocialRow(this)">Remove</button>
                                </div>
                            @endforeach
                        </div>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-outline-secondary" onclick="addSocialRow()">Add Row</button>
                            <button type="submit" class="btn btn-primary">Save Social Media</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            let socialIndex = document.querySelectorAll('#social-media-list > div').length;

            function addSocialRow() {
                const container = document.getElementById('social-media-list');
                const wrapper = document.createElement('div');
                wrapper.className = 'border rounded p-3 mb-3';
                wrapper.innerHTML = `
				<input type="hidden" name="items[${socialIndex}][id]" value="">
				<input type="hidden" name="items[${socialIndex}][_delete]" value="0">
				<div class="mb-2">
					<label class="form-label">Name</label>
					<input type="text" name="items[${socialIndex}][name]" class="form-control" required>
				</div>
				<div class="mb-2">
					<label class="form-label">URL</label>
					<input type="url" name="items[${socialIndex}][url]" class="form-control" required>
				</div>
				<div class="mb-2">
					<label class="form-label">Icon class</label>
					<input type="text" name="items[${socialIndex}][icon]" class="form-control" placeholder="e.g. fab fa-facebook" required>
				</div>
			<button type="button" class="btn btn-sm btn-danger" onclick="removeSocialRow(this)">Remove</button>
			`;
                container.appendChild(wrapper);
                socialIndex++;
            }

            function removeSocialRow(button) {
                const row = button.closest('.border.rounded.p-3.mb-3');
                const idInput = row.querySelector('input[name*="[id]"]');
                const deleteInput = row.querySelector('input[name*="[_delete]"]');
                if (idInput && idInput.value) {
                    // existing row: flag for deletion and hide
                    if (deleteInput) deleteInput.value = '1';
                    row.style.display = 'none';
                } else {
                    // new, unsaved row: remove from DOM
                    row.remove();
                }
            }
        </script>
    @endpush
@endsection
