@push('title')
    Settings
@endpush
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/bs-stepper/bs-stepper.css') }}" />
<x-app-layout>

    <div>
        <div class="bs-stepper wizard-vertical vertical wizard-vertical-icons-example mt-2">
            <div class="bs-stepper-header">
                <div class="step" data-target="#general-settings">
                    <button type="button" class="step-trigger">
                        <span class="bs-stepper-circle">
                            <i class='bx bx-home-alt'></i>
                        </span>
                        <span class="bs-stepper-label">
                            <span class="bs-stepper-title">General Settings</span>
                            <span class="bs-stepper-subtitle">Setup General Settings</span>
                        </span>
                    </button>
                </div>
                <div class="line"></div>
                <div class="step" data-target="#theme-settings">
                    <button type="button" class="step-trigger">
                        <span class="bs-stepper-circle">
                            <i class='bx bxs-palette'></i>
                        </span>
                        <span class="bs-stepper-label">
                            <span class="bs-stepper-title">Theme Settings</span>
                            <span class="bs-stepper-subtitle">Setup Theme Settings</span>
                        </span>
                    </button>
                </div>
                <div class="line"></div>
                <div class="step" data-target="#module-settings">
                    <button type="button" class="step-trigger">
                        <span class="bs-stepper-circle">
                            <i class='bx bxs-objects-horizontal-left'></i>
                        </span>
                        <span class="bs-stepper-label">
                            <span class="bs-stepper-title">Module Settings</span>
                            <span class="bs-stepper-subtitle">Setup Module Settings</span>
                        </span>
                    </button>
                </div>
                <div class="line"></div>
                <div class="step" data-target="#auth-settings">
                    <button type="button" class="step-trigger">
                        <span class="bs-stepper-circle">
                            <i class='bx bxs-user-rectangle'></i>
                        </span>
                        <span class="bs-stepper-label">
                            <span class="bs-stepper-title">Authentication Settings</span>
                            <span class="bs-stepper-subtitle">Setup User Authentications</span>
                        </span>
                    </button>
                </div>
                <div class="line"></div>
                <div class="step" data-target="#google-settings">
                    <button type="button" class="step-trigger">
                        <span class="bs-stepper-circle">
                            <i class='bx bxl-google'></i>
                        </span>
                        <span class="bs-stepper-label">
                            <span class="bs-stepper-title">Google Settings</span>
                            <span class="bs-stepper-subtitle">Setup Google OAuth</span>
                        </span>
                    </button>
                </div>

            </div>
            <div class="bs-stepper-content">
                @include('settings.partials.general')
                @include('settings.partials.theme')
                @include('settings.partials.module')
                @include('settings.partials.auth')
                @include('settings.partials.google')
            </div>


        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@jaames/iro@5"></script>
    <script src="../../assets/vendor/libs/bs-stepper/bs-stepper.js"></script>
    <script src="../../assets/js/form-wizard-icons.js"></script>
    <script>
        var colorPicker = new iro.ColorPicker(".colorPicker", {
            width: 280,
            color: "#000000ff",
            borderWidth: 0,
            layoutDirection: "horizontal",
            layout: [{
                component: iro.ui.Box,
            },
            {
                component: iro.ui.Slider,
                options: {
                    sliderType: 'hue'
                }
            }
            ]
        });

        var values = document.getElementById("values");
        var hexInput = document.getElementById("hexInput");

        colorPicker.on(["color:init", "color:change"], function (color) {
            values.innerHTML = [
                "hex: " + color.hexString,
                "rgb: " + color.rgbString,
                "hsl: " + color.hslString,
            ].join("<br>");

            hexInput.value = color.hexString;
        });

        hexInput.addEventListener('change', function () {
            colorPicker.color.hexString = this.value;
            console.log(this.value);
        });
    </script>
    <script>
        document.getElementById('enable_recaptcha').addEventListener('change', function () {
            let isEnabled = this.value == '1';
            let keysDiv = document.getElementById('recaptcha-keys');
            keysDiv.style.display = isEnabled ? 'block' : 'none';
            document.getElementById('recaptcha_site_key').required = isEnabled;
            document.getElementById('recaptcha_secret_key').required = isEnabled;
        });
    </script>
</x-app-layout>