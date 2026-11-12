<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nueva Solicitud de Servicio</title>
</head>
<body style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #0c1210; color: #e5e7eb; padding: 24px; margin: 0;">
    <div style="max-width: 600px; margin: 0 auto; background: #131b18; border: 1px solid #1e2a26; border-radius: 8px; padding: 32px; box-shadow: 0 10px 25px rgba(0,0,0,0.5);">
        <div style="border-bottom: 1px solid #23312c; padding-bottom: 16px; margin-bottom: 24px;">
            <span style="font-size: 11px; letter-spacing: 2px; text-transform: uppercase; color: #10b981; font-weight: 600;">ROGERLAB • TIENDA & ESTUDIO FREELANCE</span>
            <h1 style="color: #ffffff; font-size: 22px; margin: 8px 0 0 0; font-weight: 600;">Nueva Solicitud de Cliente</h1>
        </div>

        <p style="color: #9ca3af; font-size: 14px; margin-bottom: 20px;">
            Has recibido una nueva solicitud de contratación o presupuesto desde la sección de servicios web.
        </p>

        <table style="width: 100%; border-collapse: collapse; margin-bottom: 24px; font-size: 14px;">
            <tr>
                <td style="padding: 10px 0; border-bottom: 1px solid #1e2a26; color: #9ca3af; width: 140px;">Cliente:</td>
                <td style="padding: 10px 0; border-bottom: 1px solid #1e2a26; color: #ffffff; font-weight: 500;">{{ $name }}</td>
            </tr>
            <tr>
                <td style="padding: 10px 0; border-bottom: 1px solid #1e2a26; color: #9ca3af;">Email:</td>
                <td style="padding: 10px 0; border-bottom: 1px solid #1e2a26; color: #10b981;">
                    <a href="mailto:{{ $email }}" style="color: #10b981; text-decoration: none;">{{ $email }}</a>
                </td>
            </tr>
            <tr>
                <td style="padding: 10px 0; border-bottom: 1px solid #1e2a26; color: #9ca3af;">Teléfono / WhatsApp:</td>
                <td style="padding: 10px 0; border-bottom: 1px solid #1e2a26; color: #ffffff;">{{ $phone }}</td>
            </tr>
            <tr>
                <td style="padding: 10px 0; border-bottom: 1px solid #1e2a26; color: #9ca3af;">Servicio de interés:</td>
                <td style="padding: 10px 0; border-bottom: 1px solid #1e2a26; color: #ffffff; font-weight: 600;">{{ $service }}</td>
            </tr>
            <tr>
                <td style="padding: 10px 0; border-bottom: 1px solid #1e2a26; color: #9ca3af;">Modalidad / Plan:</td>
                <td style="padding: 10px 0; border-bottom: 1px solid #1e2a26; color: #ffffff;">{{ $plan }}</td>
            </tr>
            <tr>
                <td style="padding: 10px 0; border-bottom: 1px solid #1e2a26; color: #9ca3af;">Presupuesto estimado:</td>
                <td style="padding: 10px 0; border-bottom: 1px solid #1e2a26; color: #ffffff;">{{ $budget }}</td>
            </tr>
            <tr>
                <td style="padding: 10px 0; border-bottom: 1px solid #1e2a26; color: #9ca3af;">Fecha y hora:</td>
                <td style="padding: 10px 0; border-bottom: 1px solid #1e2a26; color: #ffffff;">{{ $submitted_at }}</td>
            </tr>
        </table>

        <div style="background: #0c1210; border: 1px solid #1e2a26; border-radius: 6px; padding: 16px; margin-bottom: 24px;">
            <div style="font-size: 12px; color: #10b981; text-transform: uppercase; font-weight: 600; margin-bottom: 8px;">Detalles del proyecto o necesidad:</div>
            <div style="color: #e5e7eb; font-size: 14px; line-height: 1.6; white-space: pre-wrap;">{{ $description }}</div>
        </div>

        <div style="text-align: center; padding-top: 12px;">
            <a href="mailto:{{ $email }}?subject=Re:%20Propuesta%20de%20Servicio%20Web%20-%20RogerLab" style="background: #10b981; color: #0c1210; padding: 12px 24px; text-decoration: none; border-radius: 4px; font-weight: 600; font-size: 14px; display: inline-block;">
                Responder al Cliente Directamente
            </a>
        </div>
    </div>
</body>
</html>
