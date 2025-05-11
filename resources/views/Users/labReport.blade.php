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
        margin-bottom: 5px;
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
        font-size: 12px;
    }
    .info-label {
        width: 110px;
        font-weight: bold;
        font-size: 12px;
    }
    .specimen-info {
        margin-bottom: 5px;
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
        bottom: 120px;
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
        height: 80px;
        background-color: white;
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
    .page-number {
        position: absolute;
        bottom: 10px;
        right: 20px;
        font-size: 10px;
        color: #666;
    }

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
    .divider.hidden {
        visibility: hidden;
        opacity: 0;
        height: auto; /* Preserve the height */
    }

    .footer.hidden {
        visibility: hidden;
        opacity: 0;
        height: 60px; /* Ensure the footer height is preserved */
    }

    .technologist-signature.hidden {
        visibility: hidden;
        opacity: 0;
        height: auto; /* Preserve the height */
    }
</style>
</head>
<body>
<div class="preview-controls">
    <button onclick="downloadReport()()" style="padding: 10px 20px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; margin-right: 10px;">
        <i class="fas fa-download"></i> Download Report
    </button>
    <button onclick="window.print()" style="padding: 10px 20px; background-color: #2d5b84; color: white; border: none; border-radius: 4px; cursor: pointer; margin-right: 10px;">
        <i class="fas fa-print"></i> Print Preview
    </button>
    <a href="{{ route('admin.allAvailableTest') }}" style="padding: 10px 20px; background-color: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer; text-decoration: none;">
        <i class="fas fa-arrow-left"></i> Back to Tests
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
        // Use the test results directly from the controller
        const testResults = sampleData.testResults || [];

        // Process the results to match our expected format
        const processedResults = testResults.map(item => {
            // Handle reference tables that come from the controller
            if (item.reference && typeof item.reference === 'object' && item.reference.isTable) {
                // Ensure the table data is properly formatted
                const referenceTable = item.reference;
                // Make sure we have a consistent format even if the controller provides inconsistent data
                if (!Array.isArray(referenceTable.data)) {
                    // Convert object format to array if needed
                    const tableArray = [];
                    for (const rowIndex in referenceTable.data) {
                        tableArray.push(referenceTable.data[rowIndex]);
                    }
                    referenceTable.data = tableArray;
                }
            }

            // Map controller result keys to our format
            return {
                name: item.name || '',
                result: item.result || '',
                reference: item.reference || '',
                isTitle: item.isTitle || false,
                isParagraph: item.isParagraph || false,
                isSpace: item.isSpace || false,
                isCategory: item.isCategory || false
            };
        });

        return processedResults;
    }

    // Function to format the date
    function formatDate(date) {
        const options = { year: 'numeric', month: 'long', day: 'numeric' };
        return date.toLocaleDateString(undefined, options);
    }

    // Function to create a single page of the report
function createReportPage(isFirstPage, pageNumber, totalPages) {
    const page = document.createElement('div');
    page.className = 'page';

    const container = document.createElement('div');
    container.className = 'container';
    page.appendChild(container);

    if (isFirstPage) {
        // First page has the full header
        container.innerHTML = `
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
                        <div class="info-value">${sampleData.patientName}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">AGE:</div>
                        <div class="info-value">${sampleData.age}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">GENDER:</div>
                        <div class="info-value">${sampleData.gender}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">REPORT ID:</div>
                        <div class="info-value">${sampleData.reportId}</div>
                    </div>
                </div>
                <div class="report-details">
                    <div class="info-row">
                        <div class="info-label">DATE:</div>
                        <div class="info-value">${sampleData.reportDate}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">REPORT ID:</div>
                        <div class="info-value">${sampleData.reportId}</div>
                    </div>
                </div>
            </div>

            <div class="specimen-info">
                <div class="info-row">
                    <div class="info-label">TEST NAME:</div>
                    <div class="info-value">${sampleData.testName || 'Not specified'}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">SPECIMEN:</div>
                    <div class="info-value">${sampleData.specimenType || 'Not specified'}</div>
                </div>
            </div>
        `;
    } else {
        // Continuation pages have a simplified header
        container.innerHTML = `
            <div class="continuation-header">
                <div class="patient-name">Patient: ${sampleData.patientName}</div>
                <div class="report-id">Report ID: ${sampleData.reportId}</div>
            </div>
        `;
    }

    // Add the test results table container
    const testResultsDiv = document.createElement('div');
    testResultsDiv.className = 'test-results';
    container.appendChild(testResultsDiv);

    // Add a page number indicator
    const pageNumberDiv = document.createElement('div');
    pageNumberDiv.className = 'page-number';
    pageNumberDiv.textContent = `Page ${pageNumber} of ${totalPages}`;
    page.appendChild(pageNumberDiv);

    // Add the footer
    const footer = document.createElement('div');
    footer.className = 'footer';
    footer.innerHTML = `
        <div class="footer-left">
              <p>dfgdfgdfg</p>
            <span class="footer-text">healthcare within reach</span>
        </div>
        <div class="footer-center">
              <p>dfgdfgdfg</p>
            <span class="footer-text">Report Preview Mode</span>
        </div>
        <div class="footer-right">
            <p>dfgdfgdfg</p>
            <span class="footer-text">Printed on: ${formatDate(new Date())}</span>
        </div>
    `;
    page.appendChild(footer);

    return { page, testResultsContainer: testResultsDiv };
}

    // Function to distribute test results across pages
    function distributeTestResults(testResults) {
        sampleData.testResults = generateSampleTestResults();
        const testResultsPerPage = isFirstPage => isFirstPage ? 26 : 35; // Fewer results on first page due to header
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
                (result.isTitle && resultsOnCurrentPage > 0 && resultsOnCurrentPage >= testResultsPerPage(isFirstPage) - 7)) {
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

            // Add technologist signature to the last page
            const techSignature = document.createElement('div');
            techSignature.className = 'technologist-signature';
            techSignature.textContent = 'Laboratory Technologist';
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
                <th>Test Parameter</th>
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
    document.querySelectorAll('.report-title, .divider').forEach(el => {
        el.classList.toggle('hidden', !showHeader);
    });

    // Update footers
    document.querySelectorAll('.footer').forEach(el => {
        el.classList.toggle('hidden', !showFooter);
    });

    // Update signatures
    document.querySelectorAll('.technologist-signature').forEach(el => {
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
}

// Modify the downloadReport function to apply toggle states before generating PDF
function downloadReport() {
    // Make sure the report reflects current toggle states
    updateReportElements();

    const reportContainer = document.getElementById('report-container');

    // Set HTML2PDF options
    const opt = {
        margin: 0,
        filename: 'Lab_Report.pdf',
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: {
            scale: 3,
            useCORS: true,
            logging: false,
            letterRendering: true
        },
        jsPDF: {
            unit: 'mm',
            format: 'a4',
            orientation: 'portrait'
        },
        pagebreak: { mode: ['avoid-all', 'css', 'legacy'] }
    };

    // Generate and download PDF
    html2pdf().from(reportContainer).set(opt).save();
}

    // Initialize the report on page load
    document.addEventListener('DOMContentLoaded', function() {
        generateMultiPageReport();
    });




</script>
</body>
</html>
