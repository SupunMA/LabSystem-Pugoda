<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laboratory Report</title>
      {{-- fav icon --}}
    <link rel="icon" type="image/png" sizes="32x32" href="/img/fav.png">
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
    /* Page structure */
    .page {
        width: 210mm;
        height: 297mm;
        margin: 20px auto;
        position: relative;
        background: white;
        box-sizing: border-box;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        overflow: hidden;
        page-break-after: always;
    }
    .page:last-child {
        page-break-after: avoid;
    }
    .container {
        padding: 20px;
        padding-bottom: 60px; /* Make space for footer */
        width: 100%;
        box-sizing: border-box;
        min-height: calc(100% - 80px);
    }
    .header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 10px;
        background-color: transparent;
        width: 100%;
    }
    .logo-container {
        display: flex;
        align-items: center;
    }
    .logo {
        width: 70px;
        margin-right: 10px;
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
        margin: 5px 0px;
        font-weight: bold;
    }
    .divider {
        height: 4px;
        background-color: #2d5b84;
        margin-bottom: 30px;
        width: 100%;
    }
    .patient-info {
        display: grid;
        grid-template-columns: 1fr 1fr;
        margin-bottom: 2px;
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
        font-size: 14px;
        font-weight: bold;
    }
    .info-label {
        width: 110px;
        font-weight: bold;
        font-size: 14px;
    }
    .specimen-info {
        margin-bottom: 15px;
        width: 100%;
    }

    /* New horizontal line style */
    .section-divider {
        height: 2px;
        background-color: #2d5b84;
        margin: 0px 0;
        width: 100%;
    }

    .test-results {
        width: 100%;
        margin-top: 25px; /* Added space above the table */
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
        font-size: 15px;
        font-weight: bold;
        text-decoration: underline;
    }

    .test-results td {
        padding: 6px;
        border-bottom: 1px solid #ddd;
        font-size: 13px;
        font-weight: bold;
        background-color: transparent;
    }

    .scientist-signature {
        text-align: right;
        padding-top: 10px;
        /* border-top: 1px dotted #000; */
        width: 200px;
        color: #2d5b84;
        font-weight: bold;
        font-size: 11px;
        position: absolute;
        right: 20px;
        bottom: 90px;

        display: flex;
        flex-direction: column;
        align-items: center;
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
        background-color: white;
    }

    .footer-item {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        width: 50%;
    }

    .footer-logo {
        width: 30%;
        margin-right: 10px;

    }

    .footer-text {
        color: #2d5b84;
        font-size: 11px;
        font-weight: bold;
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

        .page {
            margin: 0;
            box-shadow: none;
        }

        .page {
            page-break-after: always;
        }

        .page:last-child {
            page-break-after: avoid;
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

    /* Page number indicator */
    /* .page-number {
        position: absolute;
        bottom: 10px;
        right: 20px;
        font-size: 10px;
        color: #666;
    } */

    /* Continuation header for additional pages */
    .continuation-header {
        padding: 10px 0;
        border-bottom: 1px solid #2d5b84;
        margin-bottom: 15px;
        display: flex;
        justify-content: space-between;
    }

    .continuation-header .patient-name {
        font-weight: bold;
        color: #2d5b84;
    }

    .continuation-header .report-id {
        color: #e45735;
    }

    /* Updated hidden classes to preserve space */
    .header.hidden,
    .continuation-header.hidden,
    .report-title.hidden,
    .divider.hidden,
    .section-divider.hidden {
        visibility: hidden;
        opacity: 0;
        height: auto; /* Preserve the height */
    }

    .footer.hidden {
        visibility: hidden;
        opacity: 0;
        height: 60px; /* Ensure the footer height is preserved */
    }

    .scientist-signature.hidden {
        visibility: hidden;
        opacity: 0;
        height: auto; /* Preserve the height */
    }

    /* QR code */
    .qr-code-inline {
        display: inline-block;
        vertical-align: middle;
        margin-left: 10px;
    }

    .qr-code-inline canvas {
        border: 1px solid #ddd;
        vertical-align: middle;
    }
</style>
</head>
<body>
<div class="preview-controls">

    <button onclick="window.print()" style="padding: 10px 20px; background-color: #2d5b84; color: white; border: none; border-radius: 4px; cursor: pointer; margin-right: 10px;">
        <i class="fas fa-print"></i> Print Preview
    </button>
    <a href="{{ route('admin.addReport') }}" style="padding: 10px 20px; background-color: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer; text-decoration: none;">
        <i class="fas fa-arrow-left"></i> Back to Reports
    </a>

    <!-- Toggle switches -->
    <div class="toggle-controls" style="margin-top: 10px; display: flex; gap: 15px; justify-content: center;">
        <label style="display: flex; align-items: center;">
            <input type="checkbox" id="headerToggle" checked onchange="updateReportElements()">
            <span style="margin-left: 5px;">Show Header</span>
        </label>
        <label style="display: flex; align-items: center;">
            <input type="checkbox" id="footerToggle" checked onchange="updateReportElements()">
            <span style="margin-left: 5px;">Show Footer</span>
        </label>
        <label style="display: flex; align-items: center;">
            <input type="checkbox" id="signatureToggle" checked onchange="updateReportElements()">
            <span style="margin-left: 5px;">Show Signature</span>
        </label>
    </div>

    <p style="margin-top: 5px; color: #666; font-size: 12px;">This is a preview showing how the lab report will appear. Sample data is used.</p>
</div>


<!-- Report content will be generated by JavaScript -->
<div id="report-container"></div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
    // Use the data from the PHP controller
    const sampleData = {!! json_encode($sampleData) !!};

    // Process test results to ensure they're properly formatted for display
    function generateSampleTestResults() {
        return sampleData.testResults;
    }

    // Function to format the date
    function formatDate(date) {
        const options = { year: 'numeric', month: 'long', day: 'numeric' };
        return date.toLocaleDateString(undefined, options);
    }

    // Function to create a single page of the report
// Function to create a single page of the report
function createReportPage(isFirstPage, pageNumber, totalPages) {
    const page = document.createElement('div');
    page.className = 'page';

    const container = document.createElement('div');
    container.className = 'container';
    page.appendChild(container);

    let nicRowHtml = '';
    if (sampleData.nic) {
        nicRowHtml = `
            <div class="info-row">
                <div class="info-label">NIC </div>
                <div class="info-value">: <span id="qr-code-container" class="qr-code-inline"></span></div>
            </div>
        `;
    }

    if (isFirstPage) {
        // First page has the full header
        container.innerHTML = `
            <div class="header">
                <div class="logo-container">
                    <div class="logo">
                        <img src="{{ asset('img/report-logo.png') }}" width="100%">
                    </div>
                    <div class="logo-text">
                        <h1><b>HORIZON</b></h1>
                        <h2>LABORATORY</h2>
                    </div>
                </div>
                <div class="contact-info"  style="font-weight: bold; font-size: 15px">
                    <div >No. 148/A4, Infront of Hospital, Bangalawaththa, Pugoda.</div>
                    <div style="font-weight: bold; color: red; font-size: 20px;">0776 267 627</div>
                    <div style="font-weight: bold; color: red; font-size: 13px;">HorizonLab.lk</div>
                    <div>horizonpugoda@gmail.com</div>
                    <div>SLMC No. 2102</div>
                </div>
            </div>

            <div class="report-title">Confidential Laboratory Report</div>
            <div class="divider"></div>

            <div class="patient-info">
                <div class="patient-details">
        <div class="info-row">
        <div class="info-label">PATIENT NAME </div>
        <div class="info-value">
            ${
                sampleData.gender === 'M' ? ': Mr. ' + sampleData.patientName :
                sampleData.gender === 'F' ? ': Ms. ' + sampleData.patientName :
                sampleData.patientName
            }
        </div>
        </div>
        <div class="info-row">
            <div class="info-label">AGE </div>
            <div class="info-value"> : ${sampleData.age}</div>
        </div>
        <div class="info-row">
            <div class="info-label">GENDER </div>
            <div class="info-value">
                ${
                    sampleData.gender === 'M' ? ': Male' :
                    sampleData.gender === 'F' ? ': Female' :
                    sampleData.gender === 'O' ? ': Other' :
                    sampleData.gender
                }
            </div>
        </div>
        <div class="info-row">
            <div class="info-label">SPECIMEN </div>
            <div class="info-value">: ${sampleData.specimenType || 'Not specified'}</div>
        </div>
        <div class="info-row">
            <div class="info-label">TEST NAME</div>
            <div class="info-value">: ${sampleData.testName || 'Not specified'}</div>
        </div>
    </div>
                <div class="report-details">
                    <div class="info-row">
                        <div class="info-label">DATE </div>
                        <div class="info-value">: ${sampleData.reportDate}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">REPORT ID </div>
                        <div class="info-value">: ${sampleData.reportId}</div>
                    </div>
                    ${nicRowHtml}
                    <div class="info-row">
                        <div class="info-label">PRINTED DATE </div>
                        <div class="info-value">: ${formatDate(new Date())}</div>
                    </div>
                </div>
            </div>


            <div class="section-divider"></div>
        `;
    } else {
        // Continuation pages have a simplified header
        container.innerHTML = `
            <div class="continuation-header">
                <div class="patient-name">Patient : ${sampleData.patientName}</div>
                <div class="report-id">Report ID : ${sampleData.reportId}</div>
            </div>
        `;
    }

    // Add the test results table container
    const testResultsDiv = document.createElement('div');
    testResultsDiv.className = 'test-results';
    container.appendChild(testResultsDiv);

    // Add the footer
    const footer = document.createElement('div');
    footer.className = 'footer';
    footer.innerHTML = `
        <div class="footer-item">
            <img src="https://bootflare.com/wp-content/uploads/2024/01/Mindray-Logo-1536x864.png" class="footer-logo">
            <span class="footer-text">BC - 10 Fully Automated Hematology Analyzer <br> BA - 88A Biochemistry Analyzer</span>
        </div>
        <div class="footer-item">
            <img src="https://th.bing.com/th/id/R.528ea67c70a8b88e4f07b6567175c74b?rik=RDLPE98IbpDh0Q&riu=http%3a%2f%2fasfgestion.com%2fimages%2flabomed%2fLabomed_Logo_min.png&ehk=sxPj6Y0OXXeHpX7lqL%2fNLOANJg%2fbvRvL6asrK5Qy4y4%3d&risl=&pid=ImgRaw&r=0" class="footer-logo">
            <span class="footer-text">Quality Control by:<br> Biolabo Extrol - P / Biolabo Extrol - N</span>
        </div>
    `;
    page.appendChild(footer);

    return { page, testResultsContainer: testResultsDiv };
}

    // Function to distribute test results across pages
    function distributeTestResults(testResults) {
        sampleData.testResults = generateSampleTestResults();
        const testResultsPerPage = isFirstPage => isFirstPage ? 22 : 35; // Reduced capacity for first page due to added spacing
        let currentPage = 1;
        let resultsOnCurrentPage = 0;
        let isFirstPage = true;
        const pages = [];
        let currentTestResults = [];

        // First, calculate how many pages we need
        let totalPages = 1;
        let remainingResults = sampleData.testResults.length;
        let firstPageCapacity = testResultsPerPage(true);

        if (remainingResults <= firstPageCapacity) {
            totalPages = 1;
        } else {
            remainingResults -= firstPageCapacity;
            totalPages = 1 + Math.ceil(remainingResults / testResultsPerPage(false));
        }

        // Now create pages and distribute test results
        isFirstPage = true;
        remainingResults = sampleData.testResults.length;

        for (let i = 0; i < sampleData.testResults.length; i++) {
            const result = sampleData.testResults[i];

            if (resultsOnCurrentPage >= testResultsPerPage(isFirstPage) ||
                (result.isTitle && resultsOnCurrentPage > 0 && resultsOnCurrentPage >= testResultsPerPage(isFirstPage) - 5)) {
                // Create a new page
                const { page, testResultsContainer } = createReportPage(isFirstPage, currentPage, totalPages);

                // Add the table with current results
                testResultsContainer.appendChild(createTestResultsTable(currentTestResults));

                // Add the page to our collection
                pages.push(page);

                // Reset for next page
                currentTestResults = [];
                resultsOnCurrentPage = 0;
                currentPage++;
                isFirstPage = false;
            }

            currentTestResults.push(result);
            resultsOnCurrentPage++;
        }

        // Don't forget the last page if there are remaining results
        if (currentTestResults.length > 0) {
            const { page, testResultsContainer } = createReportPage(isFirstPage, currentPage, totalPages);
            testResultsContainer.appendChild(createTestResultsTable(currentTestResults));

            // Add scientist signature to the last page
            const techSignature = document.createElement('div');
            techSignature.className = 'scientist-signature';
            techSignature.innerHTML = `
                <img src="{{ asset('img/sign.png') }}" alt="Signature" style="width: 270px; height: auto; margin-right: 40px;">
                <div>Medical Laboratory Scientist</div>
            `;
            page.querySelector('.container').appendChild(techSignature);

            pages.push(page);
        }

        return pages;
    }

    // Function to create test results table
    function createTestResultsTable(testResults) {
        const table = document.createElement('table');

        // Create table header
        const thead = document.createElement('thead');
        thead.innerHTML = `
            <tr>
                <th>Test</th>
                <th>Result</th>
                <th>Reference Range</th>
            </tr>
        `;
        table.appendChild(thead);

        // Create table body
        const tbody = document.createElement('tbody');

        testResults.forEach(test => {
            const tr = document.createElement('tr');

            if (test.isSpace) {
                tr.className = 'space-row';
                tr.innerHTML = `<td colspan="3" height="20"></td>`;
            } else if (test.isTitle) {
                tr.className = 'title-row';
                tr.innerHTML = `<td colspan="3">${test.name}</td>`;
            } else if (test.isParagraph) {
                tr.className = 'paragraph-row';
                tr.innerHTML = `<td colspan="3">${test.result}</td>`;
            } else if (test.isCategory) {
                // Handle the category type from controller
                let referenceDisplay;

                if (typeof test.reference === 'object' && test.reference.isTable) {
                    // Create a reference table
                    const refTable = document.createElement('table');
                    refTable.className = 'reference-table';

                    test.reference.data.forEach(row => {
                        const refRow = document.createElement('tr');
                        row.forEach(cell => {
                            const td = document.createElement('td');
                            td.textContent = cell;
                            refRow.appendChild(td);
                        });
                        refTable.appendChild(refRow);
                    });

                    referenceDisplay = refTable.outerHTML;
                } else {
                    referenceDisplay = test.reference;
                }

                tr.innerHTML = `
                    <td>${test.name}</td>
                    <td>${test.result}</td>
                    <td>${referenceDisplay}</td>
                `;
            } else {
                let referenceDisplay;

                if (typeof test.reference === 'object' && test.reference.isTable) {
                    // Create a reference table
                    const refTable = document.createElement('table');
                    refTable.className = 'reference-table';

                    test.reference.data.forEach(row => {
                        const refRow = document.createElement('tr');
                        row.forEach(cell => {
                            const td = document.createElement('td');
                            td.textContent = cell;
                            refRow.appendChild(td);
                        });
                        refTable.appendChild(refRow);
                    });

                    referenceDisplay = refTable.outerHTML;
                } else {
                    referenceDisplay = test.reference;
                }

                tr.innerHTML = `
                    <td>${test.name}</td>
                    <td>${test.result}</td>
                    <td>${referenceDisplay}</td>
                `;
            }

            tbody.appendChild(tr);
        });

        table.appendChild(tbody);
        return table;
    }

    // Function to update the visibility of report elements based on toggle switches
    function updateReportElements() {
        const showHeader = document.getElementById('headerToggle').checked;
        const showFooter = document.getElementById('footerToggle').checked;
        const showSignature = document.getElementById('signatureToggle').checked;

        // Update headers
        document.querySelectorAll('.header, .continuation-header').forEach(el => {
            el.classList.toggle('hidden', !showHeader);
        });

        // Update report title and divider (also part of header)
        document.querySelectorAll('.report-title, .divider, .section-divider').forEach(el => {
            el.classList.toggle('hidden', !showHeader);
        });

        // Update footers
        document.querySelectorAll('.footer').forEach(el => {
            el.classList.toggle('hidden', !showFooter);
        });

        // Update signatures
        document.querySelectorAll('.scientist-signature').forEach(el => {
            el.classList.toggle('hidden', !showSignature);
        });
    }

    // Function to generate the multi-page report
    function generateMultiPageReport() {
        const reportContainer = document.getElementById('report-container');
        reportContainer.innerHTML = ''; // Clear any existing content

        // Generate and append pages
        const pages = distributeTestResults(sampleData.testResults);
        pages.forEach(page => {
            reportContainer.appendChild(page);
        });

        // Apply current toggle states
        updateReportElements();

        // Generate QR code after pages are created
        setTimeout(() => {
            generateQRCode(sampleData.nic, 'qr-code-container');
        }, 100);
    }

    // Initialize the report on page load
    document.addEventListener('DOMContentLoaded', function() {
        generateMultiPageReport();
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcode-generator/1.4.4/qrcode.min.js"></script>

<script>
    function generateQRCode(text, containerId) {
    const qr = qrcode(0, 'M');
    qr.addData(text);
    qr.make();

    const canvas = document.createElement('canvas');
    const ctx = canvas.getContext('2d');
    const modules = qr.getModuleCount();
    const cellSize = 3; // Increased from 2 to 3 for larger QR code

    canvas.width = modules * cellSize;
    canvas.height = modules * cellSize;

    ctx.fillStyle = '#FFFFFF';
    ctx.fillRect(0, 0, canvas.width, canvas.height);
    ctx.fillStyle = '#000000';

    for (let row = 0; row < modules; row++) {
        for (let col = 0; col < modules; col++) {
            if (qr.isDark(row, col)) {
                ctx.fillRect(col * cellSize, row * cellSize, cellSize, cellSize);
            }
        }
    }

    const container = document.getElementById(containerId);
    if (container) {
        container.appendChild(canvas);
    }
}
</script>
</body>
</html>
