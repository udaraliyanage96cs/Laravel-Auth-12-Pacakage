<x-emails.layout title="Your Account is Now Active - {{ env('APP_NAME') }}" badge="Account Activation">

  <!-- Greeting -->
  <h1 style="font-family:Georgia,'Times New Roman',serif;font-size:32px;line-height:1.15;color:#1C1C1E;margin:0 0 18px 0;font-weight:400;">
    Welcome,<br>{{ $user->name }}
  </h1>

  <!-- Intro -->
  <p style="font-size:15px;line-height:1.75;color:#555555;margin:0 0 40px 0;">
    Your account has been successfully created and is ready to use.
    Below are your login credentials &mdash; please keep them safe.
  </p>

  <!-- Credentials box -->
  <table width="100%" cellpadding="0" cellspacing="0" border="0" style="border:1px solid #E0DDD8;border-radius:10px;overflow:hidden;margin-bottom:28px;">
    <!-- Dark header row -->
    <tr>
      <td colspan="2" style="background-color:#1C1C1E;padding:14px 28px;border-radius:10px 10px 0 0;">
        <span style="font-size:10px;font-weight:600;letter-spacing:2.5px;text-transform:uppercase;color:#C8A96E;">
          Login Details
        </span>
      </td>
    </tr>
    <!-- Email row -->
    <tr>
      <td style="background-color:#F8F6F3;padding:20px 28px 8px 28px;font-size:11px;font-weight:600;letter-spacing:1.5px;text-transform:uppercase;color:#999999;width:90px;white-space:nowrap;vertical-align:middle;">
        Email
      </td>
      <td style="background-color:#F8F6F3;padding:20px 28px 8px 0;font-size:14px;font-weight:500;color:#1C1C1E;vertical-align:middle;">
        {{ $user->email }}
      </td>
    </tr>
    <!-- Password row -->
    <tr>
      <td style="background-color:#F8F6F3;padding:8px 28px 20px 28px;font-size:11px;font-weight:600;letter-spacing:1.5px;text-transform:uppercase;color:#999999;width:90px;white-space:nowrap;vertical-align:middle;">
        Password
      </td>
      <td style="background-color:#F8F6F3;padding:8px 28px 20px 0;font-size:14px;font-weight:500;color:#1C1C1E;vertical-align:middle;">
        {{ $password }}
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
          For your security, we strongly recommend updating your password immediately after your first login.
        </p>
      </td>
    </tr>
  </table>

  <!-- CTA Button -->
  <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:40px;">
    <tr>
      <td align="center">
        <a href="{{ env('APP_URL') }}" style="display:inline-block;background-color:#1C1C1E;color:#FFFFFF;text-decoration:none;font-size:12px;font-weight:600;letter-spacing:2px;text-transform:uppercase;padding:17px 48px;border-radius:7px;font-family:Arial,sans-serif;">
          Access Your Account
        </a>
      </td>
    </tr>
  </table>

</x-emails.layout>