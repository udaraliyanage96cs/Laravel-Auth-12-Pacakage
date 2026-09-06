<x-guest-layout>
    <h4 class="mb-2">Two-Factor Authentication 🛡️</h4>
    <p class="mb-4">We have sent a 6-digit verification code to your email. Please enter it below to complete your login.</p>

    @if (session('status'))
        <div class="alert alert-success mb-3">{{ session('status') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger mb-3">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('login.otp.verify') }}" id="otp-form">
        @csrf
        <input type="hidden" id="otp" name="otp" value="{{ old('otp') }}" />
        
        <div class="mb-3">
            <label class="form-label d-block text-muted small fw-semibold text-uppercase mb-2" style="letter-spacing: 0.5px;">Verification Code (OTP)</label>
            <div class="d-flex justify-content-between gap-2 my-3" id="otp-inputs-container">
                <input type="text" class="form-control text-center fs-4 fw-bold otp-box" maxlength="1" pattern="[0-9]*" inputmode="numeric" autocomplete="one-time-code" autofocus style="height: 52px;" />
                <input type="text" class="form-control text-center fs-4 fw-bold otp-box" maxlength="1" pattern="[0-9]*" inputmode="numeric" style="height: 52px;" />
                <input type="text" class="form-control text-center fs-4 fw-bold otp-box" maxlength="1" pattern="[0-9]*" inputmode="numeric" style="height: 52px;" />
                <input type="text" class="form-control text-center fs-4 fw-bold otp-box" maxlength="1" pattern="[0-9]*" inputmode="numeric" style="height: 52px;" />
                <input type="text" class="form-control text-center fs-4 fw-bold otp-box" maxlength="1" pattern="[0-9]*" inputmode="numeric" style="height: 52px;" />
                <input type="text" class="form-control text-center fs-4 fw-bold otp-box" maxlength="1" pattern="[0-9]*" inputmode="numeric" style="height: 52px;" />
            </div>
            <x-input-error :messages="$errors->get('otp')" class="mt-2 text-center"
                style="color: red;list-style-type: none; margin: 0;padding: 0" />
        </div>
        
        <button class="btn btn-success d-grid w-100 mb-3" type="submit">Verify Code</button>
    </form>

    <div class="text-center mt-3">
        <form method="POST" action="{{ route('login.otp.resend') }}" id="resend-form">
            @csrf
            <span>Didn't get the code?</span>
            <button type="submit" id="resend-btn" class="btn btn-link p-0 align-baseline text-success fw-semibold text-decoration-none ms-1">
                Resend OTP
            </button>
            <span id="cooldown-timer" class="text-muted ms-1" style="font-size: 0.85rem; display: none;"></span>
        </form>
    </div>

    <div class="text-center mt-3">
        <a href="{{ route('login') }}" class="btn btn-link p-0 text-muted" style="text-decoration: none; font-size: 0.85rem;">
            <i class="bx bx-left-arrow-alt"></i> Back to Login
        </a>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const otpForm = document.getElementById('otp-form');
            const hiddenOtp = document.getElementById('otp');
            const otpBoxes = Array.from(document.querySelectorAll('.otp-box'));

            function updateHiddenOtp() {
                hiddenOtp.value = otpBoxes.map(box => box.value).join('');
            }

            // Restore from hidden value if present (e.g. old input)
            if (hiddenOtp.value) {
                const val = hiddenOtp.value.trim();
                otpBoxes.forEach((box, i) => {
                    box.value = val[i] || '';
                });
            }

            otpBoxes.forEach((box, index) => {
                box.addEventListener('focus', function () {
                    this.select();
                });

                box.addEventListener('input', function (e) {
                    const val = this.value.replace(/[^0-9]/g, '');
                    if (val.length > 1) {
                        const digits = val.split('').slice(0, 6 - index);
                        digits.forEach((digit, idx) => {
                            if (otpBoxes[index + idx]) {
                                otpBoxes[index + idx].value = digit;
                            }
                        });
                        const nextIndex = Math.min(index + digits.length, 5);
                        otpBoxes[nextIndex].focus();
                    } else {
                        this.value = val;
                        if (val && index < 5) {
                            otpBoxes[index + 1].focus();
                        }
                    }
                    updateHiddenOtp();
                });

                box.addEventListener('keydown', function (e) {
                    if (e.key === 'Backspace') {
                        if (!this.value && index > 0) {
                            otpBoxes[index - 1].focus();
                            otpBoxes[index - 1].value = '';
                        } else {
                            this.value = '';
                        }
                        updateHiddenOtp();
                        e.preventDefault();
                    } else if (e.key === 'ArrowLeft' && index > 0) {
                        otpBoxes[index - 1].focus();
                        e.preventDefault();
                    } else if (e.key === 'ArrowRight' && index < 5) {
                        otpBoxes[index + 1].focus();
                        e.preventDefault();
                    }
                });

                box.addEventListener('paste', function (e) {
                    e.preventDefault();
                    const pasteData = (e.clipboardData || window.clipboardData).getData('text');
                    const digits = pasteData.replace(/[^0-9]/g, '').slice(0, 6);
                    if (digits) {
                        digits.split('').forEach((char, i) => {
                            if (otpBoxes[i]) {
                                otpBoxes[i].value = char;
                            }
                        });
                        updateHiddenOtp();
                        const focusIndex = Math.min(digits.length, 5);
                        otpBoxes[focusIndex].focus();
                    }
                });
            });

            otpForm.addEventListener('submit', function () {
                updateHiddenOtp();
            });

            // Resend timer handling
            const resendForm = document.getElementById('resend-form');
            const resendBtn = document.getElementById('resend-btn');
            const cooldownTimer = document.getElementById('cooldown-timer');
            
            let cooldown = parseInt(localStorage.getItem('otp_resend_cooldown') || '0');
            const now = Math.floor(Date.now() / 1000);

            if (cooldown > now) {
                startTimer(cooldown - now);
            }

            resendForm.addEventListener('submit', function () {
                const expireTime = Math.floor(Date.now() / 1000) + 60;
                localStorage.setItem('otp_resend_cooldown', expireTime.toString());
            });

            function startTimer(seconds) {
                resendBtn.disabled = true;
                resendBtn.style.opacity = '0.5';
                resendBtn.style.pointerEvents = 'none';
                cooldownTimer.style.display = 'inline';
                
                const interval = setInterval(function () {
                    if (seconds <= 0) {
                        clearInterval(interval);
                        resendBtn.disabled = false;
                        resendBtn.style.opacity = '1';
                        resendBtn.style.pointerEvents = 'auto';
                        cooldownTimer.style.display = 'none';
                        localStorage.removeItem('otp_resend_cooldown');
                    } else {
                        cooldownTimer.textContent = `(${seconds}s)`;
                        seconds--;
                    }
                }, 1000);
            }
        });
    </script>
</x-guest-layout>
