<x-emails.layout title="Verification Code - {{ env('APP_NAME') }}" badge="Two-Factor Auth">

  <!-- Greeting -->
  <h1 style="font-family:Georgia,'Times New Roman',serif;font-size:32px;line-height:1.15;color:#1C1C1E;margin:0 0 18px 0;font-weight:400;">
    Hello,<br>{{ $user->name }}
  </h1>

  <!-- Intro -->
  <p style="font-size:15px;line-height:1.75;color:#555555;margin:0 0 40px 0;">
    Your account security requires a verification code to log in. Please use the following One-Time Password (OTP) to complete your authentication.
  </p>

  <!-- OTP Display Box -->
  <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:40px;">
    <tr>
      <td align="center">
        <div style="display:inline-block;background-color:#F5F4F0;color:#1C1C1E;font-size:36px;font-weight:700;letter-spacing:6px;padding:18px 48px;border-radius:8px;font-family:'Courier New',Courier,monospace;border:1px solid #E0DDD8;">
          {{ $otp }}
        </div>
      </td>
    </tr>
  </table>

  <!-- Security notice -->
  <table width="100%" cellpadding="0" cellspacing="0" border="0" style="border:1px solid #EDD98A;border-left:4px solid #C8A96E;border-radius:0 8px 8px 0;background-color:#FFFBF0;margin-bottom:40px;">
    <tr>
      <td style="padding:16px 22px;">
        <p style="font-size:11px;font-weight:600;letter-spacing:1.5px;text-transform:uppercase;color:#A07C30;margin:0 0 6px 0;">
          Security Notice
        </p>
        <p style="font-size:13px;line-height:1.65;color:#7A6030;margin:0;">
          This code is valid for 10 minutes. If you did not attempt to sign in to your account, please secure your password immediately.
        </p>
      </td>
    </tr>
  </table>

</x-emails.layout>
