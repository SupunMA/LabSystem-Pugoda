<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laboratory Report</title>
<style>
    @page {
        size: A4;
        margin: 0;
    }
    html, body {
        width: 100%;
        height: 100%;
        margin: 0;
        padding: 0;
    }
    body {
        font-family: Arial, sans-serif;
        font-size: 12px;
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .page {
        width: 210mm;
        height: 297mm;
        margin: 0 auto;
        position: relative;
        background: white;
        box-sizing: border-box;
    }
    .container {
        padding: 20px;
        padding-bottom: 100px; /* Make space for footer */
        width: 100%;
        box-sizing: border-box;
    }
    .header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 20px;
        background-color: transparent;
        width: 100%;
    }
    .logo-container {
        display: flex;
        align-items: center;
    }
    .logo {
        width: 50px;
        margin-right: 10px;
    }
    .logo-text {
        display: flex;
        flex-direction: column;
    }
    .logo-text h1 {
        color: #e45735;
        margin: 0;
        font-size: 24px;
        font-weight: bold;
        line-height: 1;
    }
    .logo-text h2 {
        color: #2d5b84;
        margin: 0;
        font-size: 14px;
        font-weight: bold;
    }
    .contact-info {
        text-align: right;
        color: #2d5b84;
        font-size: 11px;
    }
    .report-title {
        color: #2d5b84;
        text-align: center;
        font-size: 18px;
        margin: 15px 0;
        font-weight: bold;
    }
    .divider {
        height: 2px;
        background-color: #2d5b84;
        margin-bottom: 20px;
        width: 100%;
    }
    .patient-info {
        display: grid;
        grid-template-columns: 1fr 1fr;
        margin-bottom: 20px;
        width: 100%;
    }
    .patient-details, .report-details {
        padding: 10px;
    }
    .info-row {
        display: flex;
        margin-bottom: 8px;
    }
    .info-value {
        font-size: 12px;
    }
    .info-label {
        width: 110px;
        font-weight: bold;
        font-size: 12px;
    }
    .specimen-info {
        margin-bottom: 20px;
        width: 100%;
    }
    .test-results {
        width: 100%;
    }
    .test-results table {
        width: 100%;
        border-collapse: collapse;
    }

    /* Add background color ONLY to the header row */
    .test-results thead tr {
        background-color: #f2f2f2;
    }

    .test-results th {
        text-align: left;
        padding: 6px;
        font-size: 12px;
        font-weight: bold;
    }

    .test-results td {
        padding: 6px;
        border-bottom: 1px solid #ddd;
        font-size: 12px;
        background-color: transparent;
    }

    .technologist-signature {
        text-align: right;
        padding-top: 10px;
        border-top: 1px dotted #000;
        width: 200px;
        color: #2d5b84;
        font-weight: bold;
        font-size: 11px;
        position: absolute;
        right: 20px;
        bottom: 80px;
    }

    .footer-wrapper {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 60px;
        width: 100%;
    }

    .footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 20px;
        border-top: 1px solid #e45735;
        padding-top: 10px;
        width: calc(100% - 40px);
        position: absolute;
        bottom: 20px;
    }

    .footer-logo {
        height: 40px;
    }
    .footer-text {
        color: #666;
        font-size: 10px;
    }

    /* Specific styling for reference tables */
    .reference-table {
        border-collapse: collapse;
        width: 100%;
        font-size: 90%;
    }

    .reference-table td, .reference-table th {
        border: 1px solid #ddd;
        padding: 2px 4px;
        text-align: center;
        background-color: transparent;
    }

    /* Preview controls */
    .preview-controls {
        position: sticky;
        top: 0;
        left: 0;
        right: 0;
        z-index: 1000;
        background-color: #f8f9fa;
        padding: 10px;
        text-align: center;
        border-bottom: 1px solid #ddd;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        width: 100%;
    }

    @media print {
        .preview-controls {
            display: none;
        }

        body {
            print-color-adjust: exact;
            -webkit-print-color-adjust: exact;
        }
    }

    /* Test name styling */
    .test-name-row .info-value {
        font-size: 14px;
        font-weight: bold;
        color: #2d5b84;
    }

    /* Title and paragraph styles - no background colors */
    .title-row td {
        font-weight: bold;
        padding: 8px 6px;
        font-size: 13px;
        background-color: transparent;
    }

    .paragraph-row td {
        font-style: italic;
        background-color: transparent;
    }

    .space-row td {
        height: 20px;
        border-bottom: none !important;
        background-color: transparent;
    }
</style>
</head>
<body>
<div class="preview-controls">
    <button onclick="downloadReport()" style="padding: 10px 20px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; margin-right: 10px;">
        <i class="fas fa-download"></i> Download Report
    </button>
    <button onclick="window.print()" style="padding: 10px 20px; background-color: #2d5b84; color: white; border: none; border-radius: 4px; cursor: pointer; margin-right: 10px;">
        <i class="fas fa-print"></i> Print Preview
    </button>
    <a href="{{ route('admin.allAvailableTest') }}" style="padding: 10px 20px; background-color: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer; text-decoration: none;">
        <i class="fas fa-arrow-left"></i> Back to Tests
    </a>
    <p style="margin-top: 5px; color: #666; font-size: 12px;">This is a preview showing how the lab report will appear. Sample data is used.</p>
</div>

<div class="page">
    <div class="container">
        <div class="header">
            <div class="logo-container">
                <div class="logo">
                    <svg viewBox="0 0 50 50" xmlns="http://www.w3.org/2000/svg">
                        <rect x="5" y="5" width="10" height="40" fill="#2d5b84" />
                        <rect x="20" y="15" width="10" height="30" fill="#2d5b84" />
                        <rect x="35" y="10" width="10" height="35" fill="#2d5b84" />
                    </svg>
                </div>
                <div class="logo-text">
                    <h1>HORIZON</h1>
                    <h2>LABORATORY</h2>
                </div>
            </div>
            <div class="contact-info">
                <div>100, Main road, Colombo</div>
                <div>+947712545</div>
                <div>horizon@gamill.com</div>
                <div>register 1029</div>
            </div>
        </div>

        <div class="report-title">Confidential Laboratory Report</div>
        <div class="divider"></div>

        <div class="patient-info">
            <div class="patient-details">
                <div class="info-row">
                    <div class="info-label">PATIENT NAME:</div>
                    <div class="info-value">{{ $sampleData['patientName'] }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">AGE:</div>
                    <div class="info-value">{{ $sampleData['age'] }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">GENDER:</div>
                    <div class="info-value">{{ $sampleData['gender'] }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">REPORT ID:</div>
                    <div class="info-value">{{ $sampleData['reportId'] }}</div>
                </div>
            </div>
            <div class="report-details">
                <div class="info-row">
                    <div class="info-label">DATE:</div>
                    <div class="info-value">{{ $sampleData['reportDate'] }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">REPORT ID:</div>
                    <div class="info-value">{{ $sampleData['reportId'] }}</div>
                </div>
            </div>
        </div>

        <div class="specimen-info">
            <div class="info-row">
                <div class="info-label">TEST NAME:</div>
                <div class="info-value">{{ $sampleData['testName'] ?? 'Not specified' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">SPECIMEN:</div>
                <div class="info-value">{{ $sampleData['specimenType'] ?? 'Not specified' }}</div>
            </div>
        </div>

        <div class="test-results">
    <table>
        <thead>
            <tr>
                <th>Test</th>
                <th>Result</th>
                <th>Reference Range</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sampleData['testResults'] as $test)
                @if(isset($test['isSpace']) && $test['isSpace'])
                    <tr class="space-row">
                        <td colspan="3" height="20"></td>
                    </tr>
                @elseif(isset($test['isTitle']) && $test['isTitle'])
                    <tr class="title-row">
                        <td colspan="3">{{ $test['name'] }}</td>
                    </tr>
                @elseif(isset($test['isParagraph']) && $test['isParagraph'])
                    <tr class="paragraph-row">
                        <td colspan="3">{{ $test['result'] }}</td>
                    </tr>
                @else
                    <tr>
                        <td>{{ $test['name'] }}</td>
                        <td>{{ $test['result'] }}</td>
                        <td>
                            @if(is_array($test['reference']) && isset($test['reference']['isTable']) && $test['reference']['isTable'])
                                <table class="reference-table">
                                    @foreach($test['reference']['data'] as $rowIndex => $row)
                                        <tr>
                                            @foreach($row as $cellValue)
                                                <td>{{ $cellValue }}</td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </table>
                            @else
                                {{ $test['reference'] }}
                            @endif
                        </td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</div>

        <div class="technologist-signature">
            Laboratory Technologist
        </div>
    </div>

    <div class="footer-wrapper">
        <div class="footer">
            <div class="footer-left">
                <span class="footer-text">healthcare within reach</span>
            </div>
            <div class="footer-center">
                <span class="footer-text">Report Preview Mode</span>
            </div>
            <div class="footer-right">
                <span class="footer-text">ideas for vision</span>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
    function downloadReport() {
        // Create a clone of the document for export
        const pageElement = document.querySelector('.page');
        const clone = pageElement.cloneNode(true);

        // Create a temporary container to hold just the page
        const container = document.createElement('div');
        container.style.width = '210mm';
        container.style.height = '297mm';
        container.style.margin = '0';
        container.style.position = 'relative';
        container.style.backgroundColor = 'white';
        container.appendChild(clone);

        // Set HTML2PDF options with fixed dimensions
        const opt = {
            margin: 0,
            filename: 'Lab_Report.pdf',
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: {
                scale: 2,
                useCORS: true,
                logging: false,
                letterRendering: true
            },
            jsPDF: {
                unit: 'mm',
                format: 'a4',
                orientation: 'portrait'
            }
        };

        // Generate and download PDF - use the page element directly instead of body
        html2pdf().from(pageElement).set(opt).save();
    }
</script>

</body>
</html>
