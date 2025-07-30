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
            padding: 20px 40px; /* Increased left and right padding */
            padding-bottom: 80px; /* Space for footer */
        }
        /* Header container */
/* Header Table */
.header-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 10px;
}

/* Logo Cell */
.logo-cell {
    width: 30%; /* Adjust width for logo and text */
    vertical-align: middle;
}

/* Contact Info Cell */
.contact-info-cell {
    width: 70%; /* Adjust width for contact info */
    text-align: right;
    vertical-align: middle;
}

/* Logo Container */
.logo-container {
    display: flex;
    align-items: center; /* Vertically align logo and text */
    gap: 12px; /* Space between logo and text */
}

/* Logo Styling */
.logo {
    width: 400px; /* Adjust logo size */
    height: auto; /* Maintain aspect ratio */
}

/* Logo Text Styling */
.logo-text h1 {
    color: #E74C3C; /* Red color for "HORIZON" */
    margin: 0;
    font-size: 50px; /* Adjust font size */
    font-weight: bold;
    letter-spacing: 1px;
    line-height: 1;
}

.logo-text h2 {
    color: #2d5b84; /* Gray color for "LABORATORY" */
    margin: 0;
    font-size: 35px; /* Adjust font size */
    font-weight: 600;
    letter-spacing: 2px;
    line-height: 1;
}

/* Contact Info Styling */
.contact-info {
    color: #2d5b84; /* Blue color for text */
    font-size: 24px;
}

.contact-info div {
    margin: 2px 0; /* Add spacing between lines */
}

/* Report Title Styling */
.report-title {
    color: #2d5b84; /* Blue color for the title */
    text-align: center; /* Center the title */
    font-size: 25px; /* Adjust font size */
    margin: 5px 0; /* Add spacing above and below */
    font-weight: bold;
}

/* Divider Line */
.divider {
    height: 4px;
    background-color: #2d5b84; /* Blue color for the line */
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
            font-size: 22px;
            font-weight: bold;
            width: 100px;
            padding-left: 8px;
        }
        .patient-details-table .value {
            font-size: 24px;
            width: 150px;
        }
        .patient-details-table .right-label {
            font-size: 22px;
            font-weight: bold;
            width: 110px;
            padding-left: 8px;
        }

        /* QR Code styling */
        .qr-code-container {
            display: flex;
            align-items: center;
            justify-content: flex-start;
        }

        .qr-code {
            width: 80px;
            height: 80px;
            border: none;
            display: inline-block;
        }

        .no-qr {
            font-size: 24px;
            color: #666;
        }

        /* Test Results Table */
        .test-results table {
            margin-top: 20PX;
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
            font-size: 23px;
        }
        .title-row td {
            font-weight: bold;
            padding: 8px 6px;
            font-size: 20px;
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

        /* Styling for HTML content in titles and paragraphs */
        .html-content h1 {
            font-size: 24px;
            font-weight: bold;
            margin: 8px 0 4px 0;
            color: #000000;
        }
        .html-content h2 {
            font-size: 22px;
            font-weight: bold;
            margin: 6px 0 3px 0;
            color: #2d5b84;
        }
        .html-content h3 {
            font-size: 20px;
            font-weight: bold;
            margin: 5px 0 2px 0;
            color: #2d5b84;
        }
        .html-content p {
            margin: 4px 0;
            line-height: 1.3;
        }
        .html-content br {
            line-height: 1.5;
        }
        .html-content strong, .html-content b {
            font-weight: bold;
        }
        .html-content em, .html-content i {
            font-style: italic;
        }
        .html-content u {
            text-decoration: underline;
        }

        /* Container for remark and signature */
        .remark-signature-wrapper {
            position: absolute;
            bottom: 90px; /* Adjust based on footer height */
            left: 40px; /* Align with container padding */
            right: 40px; /* Align with container padding */
            display: flex;
            justify-content: flex-end; /* Always push content to the right */
            align-items: flex-end;
            width: calc(100% - 80px); /* Account for left/right padding */
        }

        .remark-section {
            flex-grow: 1; /* Allows remark to take up available space */
            text-align: left;
            font-size: 20px; /* Adjust font size for PDF */
            color: #2d5b84;
            font-weight: bold;
            padding-right: 20px; /* Space between remark and signature */
        }

        /* Signature positioning and overall container */
        .technologist-signature {
            text-align: right; /* Aligns content (image and text) to the right */
            padding-top: 10px;
            width: 300px; /* Adjust width as needed for your signature and text */
            color: #2d5b84;
            font-weight: bold;
            font-size: 18px; /* Adjust font size for PDF */
            display: flex; /* Use flexbox to align image and text vertically */
            flex-direction: column; /* Stack them vertically */
            align-items: flex-end; /* Align items to the right within the flex container */
            margin-left: 850px;
            margin-bottom: 50px; /* Space between signature and footer */
        }

        /* Styling for the signature image */
        .signature-image {
            max-width: 400px; /* Adjust as needed, makes the image responsive to the container */
            height: auto; /* Maintain aspect ratio */
            margin-bottom: -10px; /* Pull the text closer to the signature image if needed */
        }

        /* Styling for the signature text */
        .signature-text {
            padding-top: 5px; /* Add a little padding above the text if the image is close */
            border-top: 1px dotted #000; /* Move the dotted line here to be above just the text */
            width: 100%; /* Ensure the border spans the width of the signature block */
            text-align: right;
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
        .footer-logo {
        width: 75%;
        margin-right: 5px;
        }
    </style>
    <!-- QR Code Library - Not needed for server-side generation -->
</head>
<body>
    <div class="page">
        <div class="container">
            <!-- Header -->
            <div class="header">
    <table class="header-table">
        <tr>
            <!-- Logo and Text -->
            <td class="logo-cell">
                <div class="logo-container">
                    <img src="{{ asset('img/report-logowith-text.png') }}" alt="Logo" class="logo">
                    {{-- <img src="{{ asset('img/report-logo.png') }}" alt="Logo" class="logo"> --}}
                    {{-- <div class="logo-text">
                        <h1>HORIZON</h1>
                        <h2>LABORATORY</h2>
                    </div> --}}
                </div>
            </td>
            <!-- Contact Information -->
            <td class="contact-info-cell">
                <div class="contact-info">
                    <b>
                    <div>No. 148/A4, Infront of Hospital, Bangalawaththa, Pugoda.</div>
                    <div style="font-weight: bold; color: red; font-size: 28px;">0776 267 627</div>
                    <div>horizonpugoda@gmail.com</div>
                    <div style="font-weight: bold; color: rgb(255, 0, 0); font-size: 23px;">HorizonLab.lk</div>
                    <div>SLMC No. 2102</div>
                    </b>
                </div>
            </td>
        </tr>
    </table>
    <!-- Report Title -->
    <div class="report-title">Confidential Laboratory Report</div>
    <div class="divider"></div>
</div>

            <!-- Patient Information Table - Exactly matching the photo -->
            <table class="patient-details-table">
                <tr>
                    <td class="label">PATIENT NAME:</td>
                    <td class="value">
                        @if ($sampleData['gender'] == 'M')
                            Mr. {{ $sampleData['patientName'] }}
                        @elseif ($sampleData['gender'] == 'F')
                            Ms. {{ $sampleData['patientName'] }}
                        @else
                            {{ $sampleData['patientName'] }}
                        @endif
                    </td>
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
                    <td class="value">
                        @if ($sampleData['gender'] == 'M')
                            Male
                        @elseif ($sampleData['gender'] == 'F')
                            Female
                        @elseif ($sampleData['gender'] == 'O')
                            Other
                        @else
                            {{ $sampleData['gender'] }}
                        @endif
                    </td>

                    <td class="right-label">NIC:</td>
                    <td class="value">
                        @if (!empty($sampleData['nicQrCode']))
                            <div class="qr-code-container">
                                <img src="{{ $sampleData['nicQrCode'] }}" alt="NIC QR Code" class="qr-code">
                            </div>
                        @elseif (!empty($sampleData['nic']))
                            <div class="qr-code-container">
                                <span class="no-qr">QR Code Generation Failed</span>
                            </div>
                        @else
                            -
                        @endif
                    </td>

                </tr>
                <tr>
                    <td class="label">SPECIMEN:</td>
                    <td class="value">{{ $sampleData['specimenType'] }}</td>


                    <td class="right-label">DOWNLOADED DATE:</td>
                    <td class="value">{{ date('M d, Y') }}</td>
                </tr>
                <tr>
                    <td class="label">TEST NAME:</td>
                    <td class="value" colspan="3"><b>{{ $sampleData['testName'] }}</b></td>
                </tr>
            </table>
<div class="divider"></div>
            <!-- Test Results -->
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
                        @foreach($sampleData['testResults'] as $test)
                            @if($test['isSpace'])
                                <tr class="space-row">
                                    <td colspan="3" height="8"></td>
                                </tr>
                            @elseif($test['isTitle'])
                                <tr class="title-row">
                                    <td colspan="3" class="html-content">{!! $test['name'] !!}</td>
                                </tr>
                            @elseif($test['isParagraph'])
                                <tr class="paragraph-row">
                                    <td colspan="3" class="html-content">{!! $test['result'] !!}</td>
                                </tr>
                            @else
                                <tr>
                                    <td>{{ $test['name'] }}</td>
                                    <td style="font-weight: bold;">{{ $test['result'] }}</td>
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

            <!-- Remark and Signature Container -->
            <div class="remark-signature-wrapper">
                @if (!empty($sampleData['remark']))
                    <div class="remark-section">
                        <strong><u>Remark:</u></strong> {{ $sampleData['remark'] }}
                    </div>
                @endif
                <!-- Signature -->
                <div class="technologist-signature">
                    <img src="{{ asset('img/sign.png') }}" alt="Medical Laboratory Scientist Signature" class="signature-image">
                    <div class="signature-text">Medical Laboratory Scientist</div>
                </div>
            </div>

            <!-- Footer as a table row -->
            <div class="footer">
                <table class="footer-table">
                    <tr><td width="20%" align="center">
                            <img src="https://bootflare.com/wp-content/uploads/2024/01/Mindray-Logo-1536x864.png" class="footer-logo">
                        </td>
                        <td width="30%">
                            <strong>Equipment Used:</strong><br>
                            BC - 10 Fully Automated Hematology Analyzer<br>
                            BA - 88A Biochemistry Analyzer
                        </td>
                        <td width="20%" align="center">
                            <img src="https://th.bing.com/th/id/R.528ea67c70a8b88e4f07b6567175c74b?rik=RDLPE98IbpDh0Q&riu=http%3a%2f%2fasfgestion.com%2fimages%2flabomed%2fLabomed_Logo_min.png&ehk=sxPj6Y0OXXeHpX7lqL%2fNLOANJg%2fbvRvL6asrK5Qy4y4%3d&risl=&pid=ImgRaw&r=0" class="footer-logo">
                        </td>
                        <td width="30%">
                            <strong>Quality Control by:</strong><br>
                            Biolabo Extrol - P / Biolabo Extrol - N
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <!-- Server-side QR code generation - no JavaScript needed -->
</body>
</html>
