@include('auth.register')
@include('auth.login')
@unless (Auth::check())
<div class="modal fade" id="modal_login_register" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-center border-0">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-3 content-left border-right text-center" id="login_underline">
                            <button class="btn btn-defaulty" id="login_choice">Prihlásenie</button>
                        </div>

                        <div class="col-md-3 content-right border-left text-center" id="register_underline">
                            <button class="btn btn-default" id="register_choice">Registrácia</button>
                        </div>
                        <div class="col-md-3"></div>
                    </div>
                </div>
            </div>

            <div class="modal-content border-0" id="login_register">

            </div>
        </div>
    </div>
</div>
@endunless
