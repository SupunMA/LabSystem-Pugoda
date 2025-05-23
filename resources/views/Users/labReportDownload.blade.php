<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laboratory Report</title>
    <style>
        /* Base styles */
        @page {
            size: A4 portrait;
            margin: 0;
        }
        html, body {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }
        /* Page structure */
        .page {
            width: 100%;
            min-height: 100%;
            position: relative;
            background: white;
            overflow: hidden;
            page-break-after: always;
        }
        .container {
            padding: 20px;
            padding-bottom: 80px; /* Space for footer */
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 10px;
        }
        .logo-container {
            display: flex;
            align-items: center;
        }
        .logo-text {
            display: flex;
            flex-direction: column;
        }
        .logo-text h1 {
            color: #e45735;
            margin: 0;
            font-size: 35px;
            font-weight: bold;
            line-height: 1;
        }
        .logo-text h2 {
            color: #2d5b84;
            margin: 0;
            font-size: 18px;
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
            margin: 5px 0;
            font-weight: bold;
        }
        .divider {
            height: 4px;
            background-color: #2d5b84;
            margin-bottom: 20px;
        }
        .patient-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            margin-bottom: 2px;
        }
        .info-row {
            display: flex;
            margin-bottom: 8px;
        }
        .info-value {
            font-size: 14px;
        }
        .info-label {
            width: 110px;
            font-weight: bold;
            font-size: 12px;
        }
        .test-results table {
            width: 100%;
            border-collapse: collapse;
        }
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
            font-size: 13px;
        }
        .title-row td {
            font-weight: bold;
            padding: 8px 6px;
            font-size: 13px;
        }
        .paragraph-row td {
            font-style: italic;
        }
        .space-row td {
            height: 20px;
            border-bottom: none !important;
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
            bottom: 100px;
        }
        .reference-table {
            border-collapse: collapse;
            width: 100%;
            font-size: 90%;
        }
        .reference-table td, .reference-table th {
            border: 1px solid #ddd;
            padding: 2px 4px;
            text-align: center;
        }
        .footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            border-top: 1px solid #e45735;
            width: calc(100% - 40px);
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 60px;
        }
        .footer-item {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            width: 48%;
        }
        .footer-logo {
            width: 25%;
            margin-right: 15px;
        }
        .footer-text {
            color: #2d5b84;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="page">
        <div class="container">
            <!-- Header -->
            <div class="header">
                <div class="logo-container">
                    <div class="logo-text">
                        <h1><b>HORIZON</b></h1>
                        <h2>LABORATORY</h2>
                    </div>
                </div>
                <div class="contact-info" style="font-weight: bold; font-size: 15px">
                    <div>No. 148/A4, Infront of Hospital, Bangalawaththa, Pugoda.</div>
                    <div style="font-weight: bold; color: red; font-size: 20px;">0776 267 627</div>
                    <div>horizonpugoda@gmail.com</div>
                    <div>SLMC No. 2102</div>
                </div>
            </div>

            <!-- Report Title -->
            <div class="report-title">Confidential Laboratory Report</div>
            <div class="divider"></div>

            <!-- Patient Information -->
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
                    <div class="info-row">
                        <div class="info-label">PRINTED DATE:</div>
                        <div class="info-value">{{ date('Y-m-d') }}</div>
                    </div>
                </div>
            </div>

            <!-- Specimen Information -->
            <div class="specimen-info">
                <div class="info-row">
                    <div class="info-label">SPECIMEN:</div>
                    <div class="info-value">{{ $sampleData['specimenType'] }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">TEST NAME:</div>
                    <div class="info-value">{{ $sampleData['testName'] }}</div>
                </div>
            </div>

            <!-- Test Results -->
            <div class="test-results">
                <table>
                    <thead>
                        <tr>
                            <th>Test Parameter</th>
                            <th>Result</th>
                            <th>Reference Range</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sampleData['testResults'] as $test)
                            @if($test['isSpace'])
                                <tr class="space-row">
                                    <td colspan="3" height="20"></td>
                                </tr>
                            @elseif($test['isTitle'])
                                <tr class="title-row">
                                    <td colspan="3">{{ $test['name'] }}</td>
                                </tr>
                            @elseif($test['isParagraph'])
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
                                                @foreach($test['reference']['data'] as $row)
                                                    <tr>
                                                        @foreach($row as $cell)
                                                            <td>{{ $cell }}</td>
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

            <!-- Signature -->
            <div class="technologist-signature">
                Medical Laboratory Technologist
            </div>

            <!-- Footer -->
            <div class="footer">
                <div class="footer-item">
                    <span class="footer-text">BC - 10 Fully Automated Hematology Analyzer <br> BA - 88A Biochemistry Analyzer</span>
                </div>
                <div class="footer-item">
                    <span class="footer-text">Quality Control by:<br> Biolabo Extrol - P / Biolabo Extrol - N</span>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
