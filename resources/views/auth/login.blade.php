<x-guest-layout>
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-4 text-center">
            <h2 class="fw-bold mb-1" style="color: var(--cc-tuna);">🎂 CloudCakes</h2>
            <p class="text-muted small mb-4">Silakan masuk ke akun toko Anda</p>

            @if (session('status'))
                <div class="alert alert-success small py-2 mb-3">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="text-start">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">Alamat Email</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus placeholder="nama@cloudcakes.com">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold">Kata Sandi</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="••••••••">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-check mb-3">
                    <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                    <label for="remember_me" class="form-check-label text-secondary small">Ingat saya</label>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2 fw-bold rounded-3">
                    Masuk
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>