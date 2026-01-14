<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Solicitud de Cita</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #0073e6 0%, #005bb5 100%);
            color: #ffffff;
            padding: 30px 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        .content {
            padding: 30px 20px;
        }
        .info-block {
            background: #f8f9fa;
            border-left: 4px solid #0073e6;
            padding: 15px;
            margin: 15px 0;
            border-radius: 4px;
        }
        .info-label {
            font-weight: bold;
            color: #0073e6;
            display: inline-block;
            min-width: 150px;
        }
        .info-value {
            color: #333;
        }
        .message-box {
            background: #fff9e6;
            border: 1px solid #ffe066;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .footer {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #e0e0e0;
        }
        .urgent {
            background: #fff3cd;
            border-left-color: #ffc107;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
            border-left: 4px solid #ffc107;
        }
        @media only screen and (max-width: 600px) {
            .container {
                margin: 0;
                border-radius: 0;
            }
            .info-label {
                display: block;
                margin-bottom: 5px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>Nueva Solicitud de Cita</h1>
            <p style="margin: 5px 0 0 0; font-size: 14px;">Dr. Aldo Avellaneda - Cirugía de Columna</p>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="urgent">
                <strong>Acción Requerida:</strong> Un paciente potencial ha solicitado una cita. Por favor, contacte lo antes posible.
            </div>

            <h2 style="color: #0073e6; font-size: 18px; margin-top: 0;">Información del Paciente</h2>

            <div class="info-block">
                <div style="margin-bottom: 10px;">
                    <span class="info-label">Nombre Completo:</span>
                    <span class="info-value"><?php echo htmlspecialchars($fullName); ?></span>
                </div>
                <div style="margin-bottom: 10px;">
                    <span class="info-label">Correo Electrónico:</span>
                    <span class="info-value">
                        <a href="mailto:<?php echo htmlspecialchars($email); ?>" style="color: #0073e6; text-decoration: none;">
                            <?php echo htmlspecialchars($email); ?>
                        </a>
                    </span>
                </div>
                <div style="margin-bottom: 10px;">
                    <span class="info-label">Teléfono:</span>
                    <span class="info-value">
                        <a href="tel:<?php echo preg_replace('/[^\d+]/', '', $phone); ?>" style="color: #0073e6; text-decoration: none;">
                            <?php echo htmlspecialchars($phone); ?>
                        </a>
                    </span>
                </div>
                <div>
                    <span class="info-label">Idioma Preferido:</span>
                    <span class="info-value">
                        <?php echo $preferredLanguage === 'spanish' ? 'Español' : 'English'; ?>
                    </span>
                </div>
            </div>

            <h3 style="color: #0073e6; font-size: 16px; margin-top: 25px;">Mensaje del Paciente</h3>
            <div class="message-box">
                <?php echo nl2br(htmlspecialchars($message)); ?>
            </div>

            <div style="margin-top: 30px; padding: 15px; background: #e8f4f8; border-radius: 4px;">
                <p style="margin: 0; font-size: 14px;">
                    <strong>Próximos Pasos:</strong>
                </p>
                <ol style="margin: 10px 0 0 0; padding-left: 20px; font-size: 14px;">
                    <li>Revisar la información del paciente</li>
                    <li>Contactar al paciente en su idioma preferido</li>
                    <li>Programar una cita inicial o consulta telefónica</li>
                    <li>Registrar la solicitud en el sistema interno</li>
                </ol>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p style="margin: 0 0 10px 0;">
                <strong>Dr. Aldo Avellaneda</strong><br>
                Especialista en Cirugía de Columna Vertebral
            </p>
            <p style="margin: 0; color: #999;">
                Este es un email automático generado desde el formulario web.<br>
                Fecha: <?php echo date('d/m/Y H:i:s'); ?>
            </p>
        </div>
    </div>
</body>
</html>
