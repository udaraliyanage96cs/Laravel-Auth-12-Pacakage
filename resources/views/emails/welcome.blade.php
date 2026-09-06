<x-emails.layout title="Welcome to {{ env('APP_NAME') }}" badge="Welcome Aboard">

  <!-- Greeting -->
  <h1 style="font-family:Georgia,'Times New Roman',serif;font-size:32px;line-height:1.15;color:#1C1C1E;margin:0 0 18px 0;font-weight:400;">
    Welcome,<br>{{ $user->name }}
  </h1>

  <!-- Intro -->
  <p style="font-size:15px;line-height:1.75;color:#555555;margin:0 0 40px 0;">
    Your account has been successfully created. We're thrilled to have you! You can now access your dashboard and explore all the features we have to offer.
  </p>

  <!-- CTA Button -->
  <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:40px;">
    <tr>
      <td align="center">
        <a href="{{ env('APP_URL') }}" style="display:inline-block;background-color:#1C1C1E;color:#FFFFFF;text-decoration:none;font-size:12px;font-weight:600;letter-spacing:2px;text-transform:uppercase;padding:17px 48px;border-radius:7px;font-family:Arial,sans-serif;">
          Go to Dashboard
        </a>
      </td>
    </tr>
  </table>

</x-emails.layout>
