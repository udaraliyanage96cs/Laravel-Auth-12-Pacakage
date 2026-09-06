<x-emails.layout title="Your Account is Under Review - {{ env('APP_NAME') }}" badge="Account Review">

  <!-- Greeting -->
  <h1 style="font-family:Georgia,'Times New Roman',serif;font-size:32px;line-height:1.15;color:#1C1C1E;margin:0 0 18px 0;font-weight:400;">
    Hello,<br>{{ $user->name }}
  </h1>

  <!-- Intro -->
  <p style="font-size:15px;line-height:1.75;color:#555555;margin:0 0 32px 0;">
    Thank you for signing up with {{ env('APP_NAME') }}. We've received your registration and your account is currently being reviewed by our team.
  </p>

  <!-- Status box -->
  <table width="100%" cellpadding="0" cellspacing="0" border="0" style="border:1px solid #E0DDD8;border-radius:10px;overflow:hidden;margin-bottom:28px;">
    <!-- Dark header row -->
    <tr>
      <td style="background-color:#1C1C1E;padding:14px 28px;border-radius:10px 10px 0 0;">
        <span style="font-size:10px;font-weight:600;letter-spacing:2.5px;text-transform:uppercase;color:#C8A96E;">
          Account Status
        </span>
      </td>
    </tr>
    <!-- Status row -->
    <tr>
      <td style="background-color:#F8F6F3;padding:20px 28px 12px 28px;">
        <table cellpadding="0" cellspacing="0" border="0">
          <tr>
            <td style="vertical-align:middle;padding-right:10px;">
              <!-- Gold dot indicator -->
              <div style="width:10px;height:10px;background-color:#C8A96E;border-radius:50%;"></div>
            </td>
            <td style="font-size:14px;font-weight:600;color:#1C1C1E;vertical-align:middle;letter-spacing:0.3px;">
              Pending Approval
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td style="background-color:#F8F6F3;padding:0 28px 20px 28px;">
        <p style="font-size:13px;line-height:1.7;color:#666666;margin:8px 0 0 0;">
          Our administrators are reviewing your account details. Once approved, you will receive a confirmation email with your login credentials.
        </p>
      </td>
    </tr>
  </table>

  <!-- Info notice -->
  <table width="100%" cellpadding="0" cellspacing="0" border="0" style="border:1px solid #EDD98A;border-left:4px solid #C8A96E;border-radius:0 8px 8px 0;background-color:#FFFBF0;margin-bottom:40px;">
    <tr>
      <td style="padding:16px 22px;">
        <p style="font-size:11px;font-weight:600;letter-spacing:1.5px;text-transform:uppercase;color:#A07C30;margin:0 0 6px 0;">
          What Happens Next?
        </p>
        <p style="font-size:13px;line-height:1.65;color:#7A6030;margin:0;">
          This review process typically takes 1&ndash;2 business days. You will be notified by email as soon as your account is activated. No action is required from you at this time.
        </p>
      </td>
    </tr>
  </table>

  <!-- CTA Button -->
  <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:40px;">
    <tr>
      <td align="center">
        <a href="{{ env('APP_URL') }}/contact" style="display:inline-block;background-color:#1C1C1E;color:#FFFFFF;text-decoration:none;font-size:12px;font-weight:600;letter-spacing:2px;text-transform:uppercase;padding:17px 48px;border-radius:7px;font-family:Arial,sans-serif;">
          Contact Us
        </a>
      </td>
    </tr>
  </table>

  <x-slot:signoff>
    <p style="font-size:14px;line-height:1.8;color:#777777;margin:0;">
      We appreciate your patience and look forward to welcoming you on board.
    </p>
  </x-slot:signoff>

</x-emails.layout>