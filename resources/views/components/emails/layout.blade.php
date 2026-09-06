<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>{{ $title ?? env('APP_NAME') }}</title>
  <!--[if mso]>
  <noscript>
    <xml><o:OfficeDocumentSettings><o:PixelsPerInch>96</o:PixelsPerInch></o:OfficeDocumentSettings></xml>
  </noscript>
  <![endif]-->
</head>
<body style="margin:0;padding:0;background-color:#ECEAE5;font-family:'DM Sans',Arial,sans-serif;font-size:15px;color:#1a1a1a;">

  <!-- Outer wrapper -->
  <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#ECEAE5;padding:48px 16px;">
    <tr>
      <td align="center">

        <!-- Email card -->
        <table width="580" cellpadding="0" cellspacing="0" border="0" style="max-width:580px;width:100%;">

          <!-- ══ HEADER ══ -->
          <tr>
            <td style="background-color:#1C1C1E;border-radius:14px 14px 0 0;padding:28px 48px;">
              <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                  <td style="font-family:Georgia,'Times New Roman',serif;font-size:22px;color:#FFFFFF;letter-spacing:-0.3px;">
                    {{ env('APP_NAME') }}<span style="color:#C8A96E;">.</span>
                  </td>
                  <td align="right" style="font-size:10px;font-weight:600;letter-spacing:2.5px;text-transform:uppercase;color:#8A8A8A;white-space:nowrap;">
                    {{ $badge ?? '' }}
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- ══ BODY ══ -->
          <tr>
            <td style="background-color:#FFFFFF;padding:52px 48px 48px;border-left:1px solid #E0DDD8;border-right:1px solid #E0DDD8;">

              <!-- Gold accent strip -->
              <div style="width:48px;height:3px;background-color:#C8A96E;border-radius:2px;margin-bottom:28px;"></div>

              {{ $slot }}

              <!-- Divider -->
              <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:32px;">
                <tr>
                  <td style="height:1px;background-color:#ECEAE5;font-size:0;line-height:0;">&nbsp;</td>
                </tr>
              </table>

              <!-- Sign-off -->
              @isset($signoff)
                {{ $signoff }}
              @else
                <p style="font-size:14px;line-height:1.8;color:#777777;margin:0;">
                  If you have any questions, don&rsquo;t hesitate to reach out to our support team &mdash; we&rsquo;re happy to help.
                </p>
              @endisset
              <p style="font-family:Georgia,'Times New Roman',serif;font-size:18px;color:#1C1C1E;font-weight:400;margin:12px 0 0 0;">
                The {{ env('APP_NAME') }} Team
              </p>

            </td>
          </tr>

          <!-- ══ FOOTER ══ -->
          <tr>
            <td style="background-color:#1C1C1E;border-radius:0 0 14px 14px;padding:26px 48px;">
              <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                  <td style="font-size:12px;color:#AAAAAA;">
                    &copy; {{ env('APP_NAME') }}. All rights reserved.
                  </td>
                  <td align="right">
                    <a href="{{ env('APP_URL') }}" style="font-size:12px;font-weight:500;color:#C8A96E;text-decoration:none;white-space:nowrap;">
                      Visit our website &rarr;
                    </a>
                  </td>
                </tr>
              </table>
            </td>
          </tr>

        </table>
        <!-- /Email card -->

      </td>
    </tr>
  </table>

</body>
</html>
