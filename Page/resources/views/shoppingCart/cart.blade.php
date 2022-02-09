<?php $url = explode('/', Illuminate\Support\Facades\Request::fullUrl())[2] . '/orders'; ?>
@extends('layouts.app')

@section('title', 'Cart')

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bs-stepper/dist/js/bs-stepper.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bs-stepper/dist/css/bs-stepper.min.css">
    <script src="{{ asset('js/cart.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/cart_style.css') }}">
@endsection

@section('main')
    <!--stepper-->
    <main id="CartStepper" class="bs-stepper">
        <div class="bs-stepper-header" role="tablist">
            <div class="d-none d-sm-block step" data-target="#content1">
                <button type="button" class="step-trigger" role="tab" id="CartSteppertrigger1" aria-controls="content1">
                    <span class="bs-stepper-circle">1</span>
                    <span class="bs-stepper-label">Nákupný košík</span>
                </button>
            </div>
            <div class="d-none d-md-block bs-stepper-line"></div>
            <div class="d-none d-sm-block step" data-target="#content2">
                <button type="button" class="step-trigger" role="tab" id="CartSteppertrigger2" aria-controls="content2">
                    <span class="bs-stepper-circle">2</span>
                    <span class="bs-stepper-label">Doprava a platba</span>
                </button>
            </div>
            <div class="d-none d-md-block bs-stepper-line"></div>
            <div class="d-none d-sm-block step" data-target="#content3">
                <button type="button" class="step-trigger" role="tab" id="CartSteppertrigger3" aria-controls="content3">
                    <span class="bs-stepper-circle">3</span>
                    <span class="bs-stepper-label">Informácie</span>
                </button>
            </div>
            <div class="d-none d-md-block bs-stepper-line"></div>
            <div class="d-none d-sm-block step" data-target="#content4">
                <button type="button" class="step-trigger" role="tab" id="CartSteppertrigger4" aria-controls="content4">
                    <span class="bs-stepper-circle">4</span>
                    <span class="bs-stepper-label">Zhrnutie</span>
                </button>
            </div>
        </div>
        <div class="bs-stepper-content">
            <form action="{{ url('orders') }}" method="post" id="orderForm"><!--onSubmit="return false">-->
            </form>
            <input form="orderForm" type="hidden" name="_token" value="{{ csrf_token() }}">

            <!--Shopping cart-->
            <div id="content1" role="tabpanel" class="bs-stepper-pane container-fluid" aria-labelledby="CartSteppertrigger1">
                <div class="row">
                    <!--product in cart information-->
                    <section class="col-lg-9 col-md-12">
                        @isset($products)
                            @foreach($products as $product)
                                <div class="card flex-row p-3 m-5 product" id="{{ $product[4] }}">
                                    <div class="row">
                                        <img class="img-product ml-3" id="productImage{{ $product[4] }}" src="{{ asset('images/'.$product[0]->src_image) }}" alt="{{$product[0]->name}}" />
                                        <div class="card-basic p-0 mx-5">
                                            <h5 class="card-title productName" id="productName{{  $product[4] }}">{{$product[0]->name}}</h5>
                                            <p class="card-text productSize"   id="productSize{{  $product[4] }}">Veľkosť: {{ $product[3] }}</p>
                                            <p class="card-text productColor"  id="productColor{{ $product[4] }}">Farba: {{ $product[2] }}</p>
                                            <p class="card-text productPrice"  id="productPrice{{ $product[4] }}">{{$product[0]->price}} €</p>
                                        </div>
                                        <div class="card-count p-0 mx-5">
                                            <!--<form action="">

                                            </form>-->
                                            <label for="{{$product[4]}}" class="card-text m-0">Počet:</label>
                                            <form action="{{ url("/count") }}" method="get">
                                                <input class="productCount" name="count" id="productCount{{$product[4]}}" type="number" value="{{$product[1]}}" min="1" max="1000" step="1" />
                                                <input type="hidden" value="{{$product[4]}}" name="id">
                                                <input type="submit" class="btn btn-outline-secondary mt-1" value="Potvrdiť"/>
                                            </form>
                                            <input hidden type="text" form="orderForm" name="productCount_{{$product[4]}}" value="{{$product[1]}}"/>
                                            <input hidden type="text" form="orderForm" name="productPrice_{{$product[4]}}" value="{{$product[0]->price}}"/>

                                            <form action="{{url('cart', $product[0])}}" method="post">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="product" value="{{$product[4]}}">
                                                {{ csrf_field() }}
                                                <input type="submit" class="btn btn-outline-secondary mt-1" value="Odobrať"/>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endisset
                    </section>
                    <!--contact, sale code, summary-->
                    <aside class="col-lg-3 col-md-12 mt-5">
                        <div class="card p-2">
                            <div class="card-body">
                                <h5 class="card-title">Kontakt</h5>
                                <h6>E-mail:</h6>
                                <p>objednavky@wtechshop.sk</p>
                                <h6>Telefón</h6>
                                <p>+421 917 819 325</p>
                            </div>
                        </div>

                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Zľavový kód">
                            <button class="btn btn-outline-secondary" type="button">Potvrdiť</button>
                        </div>
                        <div class="card p-2">
                            <div class="card-body">
                                <h5 class="card-title">Celková suma</h5>
                                <p>Spolu: {{$price}} €</p>
                                <p>Zľavy: 0 €</p>
                                <p class="font-weight-bold" id="sumProducts">Celková cena: {{$price}} €</p>
                                <p>Celková cena bez DPH: {{$tax_free}} €</p>
                                <button type="button" class="btn btn-primary btnNext" id="showDeliveryPayment">Ďalej</button>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>

            <!--delivery and payment-->
            <div id="content2" role="tabpanel" class="bs-stepper-pane container-fluid" aria-labelledby="CartSteppertrigger2">
                <div class="row">
                    <section class="col-md-8">
                        <div class="card mb-3">
                            <h5>Zvoľte spôsob dopravy:</h5>
                            @foreach($deliveryOptions as $option)
                                <div class="form-check">
                                    <input form="orderForm" class="form-check-input deliveryRadio" type="radio" name="Delivery" id="delivery_radio{{ $option->id }}"  value="{{ $option->id }}" checked>
                                    <label class="form-check-label" for="delivery_radio{{ $option->id }}" id="delivery_text{{ $option->id }}">{{ $option->name }}:</label>
                                    <label class="form-check-label" for="delivery_radio{{ $option->id }}" id="delivery_price{{ $option->id }}">{{ $option->price }} €</label>
                                </div>
                            @endforeach
                            <!--
                            <div class="form-check">
                                <input form="orderForm" class="form-check-input deliveryRadio" type="radio" name="radioDelivery" id="delivery_courier_radio"  value="deliveryCourierRadio" checked>
                                <label class="form-check-label" for="delivery_courier_radio" id="delivery_courier_text">Kuriérom na adresu:</label>
                                <label class="form-check-label" id="delivery_courier_price" for="delivery_courier_radio">3,99 €</label>
                            </div>
                            <div class="form-check">
                                <input form="orderForm" class="form-check-input deliveryRadio" type="radio" name="radioDelivery" id="delivery_postoffice_radio" value="deliveryPostOfficeRadio">
                                <label class="form-check-label" for="delivery_postoffice_radio" id="delivery_postoffice_text">Balík na poštu:</label>
                                <label class="form-check-label" id="delivery_postoffice_price" for="delivery_postoffice_radio">2,60 €</label>
                            </div>
                            <div class="form-check">
                                <input form="orderForm" class="form-check-input deliveryRadio" type="radio" name="radioDelivery" id="delivery_inperson_radio" value="deliveryInPersonRadio">
                                <label class="form-check-label" for="delivery_inperson_radio" id="delivery_inperson_text">Osobne na predajni:</label>
                                <label class="form-check-label" id="delivery_inperson_price" for="delivery_inperson_radio">0,00 €</label>
                            </div>       -->
                        </div>

                        <div class="card">
                            <h5>Zvoľte spôsob platby:</h5>
                            @foreach($paymentOptions as $option)
                                <div class="form-check">
                                    <input form="orderForm" class="form-check-input paymentRadio" type="radio" name="Payment" id="payment_radio{{ $option->id }}"  value="{{ $option->id }}" checked>
                                    <label class="form-check-label" for="payment_radio{{ $option->id }}" id="payment_text{{ $option->id }}">{{ $option->name }}:</label>
                                    <label class="form-check-label" for="payment_radio{{ $option->id }}" id="payment_price{{ $option->id }}">{{ $option->price }} €</label>
                                </div>
                            @endforeach

                        </div>
                    </section>
                    <aside class="col-md-4">
                        <div class="card p-2">
                            <div class="card-body">
                                <h5 class="card-title">Kontakt</h5>
                                <h6>E-mail:</h6>
                                <p>objednavky@wtechshop.sk</p>
                                <h6>Telefón</h6>
                                <p>+421 917 819 325</p>
                            </div>
                        </div>

                        <div class="card p-2">
                            <div class="card-body">
                                <h5 class="card-title">Celková suma</h5>
                                <p>Celkom za tovar: {{$price}} €</p>
                                <p id="deliveryFee"></p><!--Doprava: +3,99 €</p>-->
                                <p id="paymentFee"></p><!--Platba:  +0,00 €</p>-->
                                <p class="font-weight-bold" id="sumPaymentDelivery">Celková cena: {{$price}} €</p>
                                <p id="sumPaymentDeliveryTaxFree">Celková cena bez DPH: {{$tax_free}} €</p>
                                <div class="row">
                                    <button class="btn btn-primary btnPrev mx-3" id="hideDeliveryPayment" type="button">Späť</button>
                                    <button class="btn btn-primary btnNext ml-3" id="showPersonalInfo" type="button">Ďalej</button>
                                </div>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>

            <!--personal and delivery information-->
            <div id="content3" role="tabpanel" class="bs-stepper-pane container-fluid" aria-labelledby="CartSteppertrigger4">
                <div class="row">
                    <section class="col-md-8">
                        <h5>Osobné údaje:</h5>

                        <div class="md-form mb-5">
                            <label data-error="wrong" data-success="right" for="personalInfoFirstName">Meno:</label>
                            <input form="orderForm" name="personalInfoFirstName" type="text" id="personalInfoFirstName" class="form-control validate">
                        </div>
                        <div class="md-form mb-5">
                            <label data-error="wrong" data-success="right" for="personalInfoLastName">Priezvisko:</label>
                            <input form="orderForm" name="personalInfoLastName" type="text" id="personalInfoLastName" class="form-control validate">
                        </div>
                        <div class="md-form mb-5">
                            <label data-error="wrong" data-success="right" for="personalInfoPhone">Telefón:</label>
                            <input form="orderForm" name="personalInfoPhone" type="tel" id="personalInfoPhone" class="form-control validate">
                        </div>
                        <div class="md-form mb-5">
                            <label data-error="wrong" data-success="right" for="personalInfoEmail">E-mail:</label>
                            <input form="orderForm" name="personalInfoEmail" type="email" id="personalInfoEmail" class="form-control validate">
                        </div>

                        <h5>Doručovania adresa:</h5>
                        <input hidden type="text" form="orderForm" name="deliveryAddress" id="deliveryAddress" />
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="personalInfoCountry" data-toggle="dropdown" aria-expanded="false">
                                Krajina
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                @foreach($countries as $country)
                                    <p class="dropdown-item country">{{ $country->name }} </p>
                                @endforeach
                            </div>
                        </div>
                        <div class="md-form mb-5">
                            <label data-error="wrong" data-success="right" for="personalInfoCity">Mesto:</label>
                            <input type="text" id="personalInfoCity" class="form-control validate">
                        </div>
                        <div class="md-form mb-5">
                            <label data-error="wrong" data-success="right" for="personalInfoStreet">Ulica + popisné číslo:</label>
                            <input type="text" id="personalInfoStreet" class="form-control validate">
                        </div>
                        <div class="md-form mb-5">
                            <label data-error="wrong" data-success="right" for="personalInfoPSC">PSČ:</label>
                            <input type="text" id="personalInfoPSC" class="form-control validate">
                        </div>

                        <h5>Fakturačná adresa (len ak je iná ako doručovacia):</h5>
                        <input hidden type="text" form="orderForm" name="billingAddress" id="billingAddress" />
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="personalInfoCountry2" data-toggle="dropdown" aria-expanded="false">
                                Krajina
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                @foreach($countries as $country)
                                    <p class="dropdown-item country2">{{ $country->name }} </p>
                                @endforeach
                            </div>
                        </div>
                        <div class="md-form mb-5">
                            <label data-error="wrong" data-success="right" for="personalInfoCity2">Mesto:</label>
                            <input type="text" id="personalInfoCity2" class="form-control validate">
                        </div>
                        <div class="md-form mb-5">
                            <label data-error="wrong" data-success="right" for="personalInfoStreet2">Ulica + popisné číslo:</label>
                            <input type="text" id="personalInfoStreet2" class="form-control validate">
                        </div>
                        <div class="md-form mb-5">
                            <label data-error="wrong" data-success="right" for="personalInfoPSC2">PSČ:</label>
                            <input type="text" id="personalInfoPSC2" class="form-control validate">
                        </div>
                    </section>
                    <aside class="col-md-4">
                        <div class="card p-2">
                            <div class="card-body">
                                <h5 class="card-title">Kontakt</h5>
                                <h6>E-mail:</h6>
                                <p>objednavky@wtechshop.sk</p>
                                <h6>Telefón</h6>
                                <p>+421 917 819 325</p>
                            </div>
                        </div>

                        <div class="card p-2">
                            <div class="card-body">
                                <h5 class="card-title">Celková suma</h5>
                                <p class="font-weight-bold" id="sumInfo">Celková cena: 322,32 €</p>
                                <p id="sumInfoTaxFree">Celková cena bez DPH: 258,60 €</p>
                                <div class="row">
                                    <button class="btn btn-primary btnPrev mx-3" type="button" id="hidePersonalInfo">Späť</button>
                                    <button class="btn btn-primary btnNext ml-3" type="button" id="showSummary">Ďalej</button>
                                </div>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>

            <!--summary-->
            <div id="content4" role="tabpanel" class="bs-stepper-pane container-fluid" aria-labelledby="CartSteppertrigger4">
                <div class="row">
                    <section class="col-md-8" id="summaryContent">

                    </section>
                    <aside class="col-md-4">
                        <div class="card p-2">
                            <div class="card-body">
                                <h5 class="card-title">Kontakt</h5>
                                <h6>E-mail:</h6>
                                <p>objednavky@wtechshop.sk</p>
                                <h6>Telefón</h6>
                                <p>+421 917 819 325</p>
                            </div>
                        </div>

                        <div class="card p-2">
                            <div class="card-body">
                                <h5 class="card-title">Celková suma</h5>
                                <p class="font-weight-bold" id="sumSummary">Celková cena: 322,32 €</p>
                                <p id="sumSummaryTaxFree">Celková cena bez DPH: 258,60 €</p>

                                <div class="row">
                                    <input class="mt-2" type="checkbox" id="bussinessTermsCheckbox">
                                    <label>Súhlasím s obchodnými podmienkami</label>
                                </div>

                                <div class="row">
                                    <button class="btn btn-primary btnPrev mx-3" type="button" id="hideSummary">Späť</button>
                                    <input form="orderForm"  class="btn btn-primary btnNext ml-3" value="Potvdiť" type="submit" id="confirmOrder"/>
                                </div>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </main>
@endsection

