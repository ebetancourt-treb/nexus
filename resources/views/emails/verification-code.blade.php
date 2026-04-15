<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Confirma tu correo — BlumOps</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body style="margin:0; padding:0; background:#f5f5f7; font-family:'Montserrat',-apple-system,sans-serif; -webkit-font-smoothing:antialiased;">

  <table width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#f5f5f7">
    <tr>
      <td align="center" style="padding:48px 20px;">
        <table width="560" cellpadding="0" cellspacing="0" border="0" style="max-width:560px; background:#ffffff; border-radius:20px; overflow:hidden;">

          <!-- LOGO -->
          <tr>
            <td style="padding:40px 48px 28px;">
              <img src="https://treblum.com/wp-content/uploads/2026/04/Logo-BlumOps-Rectangular.webp" alt="BlumOps" width="130" style="display:block;">
            </td>
          </tr>
          <tr>
            <td style="padding:0 48px;">
              <div style="height:1px; background:#f0f0f0;"></div>
            </td>
          </tr>

          <!-- CUERPO -->
          <tr>
            <td style="padding:40px 48px 48px;">

              <p style="margin:0 0 16px; font-size:22px; font-weight:600; color:#1d1d1f; letter-spacing:-0.3px; line-height:1.3;">
                Bienvenido, {{ $userName }}
              </p>

              <p style="margin:0 0 32px; font-size:15px; font-weight:400; color:#6e6e73; line-height:1.7;">
                Qué bueno que estás aquí. Para entrar a tu cuenta solo necesitas este código. Te tomará menos de un minuto.
              </p>

              <!-- CÓDIGO -->
              <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:32px;">
                <tr>
                  <td align="center" style="background:#f5f5f7; border-radius:14px; padding:32px 24px;">
                    <p style="margin:0 0 8px; font-size:11px; font-weight:600; letter-spacing:0.1em; text-transform:uppercase; color:#6e6e73;">Tu código de verificación</p>
                    <p style="margin:0; font-size:52px; font-weight:600; letter-spacing:16px; color:#1d1d1f; line-height:1;">{{ $code }}</p>
                    <p style="margin:12px 0 0; font-size:12px; color:#a1a1a6;">Válido por 15 minutos</p>
                  </td>
                </tr>
              </table>

              <p style="margin:0 0 28px; font-size:15px; font-weight:400; color:#6e6e73; line-height:1.7;">
                Cuando entres, tu almacén ya estará listo. Sin pasos extra, sin configuraciones raras. Así debe ser.
              </p>

              <!-- CTA -->
              <table cellpadding="0" cellspacing="0" border="0" style="margin-bottom:32px;">
                <tr>
                  <td bgcolor="#059669" style="border-radius:980px;">
                    <a href="{{ config('app.url') }}/verify-email" target="_blank"
                      style="display:inline-block; padding:9px 22px; font-family:'Montserrat',sans-serif;
                      font-size:12px; font-weight:500; color:#ffffff; text-decoration:none; border-radius:980px;">
                      Volver a BlumOps ›
                    </a>
                  </td>
                </tr>
              </table>

              <p style="margin:0; font-size:12px; color:#a1a1a6; line-height:1.6;">
                Si no fuiste tú quien creó esta cuenta, puedes ignorar este correo.
              </p>

            </td>
          </tr>

          <!-- FOOTER -->
          <tr>
            <td style="padding:0 48px 36px;">
              <div style="height:1px; background:#f0f0f0; margin-bottom:20px;"></div>
              <p style="margin:0; font-size:11px; color:#a1a1a6; line-height:1.8;">
                © {{ date('Y') }} Treblum™. Todos los derechos reservados.
              </p>
            </td>
          </tr>

        </table>
      </td>
    </tr>
  </table>

</body>
</html>