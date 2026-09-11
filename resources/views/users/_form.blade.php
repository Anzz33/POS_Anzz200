@csrf

<div class="card shadow border-0">

    <div class="card-header text-white" style="background: linear-gradient(135deg, #d4af37 0%, #b8860b 100%) !important;">
        <h4 class="mb-0 fw-bold">
            👤 Data User
        </h4>
    </div>

    <div class="card-body">

        <div class="row">

            <!-- Nama -->
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">
                    Nama <span class="text-danger">*</span>
                </label>

                <input
                    type="text"
                    name="name"
                    class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', $user->name ?? '') }}"
                    placeholder="Masukkan nama lengkap">

                @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <!-- Email -->
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">
                    Email <span class="text-danger">*</span>
                </label>

                <input
                    type="email"
                    name="email"
                    class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email', $user->email ?? '') }}"
                    placeholder="Masukkan email">

                @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <!-- Password -->
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">
                    Password

                    @isset($user)
                    <small class="text-muted">(Kosongkan jika tidak diubah)</small>
                    @endisset

                </label>

                <input
                    type="password"
                    name="password"
                    class="form-control @error('password') is-invalid @enderror"
                    placeholder="Masukkan password">

                @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <!-- Role -->
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">
                    Role <span class="text-danger">*</span>
                </label>

                <select
                    name="role_id"
                    class="form-select @error('role_id') is-invalid @enderror">

                    <option value="">
                        -- Pilih Role --
                    </option>

                    @foreach($roles as $role)

                    <option
                        value="{{ $role->id }}"
                        @selected(old('role_id', $user->role_id ?? '') == $role->id)>

                        {{ ucfirst($role->name) }}

                    </option>

                    @endforeach

                </select>

                @error('role_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror

            </div>

        </div>

    </div>

    <div class="card-footer bg-white text-end">

        <!-- Perubahan pada route tombol kembali -->
        <a href="{{ route('users.index') }}"
            class="btn btn-secondary">

            ← Kembali

        </a>

        <button
            type="submit"
            class="btn btn-success">

            💾 Simpan

        </button>

    </div>

</div>