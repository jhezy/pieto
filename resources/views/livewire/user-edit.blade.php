<div class="mt-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('user-management') }}">User Management</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit User</li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <form wire:submit.prevent="update" class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nama</label>
                    <input type="text" class="form-control" wire:model="name">
                    @error('name') <div class="alert alert-danger mt-2">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" wire:model="email">
                    @error('email') <div class="alert alert-danger mt-2">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Password (Biarkan kosong jika tidak diganti)</label>
                    <input type="password" class="form-control" wire:model="password">
                    @error('password') <div class="alert alert-danger mt-2">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Role</label>
                    <select class="form-select" wire:model="role">
                        <option value="kasir">Kasir</option>
                        <option value="admin">Admin</option>
                    </select>
                    @error('role') <div class="alert alert-danger mt-2">{{ $message }}</div> @enderror
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('user-management') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>