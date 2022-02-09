<div hidden id="hidden_register">
    <div class="modal-body mx-3 border-0">
        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}" id="registerForm">
            @csrf
            <!-- Name -->
            <div class="md-form mb-4">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-5">
                            <x-label for="name" :value="__('Meno')" />
                        </div>
                        <div class="col-md-7">
                            <x-input id="name" class="form-control validate" type="text" name="name" :value="old('name')" required autofocus />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Email Address -->
            <div class="md-form mb-4">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-5">
                            <x-label for="email" :value="__('Email')" />
                        </div>
                        <div class="col-md-7">
                            <x-input id="email" class="form-control validate" type="email" name="email" :value="old('email')" required />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Password -->
            <div class="md-form mb-4">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-5">
                            <x-label for="password" :value="__('Heslo')" />
                        </div>
                        <div class="col-md-7">
                            <x-input id="password" class="form-control validate"
                                            type="password"
                                            name="password"
                                            required autocomplete="new-password" />
                            </div>
                        </div>
                    </div>
            </div>

            <!-- Confirm Password -->
            <div class="md-form mb-4">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-5">
                            <x-label for="password_confirmation" :value="__('Potvrdenie hesla')" />
                        </div>
                        <div class="col-md-7">
                            <x-input id="password_confirmation" class="form-control validate"
                                            type="password"
                                            name="password_confirmation" required />
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer d-flex justify-content-center border-0">
                <button class="btn btn-outline-secondary">
                    {{ __('Registrovať') }}
                </button>
            </div>
        </form>
    </div>
</div>



