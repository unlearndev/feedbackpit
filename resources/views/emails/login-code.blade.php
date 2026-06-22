<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your sign-in code</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f5f5f5; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color: #f5f5f5; padding: 40px 0;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width: 440px; background-color: #ffffff; border: 1px solid rgba(0, 0, 0, 0.06);">
                    <tr>
                        <td style="padding: 32px;">
                            <h1 style="margin: 0 0 16px; font-size: 20px; font-weight: 600; color: #171717;">Sign in to {{ config('app.name') }}</h1>

                            <p style="margin: 0 0 24px; font-size: 14px; line-height: 1.6; color: #525252;">
                                Use the code below to finish signing in. It expires in {{ config('otp.expiry') }} minutes.
                            </p>

                            <p style="margin: 0 0 24px; font-size: 32px; font-weight: 600; letter-spacing: 8px; color: #171717;">
                                {{ $code }}
                            </p>

                            <p style="margin: 0; font-size: 13px; line-height: 1.6; color: #a3a3a3;">
                                If you didn't request this, you can safely ignore this email.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
