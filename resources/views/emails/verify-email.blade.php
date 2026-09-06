<x-emails.layout title="Verify your email address - {{ env('APP_NAME') }}" badge="Email Verification">

  <!-- Greeting -->
  <h1 style="font-family:Georgia,'Times New Roman',serif;font-size:32px;line-height:1.15;color:#1C1C1E;margin:0 0 18px 0;font-weight:400;">
    Hello,<br>{{ $notifiable->name }}
  </h1>

  <!-- Intro -->
  <p style="font-size:15px;line-height:1.75;color:#555555;margin:0 0 40px 0;">
    Thank you for signing up with {{ env('APP_NAME') }}. To complete your registration and
    secure your account, please verify your email address by clicking the button below.
  </p>

  <!-- CTA Button -->
  <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:40px;">
    <tr>
      <td align="center">
        <a href="{{ $url }}" style="display:inline-block;background-color:#1C1C1E;color:#FFFFFF;text-decoration:none;font-size:12px;font-weight:600;letter-spacing:2px;text-transform:uppercase;padding:17px 48px;border-radius:7px;font-family:Arial,sans-serif;">
          Verify Email Address
        </a>
      </td>
    </tr>
  </table>

  <p style="font-size:14px;line-height:1.8;color:#777777;margin:0 0 32px 0;">
    If you did not create an account, no further action is required.
  </p>

</x-emails.layout>
