<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Ingresos - {{ $settings->name ?? 'Barbería' }}</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 14px; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #dca54c; padding-bottom: 15px; }
        .header h1 { margin: 0; color: #111; font-size: 24px; text-transform: uppercase; }
        .header p { margin: 5px 0; color: #666; }
        .summary { margin-bottom: 30px; padding: 15px; background-color: #f9f9f9; border-radius: 5px; }
        .summary h2 { margin-top: 0; font-size: 18px; color: #111; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #111; color: #fff; text-transform: uppercase; font-size: 12px; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        .text-right { text-align: right; }
        .badge { display: inline-block; padding: 3px 6px; font-size: 10px; font-weight: bold; border-radius: 3px; }
        .badge-walkin { background-color: #fff3cd; color: #856404; }
        .badge-online { background-color: #d1ecf1; color: #0c5460; }
        .total-row td { font-weight: bold; font-size: 16px; background-color: #e9ecef; }
        .footer { text-align: center; margin-top: 50px; font-size: 10px; color: #999; border-top: 1px solid #eee; padding-top: 10px; }
    </style>
</head>
<body>

    <div class="header">
        <h1>{{ $settings->name ?? 'Barbería - Reporte de Ingresos' }}</h1>
        <p>Reporte de cortes y servicios completados</p>
        <p><small>Generado el: {{ now()->format('d/m/Y h:i A') }}</small></p>
    </div>

    <div class="summary">
        <h2>Resumen de los últimos {{ $days }} días</h2>
        <p><strong>Total de Servicios Completados:</strong> {{ $appointments->count() }}</p>
        <p><strong>Ingresos Totales (Estimado):</strong> ${{ number_format($totalIncome, 2) }}</p>
        <p><em>Rango de fechas: Desde {{ now()->subDays($days)->format('d/m/Y') }} hasta hoy.</em></p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Cliente</th>
                <th>Tipo</th>
                <th class="text-right">Cobrado</th>
            </tr>
        </thead>
        <tbody>
            @forelse($appointments as $apt)
            <tr>
                <td>{{ \Carbon\Carbon::parse($apt->appointment_date)->format('d/m/Y') }} a las {{ \Carbon\Carbon::parse($apt->appointment_time)->format('h:i A') }}</td>
                <td>{{ $apt->guest_name ?? 'Invalido' }}</td>
                <td>
                    @if($apt->is_walk_in)
                        <span class="badge badge-walkin">Walk-in</span>
                    @else
                        <span class="badge badge-online">Digital</span>
                    @endif
                </td>
                <td class="text-right">${{ number_format($apt->final_price, 2) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align: center; padding: 20px;">No hubo ingresos ni cortes completados en este periodo.</td>
            </tr>
            @endforelse
            @if($appointments->count() > 0)
            <tr class="total-row">
                <td colspan="3" class="text-right">TOTAL ACUMULADO</td>
                <td class="text-right">${{ number_format($totalIncome, 2) }}</td>
            </tr>
            @endif
        </tbody>
    </table>

    <div class="footer">
        Este documento es generado automáticamente por el sistema de {{ $settings->name ?? 'la Barbería' }}.
    </div>

</body>
</html>
