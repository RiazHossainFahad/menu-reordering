<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    @php
        $app_id = env('SQUARE_APPLICATION_ID') ?? 'sandbox-sq0idb-wV8XtM3dWk1BEO76rd2BUA';
        $access_token = env('SQUARE_TOKEN') ?? 'EAAAECea8f5X5XjkuKj3k4BfyNPNQ8aRKSeFNYptoQFXnsed19TUISoMVIuo3sjU';
        $location_id = env('SQUARE_SANDBOX') ? env('SQUARE_LOCATION_ID') : null;
        $sandbox = env('SQUARE_SANDBOX') ?? true;
    @endphp

<title>My Payment Form</title>


<script type="text/javascript">
    window.applicationId = "{{ $app_id }}";
    window.locationId = "{{ $location_id }}";
</script>

<!-- link to the SqPaymentForm library -->
<script type="text/javascript" src="{{ !$sandbox ? 'https://js.squareup.com/v2/paymentform' : 'https://js.squareupsandbox.com/v2/paymentform' }}"></script>

<!-- link to the local SqPaymentForm initialization -->
<script type="text/javascript" src="/square/form-script.js"></script>

<!-- link to the custom styles for SqPaymentForm -->
<link rel="stylesheet" type="text/css" href="/square/form-style.css">
<style>
    .centered{
        width:100%;
        height:100%;
        min-width:400px;
        min-height:400px;
        position:absolute;
        top:50%;
        left:50%;
        transform:translate(-50%,-50%);
        background:#000;
        z-index: 99999;
        filter: blur(10px) contrast(20);
    }
    .blob-1,.blob-2{
        width:70px;
        height:70px;
        position:absolute;
        background:#fff;
        border-radius:50%;
        top:50%;left:50%;
        transform:translate(-50%,-50%);
    }
    .blob-1{
        left:20%;
        animation:osc-l 2.5s ease infinite;
    }
    .blob-2{
        left:80%;
        animation:osc-r 2.5s ease infinite;
        background:#0ff;
    }
    @keyframes osc-l{
        0%{left:20%;}
        50%{left:50%;}
        100%{left:20%;}
    }
    @keyframes osc-r{
        0%{left:80%;}
        50%{left:50%;}
        100%{left:80%;}
    }
</style>

</head>
<body>
    <div class="centered" id="loading">
        <div class="blob-1"></div>
        <div class="blob-2"></div>
    </div>
    <!-- Begin Payment Form -->
    <div class="sq-payment-form">
        
        <!--
            Square's JS will automatically hide these buttons if they are unsupported
            by the current device.
        -->
        <div id="sq-walletbox">
            <button id="sq-google-pay" class="button-google-pay"></button>
            <button id="sq-apple-pay" class="sq-apple-pay"></button>
            <button id="sq-masterpass" class="sq-masterpass"></button>
            <div class="sq-wallet-divider">
            <span class="sq-wallet-divider__text">Or</span>
            </div>
        </div>
        <div id="sq-ccbox">
            <!--
            You should replace the action attribute of the form with the path of
            the URL you want to POST the nonce to (for example, "/process-card").
            You need to then make a "Charge" request to Square's Payments API with
            this nonce to securely charge the customer.
            Learn more about how to setup the server component of the payment form here:
            https://developer.squareup.com/docs/payments-api/overview
            -->
            <form id="nonce-form" novalidate action="{{ route('payment.store') }}" method="post">
                <div id="error">
                    @if (Session::get('error_msg'))
                        <li>{!! Session::get('error_msg') !!}</li>
                    @endif
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    @endif
                    @if (Session::get('response_errors'))
                        @foreach (Session::get('response_errors') as $error)
                            <li>{{ $error->getDetail() }}</li>
                        @endforeach
                    @endif
                </div>

                @csrf

                <div class="sq-field">
                    <label class="sq-label">Card Number</label>
                    <div id="sq-card-number"></div>
                </div>
                <div class="sq-field-wrapper">
                    <div class="sq-field sq-field--in-wrapper">
                        <label class="sq-label">CVV</label>
                        <div id="sq-cvv"></div>
                    </div>
                    <div class="sq-field sq-field--in-wrapper">
                        <label class="sq-label">Expiration</label>
                        <div id="sq-expiration-date"></div>
                    </div>
                    <div class="sq-field sq-field--in-wrapper">
                        <label class="sq-label">Postal</label>
                        <div id="sq-postal-code"></div>
                    </div>
                </div>
                <div class="sq-field">
                    <button id="sq-creditcard" type="submit" class="sq-button" onclick="onGetCardNonce(event)">
                    Pay $100 Now
                    </button>
                </div>
                <div class="sq-field">
                    <button class="sq-button-cancel sq-button" type="button" onclick="cancelBtnClicked()">
                     Cancel
                    </button>
                </div>
                <!--
                    After a nonce is generated it will be assigned to this hidden input field.
                -->
                <input type="hidden" id="card-nonce" name="nonce">
            </form>
        </div>
    </div>
    <!-- End Payment Form -->

    <script>
        window.onload = () => {
            document.getElementById('loading').style.display = 'none';
        }
    </script>
</body>
</html>
