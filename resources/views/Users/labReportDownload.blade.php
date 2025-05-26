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
            font-size: 20px;
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
            margin-bottom: 15px;
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
            font-size: 13px;
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

        /* Patient details table matching the photo exactly */
        .patient-details-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        .patient-details-table td {
            padding: 4px;
            border: 0px solid #ddd;
            vertical-align: middle;
        }
        .patient-details-table .label {
            font-weight: bold;
            width: 100px;
            padding-left: 8px;
        }
        .patient-details-table .value {
            width: 150px;
        }
        .patient-details-table .right-label {
            font-weight: bold;
            width: 110px;
            padding-left: 8px;
        }

        /* Test Results Table */
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
            font-size: 22px;
            font-weight: bold;
        }
        .test-results td {
            padding: 6px;
            border-bottom: 1px solid #ddd;
            font-size: 21px;
        }
        .title-row td {
            font-weight: bold;
            padding: 8px 6px;
            font-size: 18px;
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
        .technologist-signature {
            text-align: right;
            padding-top: 10px;
            border-top: 1px dotted #000;
            width: 300px;
            color: #2d5b84;
            font-weight: bold;
            font-size: 15px;
            position: absolute;
            right: 20px;
            bottom: 160px;
        }
        /* Footer with row layout */
        .footer {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            border-top: 1px solid #e45735;
            padding: 15px 20px;
            height: auto;
        }
        .footer-table {
            width: 100%;
            border-collapse: collapse;
        }
        .footer-table td {
            padding: 5px 10px;
            vertical-align: middle;
            font-size: 16px;
            color: #2d5b84;
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

            <!-- Patient Information Table - Exactly matching the photo -->
            <table class="patient-details-table">
                <tr>
                    <td class="label">PATIENT NAME:</td>
                    <td class="value">{{ $sampleData['patientName'] }}</td>
                    <td class="right-label">DATE:</td>
                    <td class="value">{{ $sampleData['reportDate'] }}</td>
                </tr>
                <tr>
                    <td class="label">AGE:</td>
                    <td class="value">{{ $sampleData['age'] }}</td>
                    <td class="right-label">REPORT ID:</td>
                    <td class="value">{{ $sampleData['reportId'] }}</td>
                </tr>
                <tr>
                    <td class="label">GENDER:</td>
                    <td class="value">{{ $sampleData['gender'] }}</td>
                    <td class="right-label">PRINTED DATE:</td>
                    <td class="value">{{ date('M d, Y') }}</td>
                </tr>
                <tr>
                    <td class="label">SPECIMEN:</td>
                    <td class="value">{{ $sampleData['specimenType'] }}</td>
                    <td class="right-label"></td>
                    <td class="value"></td>
                </tr>
                <tr>
                    <td class="label">TEST NAME:</td>
                    <td class="value" colspan="3">{{ $sampleData['testName'] }}</td>
                </tr>
            </table>

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

            <!-- Footer as a table row -->
            <div class="footer">
                <table class="footer-table">
                    <tr><td width="25%">
                        </td>
                        <td width="25%">
                            <strong>Equipment Used:</strong><br>
                            BC - 10 Fully Automated Hematology Analyzer<br>
                            BA - 88A Biochemistry Analyzer
                        </td>
                        <td width="25%">
                        </td>
                        <td width="25%">
                            <strong>Quality Control by:</strong><br>
                            Biolabo Extrol - P / Biolabo Extrol - N
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
