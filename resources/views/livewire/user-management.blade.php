<div class="mt-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">User Management</li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <div class="row align-items-center mb-3">
                <div class="col-md-8">
                    <a href="{{ url('user-management/create') }}" class="btn btn-primary">+ Tambah User</a>
                </div>

            </div>

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Password</th>
                            <th>Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>*****************</td>
                            <td>{{ ucfirst($user->role) }}</td>
                            <td>
                                <a href="{{ route('user.edit', $user->id) }}" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>

                                <button class="btn btn-danger btn-sm" wire:click="delete({{ $user->id }})" onclick="return confirm('Hapus user ini?')">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">Tidak ada user ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="row">
                <div class="col-md-1">
                    <label class="form-label">Per Page</label>
                    <select wire:model="perPage" class="form-select">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                    </select>
                </div>
                <div class="col-md-11">
                    {{ $users->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>