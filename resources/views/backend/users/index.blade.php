@extends('layouts.backend')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Users Management</h1>
        <p class="page-description">Manage user accounts and permissions</p>
    </div>

    <!-- Users Table -->
    <div class="data-table-container">
        <div class="table-header">
            <h3 class="table-title">All Users</h3>
            <div class="table-actions">
                <a href="{{ route('backend.users.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i>
                    Add New User
                </a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Last Login</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>
                                <div class="user-badge">
                                    <div class="user-badge-image">
                                        <img src="{{ get_user_image($user->image) }}" alt="User Image">
                                    </div>
                                    <div class="user-badge-content">
                                        <h5 class="user-name">{{ $user->name }}</h5>
                                        <p class="user-role">{{ get_user_role($user->role) }}</p>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge {{ $user->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                                    {{ ucfirst($user->status) }}
                                </span>
                            </td>
                            <td>{{ $user->formatted_last_login_at }}</td>
                            <td>
                                @if ($user->role != 'super_admin' || isSuperAdmin())
                                    <a href="{{ route('backend.users.edit', $user->id) }}" class="btn btn-primary">Edit</a>
                                    @if ($user->id != auth()->user()->id)
                                        <button data-id="{{ $user->id }}" class="btn btn-danger delete-user">Delete</button>
                                    @endif
                                @else
                                    <button class="btn btn-secondary">😒</button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No users found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.delete-user').click(function() {
                var id = $(this).data('id');
                var url = "{{ route('backend.users.destroy', ':id') }}";
                url = url.replace(':id', id);
                delete_warning(url);
            });
        });
    </script>
@endpush
