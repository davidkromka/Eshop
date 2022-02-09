<div hidden id="hidden_login">
    <div class="modal-body mx-3 border-0">

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div class="md-form mb-5">
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="form-control validate" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <!-- Password -->
            <div class="md-form mb-5">
                <x-label for="password" :value="__('Heslo')" />

                <x-input id="password" class="form-control validate"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Zapamätať si ma') }}</span>
                </label>
            </div>

            <div class="modal-footer d-flex justify-content-center border-0">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                        {{ __('Zabudli ste heslo?') }}
                    </a>
                @endif

                <button class="btn btn-outline-secondary">
                    {{ __('Prihlásiť') }}
                </button>
            </div>
        </form>
    </div>
</div>
