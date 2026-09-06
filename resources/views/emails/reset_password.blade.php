<x-emails.layout title="Reset Password - {{ env('APP_NAME') }}" badge="Password Reset">

  <!-- Greeting -->
  <h1 style="font-family:Georgia,'Times New Roman',serif;font-size:32px;line-height:1.15;color:#1C1C1E;margin:0 0 18px 0;font-weight:400;">
    Hello,<br>{{ $user->name }}
  </h1>

  <!-- Intro -->
  <p style="font-size:15px;line-height:1.75;color:#555555;margin:0 0 40px 0;">
    You are receiving this email because we received a password reset request for your account. Click the button below to reset your password.
  </p>

  <!-- CTA Button -->
  <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:40px;">
    <tr>
      <td align="center">
        <a href="{{ $url }}" style="display:inline-block;background-color:#1C1C1E;color:#FFFFFF;text-decoration:none;font-size:12px;font-weight:600;letter-spacing:2px;text-transform:uppercase;padding:17px 48px;border-radius:7px;font-family:Arial,sans-serif;">
          Reset Password
        </a>
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
          This password reset link will expire in 60 minutes.
          If you did not request a password reset, no further action is required.
        </p>
      </td>
    </tr>
  </table>

  <p style="font-size:13px;line-height:1.65;color:#999999;margin:0 0 32px 0;word-break:break-all;">
    If you're having trouble clicking the "Reset Password" button, copy and paste the URL below into your web browser: <br>
    <a href="{{ $url }}" style="color:#C8A96E;">{{ $url }}</a>
  </p>

</x-emails.layout>
