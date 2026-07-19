<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Certificado - {{ $certificate->recipient_name }}</title>
    <style>
        /* Custom fonts styling */
        {!! $fontStyles !!}

        @page {
            size: A4 landscape;
            margin: 0;
        }
        
        body {
            margin: 0;
            padding: 0;
            width: 297mm;
            height: 210mm;
            font-family: 'Helvetica', 'Arial', sans-serif;
            background-image: url('{{ $bgPath }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            position: relative;
            box-sizing: border-box;
        }

        .absolute-field {
            position: absolute;
            text-align: center;
            transform: translateX(-50%);
            left: 50%;
        }

        .name-field {
            font-family: "{{ $settings['name_field']['font_family'] ?? 'Helvetica' }}", sans-serif;
            font-size: {{ $settings['name_field']['font_size'] ?? '32pt' }};
            color: {{ $settings['name_field']['color'] ?? '#111827' }};
            top: {{ $settings['name_field']['y'] ?? '45%' }};
            font-weight: bold;
            width: 80%;
        }

        .event-field {
            font-family: "{{ $settings['event_field']['font_family'] ?? 'Helvetica' }}", sans-serif;
            font-size: {{ $settings['event_field']['font_size'] ?? '20pt' }};
            color: {{ $settings['event_field']['color'] ?? '#374151' }};
            top: {{ $settings['event_field']['y'] ?? '58%' }};
            width: 80%;
            line-height: 1.4;
        }

        .role-field {
            font-family: "{{ $settings['role_field']['font_family'] ?? 'Helvetica' }}", sans-serif;
            font-size: {{ $settings['role_field']['font_size'] ?? '16pt' }};
            color: {{ $settings['role_field']['color'] ?? '#4B5563' }};
            top: {{ $settings['role_field']['y'] ?? '68%' }};
            width: 80%;
        }

        .date-field {
            font-family: "{{ $settings['date_field']['font_family'] ?? 'Helvetica' }}", sans-serif;
            font-size: {{ $settings['date_field']['font_size'] ?? '12pt' }};
            color: {{ $settings['date_field']['color'] ?? '#6B7280' }};
            top: {{ $settings['date_field']['y'] ?? '80%' }};
            width: 80%;
        }

        .code-field {
            position: absolute;
            font-family: "{{ $settings['code_field']['font_family'] ?? 'Helvetica' }}", sans-serif;
            font-size: {{ $settings['code_field']['font_size'] ?? '10pt' }};
            color: {{ $settings['code_field']['color'] ?? '#9CA3AF' }};
            bottom: {{ $settings['code_field']['y'] ?? '10mm' }};
            left: {{ $settings['code_field']['x'] ?? '15mm' }};
            font-weight: bold;
        }

        .qr-field {
            position: absolute;
            bottom: {{ $settings['qr_field']['y'] ?? '10mm' }};
            right: {{ $settings['qr_field']['x'] ?? '15mm' }};
            width: {{ $settings['qr_field']['size'] ?? '100px' }};
            height: {{ $settings['qr_field']['size'] ?? '100px' }};
            border: 1px solid #E5E7EB;
            padding: 4px;
            background-color: white;
        }
    </style>
</head>
<body>

    <!-- Recipient Name -->
    <div class="absolute-field name-field">
        {{ $certificate->recipient_name }}
    </div>

    <!-- Event Title / Name -->
    <div class="absolute-field event-field">
        {{ $template->name }}
    </div>

    <!-- Role (e.g. Participante, Ponente) -->
    <div class="absolute-field role-field">
        En calidad de <strong>{{ $certificate->role ?? 'Participante' }}</strong>
    </div>

    <!-- Issue Date -->
    <div class="absolute-field date-field">
        Expedido el {{ \Carbon\Carbon::parse($certificate->issue_date)->locale('es')->translatedFormat('d \d\e F \d\e Y') }}
    </div>

    <!-- Unique Verification Code -->
    <div class="code-field">
        Cód. Reg: {{ $certificate->code }}
    </div>

    <!-- QR Code for Verification -->
    <img class="qr-field" src="{{ $qrCodeUrl }}" alt="Código QR de verificación">

</body>
</html>
