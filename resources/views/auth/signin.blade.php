<x-guest-layout>
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @elseif (session()->has('failed'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('failed') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Card -->
    <div class="card smooth-shadow-md">
        <!-- Card body -->
        <div class="card-body p-6">
            <div class="mb-4">
                <a href="https://dapur.acehbaratkab.go.id" class="d-flex justify-content-center">
                    <img src="{{ asset('images/logos/logo.png') }}" class="img-fluid mb-6" alt="Pagus"
                        style="width: 40%">
                </a>
                <div class="text-center">
                    <p class="mb-5">Please enter your user information.</p>
                </div>
            </div>
            <!-- Form -->
            <form action="/login" method="post">
                @csrf
                <!-- Username -->
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="email" class="form-control @error('username') is-invalid @enderror" name="username"
                        id="username" placeholder="Enter your username" value="{{ old('username') }}" required
                        autofocus>
                    @error('username')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input class="form-control" type="password" placeholder="••••••••" name="password" id="password"
                        required>
                </div>
                <!-- Checkbox -->
                <div class="d-lg-flex justify-content-between align-items-center mb-4">
                    <div class="form-check custom-checkbox">
                        <input type="checkbox" class="form-check-input" id="showpsd">
                        <label class="form-check-label" for="showpsd">Show Password</label>
                    </div>
                </div>
                <div>
                    <!-- Button -->
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Sign in</button>
                    </div>
            </form>
        </div>
    </div>
</x-guest-layout>
