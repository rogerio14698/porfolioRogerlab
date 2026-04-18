<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Nueva consulta desde la Web</title>
</head>
<body style="margin:0; padding:0; background-color:#101418; color:#e7edf3; font-family:Inter, Roboto, Arial, Helvetica, sans-serif;">
    <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="width:100%; margin:0; padding:24px 12px; background-color:#101418;">
        <tr>
            <td align="center">
                <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="width:100%; max-width:680px; margin:0 auto; border-collapse:separate; border-spacing:0;">
                    <tr>
                        <td style="padding:0 0 16px 0;">
                            <div style="border:1px solid rgba(153, 153, 153, 0.28); border-radius:8px; background-color:#171c22; padding:24px;">
                                <p style="margin:0 0 8px 0; font-size:12px; line-height:18px; letter-spacing:0.12em; text-transform:uppercase; color:#98a6b3;">
                                    Portfolio Contact
                                </p>
                                <h1 style="margin:0; font-size:28px; line-height:34px; font-weight:700; color:#f5f7fa;">
                                    Nueva consulta desde la Web
                                </h1>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:0;">
                            <div style="border:1px solid rgba(153, 153, 153, 0.22); border-radius:8px; background-color:#171c22; padding:24px;">
                                <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="width:100%; border-collapse:collapse;">
                                    <tr>
                                        <td style="padding:0 0 18px 0; font-size:15px; line-height:24px; color:#dbe5ee;">
                                            <strong style="display:block; margin:0 0 4px 0; font-size:16px; line-height:24px; color:#ffffff;">{{ $name }}</strong>
                                            <a href="mailto:{{ $email }}" style="color:#8ec5ff; text-decoration:none;">{{ $email }}</a>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td style="padding:0 0 18px 0;">
                                            <p style="margin:0 0 6px 0; font-size:12px; line-height:18px; letter-spacing:0.08em; text-transform:uppercase; color:#98a6b3;">
                                                Asunto
                                            </p>
                                            <p style="margin:0; font-size:16px; line-height:24px; color:#f5f7fa; font-weight:600;">
                                                {{ $subject }}
                                            </p>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td style="padding:0;">
                                            <p style="margin:0 0 10px 0; font-size:12px; line-height:18px; letter-spacing:0.08em; text-transform:uppercase; color:#98a6b3;">
                                                Mensaje
                                            </p>
                                            <div style="border-radius:8px; background-color:#11161b; border:1px solid rgba(153, 153, 153, 0.18); padding:18px;">
                                                <p style="margin:0; font-size:15px; line-height:25px; color:#dbe5ee; white-space:pre-line; word-break:break-word;">
                                                    {{ $message_body }}
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:16px 0 0 0;">
                            <div style="border:1px solid rgba(153, 153, 153, 0.18); border-radius:8px; background-color:#14191f; padding:18px 24px;">
                                <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="width:100%; border-collapse:collapse;">
                                    <tr>
                                        <td style="padding:0 0 10px 0; font-size:13px; line-height:20px; color:#98a6b3;">
                                            Fecha y hora: <span style="color:#dbe5ee;">{{ $submitted_at }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding:0 0 14px 0; font-size:13px; line-height:20px; color:#98a6b3;">
                                            IP remitente: <span style="color:#dbe5ee;">{{ $ip_address }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding:0;">
                                            <span style="display:inline-block; border-radius:999px; padding:8px 14px; background-color:#1c2a36; border:1px solid rgba(142, 197, 255, 0.28); font-size:12px; line-height:16px; font-weight:700; color:#8ec5ff;">
                                                {{ $verification_badge }}
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>