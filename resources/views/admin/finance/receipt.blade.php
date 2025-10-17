<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>To'lov Kvitansiyasi</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background: #f5f5f5; 
            padding: 20px;
        }
        .receipt-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .receipt-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
            position: relative;
        }
        .receipt-header::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            right: 0;
            height: 20px;
            background: white;
            border-radius: 50% 50% 0 0 / 100% 100% 0 0;
        }
        .receipt-header h1 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
        }
        .receipt-header h2 {
            font-size: 18px;
            font-weight: 400;
            opacity: 0.9;
        }
        .receipt-number {
            background: rgba(255,255,255,0.2);
            padding: 8px 16px;
            border-radius: 20px;
            display: inline-block;
            margin-top: 15px;
            font-size: 14px;
        }
        .receipt-body {
            padding: 40px 30px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }
        .info-item {
            background: #f8f9fa;
            padding: 16px;
            border-radius: 8px;
            border-left: 4px solid #667eea;
        }
        .info-label {
            font-size: 12px;
            color: #6c757d;
            text-transform: uppercase;
            font-weight: 600;
            margin-bottom: 4px;
        }
        .info-value {
            font-size: 16px;
            color: #212529;
            font-weight: 500;
        }
        .amount-section {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 12px;
            padding: 25px;
            margin: 30px 0;
            text-align: center;
            border: 2px dashed #667eea;
        }
        .amount-label {
            font-size: 14px;
            color: #6c757d;
            margin-bottom: 8px;
            text-transform: uppercase;
            font-weight: 600;
        }
        .amount-value {
            font-size: 32px;
            font-weight: 700;
            color: #667eea;
            margin-bottom: 5px;
        }
        .amount-currency {
            font-size: 16px;
            color: #6c757d;
        }
        .discount-info {
            background: #e8f5e8;
            border: 1px solid #c3e6c3;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
        }
        .discount-info h4 {
            color: #2e7d32;
            margin-bottom: 8px;
        }
        .discount-row {
            display: flex;
            justify-content: space-between;
            margin: 5px 0;
        }
        .notes-section {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
        }
        .receipt-footer {
            background: #f8f9fa;
            padding: 25px 30px;
            text-align: center;
            border-top: 1px solid #dee2e6;
        }
        .signature-section {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
        }
        .signature-box {
            text-align: center;
            width: 200px;
        }
        .signature-line {
            border-bottom: 2px solid #dee2e6;
            height: 40px;
            margin-bottom: 8px;
        }
        .signature-label {
            font-size: 12px;
            color: #6c757d;
            text-transform: uppercase;
        }
        .print-buttons {
            margin-bottom: 20px;
            text-align: center;
        }
        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            margin: 0 8px;
            transition: all 0.3s ease;
        }
        .btn-primary {
            background: #667eea;
            color: white;
        }
        .btn-primary:hover {
            background: #5a6fd8;
            transform: translateY(-2px);
        }
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        .btn-secondary:hover {
            background: #5a6268;
        }
        @media print {
            body { background: white; padding: 0; }
            .print-buttons { display: none; }
            .receipt-container { box-shadow: none; }
        }
        @media (max-width: 600px) {
            .info-grid { grid-template-columns: 1fr; }
            .signature-section { flex-direction: column; gap: 20px; }
            .signature-box { width: 100%; }
        }
    </style>
</head>
<body>
    <div class="print-buttons">
        <button onclick="window.print()" class="btn btn-primary">
            <i class="fas fa-print"></i> Chop etish
        </button>
        <button onclick="window.close()" class="btn btn-secondary">
            <i class="fas fa-times"></i> Yopish
        </button>
    </div>

    <div class="receipt-container">
        <div class="receipt-header">
            <h1>O'QUV MARKAZI</h1>
            <h2>TO'LOV KVITANSIYASI</h2>
            <div class="receipt-number">
                Kvitansiya #{{ $payment->receipt_number ?? $payment->id }}
            </div>
        </div>

        <div class="receipt-body">
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">O'quvchi</div>
                    <div class="info-value">{{ $payment->student->first_name ?? 'N/A' }} {{ $payment->student->last_name ?? '' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">O'quvchi ID</div>
                    <div class="info-value">{{ $payment->student->student_id ?? 'N/A' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">To'lov sanasi</div>
                    <div class="info-value">{{ $payment->payment_date ? $payment->payment_date->format('d.m.Y H:i') : 'N/A' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">To'lov usuli</div>
                    <div class="info-value">{{ ucfirst($payment->payment_method ?? 'naqd') }}</div>
                </div>
            </div>

            @if(isset($payment->original_amount) && $payment->original_amount != $payment->amount)
            <div class="discount-info">
                <h4><i class="fas fa-percentage"></i> Chegirma ma'lumotlari</h4>
                <div class="discount-row">
                    <span>Dastlabki summa:</span>
                    <span>{{ number_format($payment->original_amount) }} so'm</span>
                </div>
                <div class="discount-row">
                    <span>Chegirma ({{ $payment->discount_percent ?? 0 }}%):</span>
                    <span>-{{ number_format($payment->original_amount - $payment->amount) }} so'm</span>
                </div>
            </div>
            @endif

            <div class="amount-section">
                <div class="amount-label">To'langan summa</div>
                <div class="amount-value">{{ number_format($payment->amount ?? 0) }}</div>
                <div class="amount-currency">SO'M</div>
            </div>

            @if($payment->notes)
            <div class="notes-section">
                <strong><i class="fas fa-sticky-note"></i> Izoh:</strong>
                <p style="margin-top: 8px;">{{ $payment->notes }}</p>
            </div>
            @endif
        </div>

        <div class="receipt-footer">
            <p style="margin-bottom: 15px; color: #6c757d;">
                <i class="fas fa-shield-alt"></i> 
                Ushbu kvitansiya to'lovning rasmiy tasdiq hujjati hisoblanadi.
            </p>
            <p style="font-size: 14px; color: #6c757d;">
                Chop etilgan sana: {{ now()->format('d.m.Y H:i') }}
            </p>

            <div class="signature-section">
                <div class="signature-box">
                    <div class="signature-line"></div>
                    <div class="signature-label">Kassir imzosi</div>
                </div>
                <div class="signature-box">
                    <div class="signature-line"></div>
                    <div class="signature-label">Muhr o'rni</div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
</body>
</html>