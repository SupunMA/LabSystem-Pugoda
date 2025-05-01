@extends('layouts.adminLayout')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Editing: {{ $test->name }}</h1>
            </div>
        </div>
    </div>
</div>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

                        <form id="edit-test-form" action="{{ route('admin.updateTestFull', $test->id) }}" method="POST">
                            @csrf
                            <div class="test-block">
                                <div class="row mb-3">
                                    <div class="mb-3 col-lg-8">
                                        <label class="form-label">Test Name</label>
                                        <input type="text" name="name" class="form-control test-name" value="{{ $test->name }}" required />
                                    </div>
                                    <div class="col col-lg-4">
                                        <label class="form-label">Specimen</label>
                                        <select name="specimen" class="form-select form-control">
                                            <option value="">--Select Specimen Type--</option>
                                            @php
                                                $specimens = [
                                                    'blood' => 'Blood',
                                                    'urine' => 'Urine',
                                                    'stool' => 'Stool (Feces)',
                                                    'sputum' => 'Sputum',
                                                    'saliva' => 'Saliva',
                                                    'swab' => 'Swab (e.g., throat, nasal)',
                                                    'tissue' => 'Tissue (Biopsy)',
                                                    'csf' => 'Cerebrospinal Fluid (CSF)',
                                                    'semen' => 'Semen',
                                                    'vaginal' => 'Vaginal Secretion',
                                                    'amniotic' => 'Amniotic Fluid',
                                                    'pleural' => 'Pleural Fluid',
                                                    'peritoneal' => 'Peritoneal Fluid',
                                                    'synovial' => 'Synovial Fluid',
                                                    'bone_marrow' => 'Bone Marrow',
                                                    'hair' => 'Hair',
                                                    'nail' => 'Nail'
                                                ];
                                            @endphp
                                            @foreach($specimens as $value => $label)
                                                <option value="{{ $value }}" {{ $test->specimen == $value ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col col-lg-4">
                                        <label class="form-label">Cost</label>
                                        <input type="number" name="cost" class="form-control" step="0.01" value="{{ $test->cost }}" />
                                    </div>
                                    <div class="col col-lg-4">
                                        <label class="form-label">Price</label>
                                        <input type="number" name="price" class="form-control" step="0.01" value="{{ $test->price }}" />
                                    </div>
                                </div>

                                <!-- Components Container -->
                                <div class="mt-4">
                                    <h4>Test Components</h4>
                                    <p class="text-muted">Drag and drop to reorder components (coming soon)</p>

                                    <div id="components-container" class="categories-container">
                                        @php
                                            // Combine categories and elements to sort by display order
                                            $components = collect();

                                            foreach($test->categories as $category) {
                                                $components->push([
                                                    'type' => 'category',
                                                    'display_order' => $category->display_order,
                                                    'data' => $category
                                                ]);
                                            }

                                            foreach($test->elements as $element) {
                                                $components->push([
                                                    'type' => $element->type,
                                                    'display_order' => $element->display_order,
                                                    'data' => $element
                                                ]);
                                            }

                                            $components = $components->sortBy('display_order');

                                            // Initialize index counters
                                            $categoryCounter = 0;
                                            $spaceCounter = 0;
                                            $titleCounter = 0;
                                            $paragraphCounter = 0;
                                        @endphp

                                        @foreach($components as $component)
                                            @if($component['type'] === 'category')
                                            <div class="category-block mt-4">
                                                <input type="hidden" name="categories[{{ $categoryCounter }}][id]" value="{{ $component['data']->id }}">
                                                <input type="hidden" name="order[categories][{{ $categoryCounter }}]" value="{{ $component['data']->display_order }}" class="component-order">
                                                    <div class="mb-3">
                                                        <label class="form-label">Category Name</label>
                                                        <input type="text" name="categories[{{ $categoryCounter }}][name]" class="form-control" value="{{ $component['data']->name }}" required />
                                                    </div>

                                                    <!-- Value Type section -->
                                                    <div class="mb-3">
                                                        <label class="form-label">Result Type</label>
                                                        <div>
                                                            <div class="form-check">
                                                                <label class="form-check-label">
                                                                    <input class="form-check-input" type="radio" name="categories[{{ $categoryCounter }}][value_type]" value="range" {{ $component['data']->value_type == 'range' ? 'checked' : '' }}>
                                                                    Range
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <label class="form-check-label">
                                                                    <input class="form-check-input" type="radio" name="categories[{{ $categoryCounter }}][value_type]" value="text" {{ $component['data']->value_type == 'text' ? 'checked' : '' }}>
                                                                    Text
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <label class="form-check-label">
                                                                    <input class="form-check-input" type="radio" name="categories[{{ $categoryCounter }}][value_type]" value="negpos" {{ $component['data']->value_type == 'negpos' ? 'checked' : '' }}>
                                                                    Negative / Positive
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="value-type-extra mt-3">
                                                            @if($component['data']->value_type == 'range' || $component['data']->value_type == 'text')
                                                                <div class="mb-3">
                                                                    <div class="form-check mb-2">
                                                                        <input class="form-check-input enable-unit" type="checkbox" id="unit_edit_{{ $categoryCounter }}_enabled" {{ $component['data']->unit_enabled ? 'checked' : '' }}>
                                                                        <label class="form-check-label" for="unit_edit_{{ $categoryCounter }}_enabled">Enable Unit</label>
                                                                    </div>
                                                                    <div class="unit-dropdown" style="display: {{ $component['data']->unit_enabled ? 'block' : 'none' }};">
                                                                        <label class="form-label">Unit</label>
                                                                        <select name="categories[{{ $categoryCounter }}][unit]" class="form-select form-control">
                                                                            <option value="">--Select Unit--</option>
                                                                            @php
                                                                                $units = ['mg/dL', 'mmol/L', 'g/L', 'IU/L', 'ng/mL', 'µg/mL', 'mmHg', 'mEq/L', '%'];
                                                                            @endphp
                                                                            @foreach($units as $unit)
                                                                                <option value="{{ $unit }}" {{ $component['data']->unit == $unit ? 'selected' : '' }}>{{ $unit }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <!-- Reference Range section -->
                                                    <div class="mb-3">
                                                        <label class="form-label">Reference Range</label>
                                                        <div>
                                                            <div class="form-check">
                                                                <label class="form-check-label">
                                                                    <input class="form-check-input" type="radio" name="categories[{{ $categoryCounter }}][reference_type]" value="none" {{ $component['data']->reference_type == 'none' ? 'checked' : '' }}>
                                                                    None
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <label class="form-check-label">
                                                                    <input class="form-check-input" type="radio" name="categories[{{ $categoryCounter }}][reference_type]" value="minmax" {{ $component['data']->reference_type == 'minmax' ? 'checked' : '' }}>
                                                                    Min - Max
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <label class="form-check-label">
                                                                    <input class="form-check-input" type="radio" name="categories[{{ $categoryCounter }}][reference_type]" value="table" {{ $component['data']->reference_type == 'table' ? 'checked' : '' }}>
                                                                    Ranges Table
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="reference-extra mt-3">
                                                            @if($component['data']->reference_type == 'minmax')
                                                                <div class="mb-3">
                                                                    <label class="form-label">Min Value</label>
                                                                    <input type="text" name="categories[{{ $categoryCounter }}][min_value]" class="form-control" value="{{ $component['data']->min_value }}" />
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label">Max Value</label>
                                                                    <input type="text" name="categories[{{ $categoryCounter }}][max_value]" class="form-control" value="{{ $component['data']->max_value }}" />
                                                                </div>
                                                            @elseif($component['data']->reference_type == 'table')
                                                                <div class="row g-2 align-items-end">
                                                                    <div class="col-auto">
                                                                        <label class="form-label">Rows</label>
                                                                        <input type="number" class="form-control table-rows" value="2" min="1" />
                                                                    </div>
                                                                    <div class="col-auto">
                                                                        <label class="form-label">Columns</label>
                                                                        <input type="number" class="form-control table-cols" value="2" min="1" />
                                                                    </div>
                                                                    <div class="col-auto">
                                                                        <button type="button" class="btn btn-outline-secondary generate-table">Generate Table</button>
                                                                    </div>
                                                                </div>
                                                                <div class="table-area mt-3">
                                                                    @if($component['data']->referenceRangeTable->count() > 0)
                                                                        @php
                                                                            $tableData = $component['data']->referenceRangeTable;
                                                                            $rows = $tableData->max('row') + 1;
                                                                            $columns = $tableData->max('column') + 1;
                                                                            $tableValues = [];

                                                                            foreach ($tableData as $cell) {
                                                                                $tableValues[$cell->row][$cell->column] = $cell->value;
                                                                            }
                                                                        @endphp

                                                                        <table class="table table-bordered">
                                                                            @for ($r = 0; $r < $rows; $r++)
                                                                                <tr>
                                                                                    @for ($c = 0; $c < $columns; $c++)
                                                                                        <td>
                                                                                            <input type="text" name="categories[{{ $categoryCounter }}][table][{{ $r }}][{{ $c }}]" class="form-control" value="{{ $tableValues[$r][$c] ?? '' }}" />
                                                                                        </td>
                                                                                    @endfor
                                                                                </tr>
                                                                            @endfor
                                                                        </table>
                                                                    @endif
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <button type="button" class="btn btn-danger remove-category" data-id="{{ $component['data']->id }}">Remove Category</button>
                                                </div>
                                                @php $categoryCounter++; @endphp
                                            @elseif($component['type'] === 'space')
                                            <div class="space-block my-4">
                                                <input type="hidden" name="elements[space][{{ $spaceCounter }}][id]" value="{{ $component['data']->id }}">
                                                <input type="hidden" name="order[spaces][{{ $spaceCounter }}]" value="{{ $component['data']->display_order }}" class="component-order">
                                                    <hr />
                                                    <button type="button" class="btn btn-sm btn-danger mt-1 remove-element" data-id="{{ $component['data']->id }}">Remove Space</button>
                                                </div>
                                                @php $spaceCounter++; @endphp
                                            @elseif($component['type'] === 'title')
                                            <div class="title-block mb-3">
                                                <input type="hidden" name="elements[title][{{ $titleCounter }}][id]" value="{{ $component['data']->id }}">
                                                <input type="hidden" name="order[titles][{{ $titleCounter }}]" value="{{ $component['data']->display_order }}" class="component-order">
                                                    <label class="form-label">Custom Title</label>
                                                    <input type="text" name="elements[title][{{ $titleCounter }}][content]" class="form-control" value="{{ $component['data']->content }}" />
                                                    <button type="button" class="btn btn-sm btn-danger mt-1 remove-element" data-id="{{ $component['data']->id }}">Remove Title</button>
                                                </div>
                                                @php $titleCounter++; @endphp
                                            @elseif($component['type'] === 'paragraph')
                                            <div class="paragraph-block mb-3">
                                                <input type="hidden" name="elements[paragraph][{{ $paragraphCounter }}][id]" value="{{ $component['data']->id }}">
                                                <input type="hidden" name="order[paragraphs][{{ $paragraphCounter }}]" value="{{ $component['data']->display_order }}" class="component-order">
                                                    <label class="form-label">Custom Paragraph</label>
                                                    <textarea name="elements[paragraph][{{ $paragraphCounter }}][content]" class="form-control" rows="3">{{ $component['data']->content }}</textarea>
                                                    <button type="button" class="btn btn-sm btn-danger mt-1 remove-element" data-id="{{ $component['data']->id }}">Remove Paragraph</button>
                                                </div>
                                                @php $paragraphCounter++; @endphp
                                            @endif
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Buttons for Adding Components -->
                                <div class="button-group mt-4">
                                    <button type="button" class="btn btn-primary add-category mb-1 me-1">
                                        <i class="fas fa-folder-plus me-1"></i> Add Category
                                    </button>
                                    <button type="button" class="btn btn-secondary add-space mb-1 me-1">
                                        <i class="fas fa-arrows-alt-v me-1"></i> Add Space
                                    </button>
                                    <button type="button" class="btn btn-secondary add-title mb-1 me-1">
                                        <i class="fas fa-heading me-1"></i> Add Title
                                    </button>
                                    <button type="button" class="btn btn-secondary add-paragraph mb-1">
                                        <i class="fas fa-align-left me-1"></i> Add Paragraph
                                    </button>
                                </div>
                            </div>

                            <!-- Submit and Back Buttons -->
                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('admin.allAvailableTest') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-1"></i> Back to Test Templates
                                </a>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save me-1"></i> Save Changes
                                </button>
                            </div>
                        </form>

            </div>
        </div>
    </div>
</section>
@endsection

@push('specificCSS')
<style>
    .test-block, .category-block {
        border: 2px solid #dee2e6;
        padding: 20px;
        margin-bottom: 20px;
        border-radius: 10px;
    }
    .category-block {
        background-color: #f8f9fa;
    }
    table input {
        width: 100%;
    }
    .unit-dropdown, .reference-extra {
        transition: all 0.3s ease;
    }
</style>
@endpush

@push('specificJs')
<script>
// Initialize counters based on existing elements
let elementOrderCounter = {{ max($catIndex, $spaceIndex, $titleIndex, $paragraphIndex) }};
let nextCategoryIndex = {{ $catIndex }};
let nextSpaceIndex = {{ $spaceIndex }};
let nextTitleIndex = {{ $titleIndex }};
let nextParagraphIndex = {{ $paragraphIndex }};

//element display order count
function getNextOrderValue() {
    let maxOrder = 0;
    document.querySelectorAll('.component-order').forEach(function(input) {
        const val = parseInt(input.value, 10);
        if (!isNaN(val) && val > maxOrder) maxOrder = val;
    });
    return maxOrder + 1;
}
// Event handler for clicks
document.addEventListener('click', function (e) {
    const componentsContainer = document.getElementById('components-container');

    // Add category
    if (e.target.classList.contains('add-category')) {
        const newOrder = getNextOrderValue();

        componentsContainer.insertAdjacentHTML('beforeend', `
        <div class="category-block mt-4">
            <input type="hidden" name="categories[${nextCategoryIndex}][id]" value="new">
            <input type="hidden" name="order[categories][${nextCategoryIndex}]" value="${elementOrderCounter}" class="component-order">
            <div class="mb-3">
                <label class="form-label">Category Name</label>
                <input type="text" name="categories[${nextCategoryIndex}][name]" class="form-control" required />
            </div>

            <!-- Value Type section -->
            <div class="mb-3">
                <label class="form-label">Result Type</label>
                <div>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="categories[${nextCategoryIndex}][value_type]" value="range" checked>
                            Range
                        </label>
                    </div>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="categories[${nextCategoryIndex}][value_type]" value="text">
                            Text
                        </label>
                    </div>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="categories[${nextCategoryIndex}][value_type]" value="negpos">
                            Negative / Positive
                        </label>
                    </div>
                </div>
                <div class="value-type-extra mt-3">
                    <div class="mb-3">
                        <div class="form-check mb-2">
                            <input class="form-check-input enable-unit" type="checkbox" id="unit_edit_${nextCategoryIndex}_enabled">
                            <label class="form-check-label" for="unit_edit_${nextCategoryIndex}_enabled">Enable Unit</label>
                        </div>
                        <div class="unit-dropdown" style="display: none;">
                            <label class="form-label">Unit</label>
                            <select name="categories[${nextCategoryIndex}][unit]" class="form-select form-control">
                                <option value="">--Select Unit--</option>
                                <option value="mg/dL">mg/dL</option>
                                <option value="mmol/L">mmol/L</option>
                                <option value="g/L">g/L</option>
                                <option value="IU/L">IU/L</option>
                                <option value="ng/mL">ng/mL</option>
                                <option value="µg/mL">µg/mL</option>
                                <option value="mmHg">mmHg</option>
                                <option value="mEq/L">mEq/L</option>
                                <option value="%">%</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reference Range section -->
            <div class="mb-3">
                <label class="form-label">Reference Range</label>
                <div>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="categories[${nextCategoryIndex}][reference_type]" value="none" checked>
                            None
                        </label>
                    </div>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="categories[${nextCategoryIndex}][reference_type]" value="minmax">
                            Min - Max
                        </label>
                    </div>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="categories[${nextCategoryIndex}][reference_type]" value="table">
                            Ranges Table
                        </label>
                    </div>
                </div>
                <div class="reference-extra mt-3"></div>
            </div>

            <button type="button" class="btn btn-danger remove-category">Remove Category</button>
        </div>`);

        nextCategoryIndex++;
    }

    // Add space
    if (e.target.classList.contains('add-space')) {
        const newOrder = getNextOrderValue();
        componentsContainer.insertAdjacentHTML('beforeend', `
        <div class="space-block my-4">
            <input type="hidden" name="elements[space][${nextSpaceIndex}][id]" value="new">
            <input type="hidden" name="order[spaces][${nextSpaceIndex}]" value="${elementOrderCounter}" class="component-order">
            <hr />
            <button type="button" class="btn btn-sm btn-danger mt-1 remove-element">Remove Space</button>
        </div>
        `);
        nextSpaceIndex++;
    }

    // Add title
    if (e.target.classList.contains('add-title')) {
        const newOrder = getNextOrderValue();
        componentsContainer.insertAdjacentHTML('beforeend', `
        <div class="title-block mb-3">
            <input type="hidden" name="elements[title][${nextTitleIndex}][id]" value="new">
            <input type="hidden" name="order[titles][${nextTitleIndex}]" value="${elementOrderCounter}" class="component-order">
            <label class="form-label">Custom Title</label>
            <input type="text" name="elements[title][${nextTitleIndex}][content]" class="form-control" />
            <button type="button" class="btn btn-sm btn-danger mt-1 remove-element">Remove Title</button>
        </div>
        `);
        nextTitleIndex++;
    }

    // Add paragraph
    if (e.target.classList.contains('add-paragraph')) {
        const newOrder = getNextOrderValue();
        componentsContainer.insertAdjacentHTML('beforeend', `
        <div class="paragraph-block mb-3">
            <input type="hidden" name="elements[paragraph][${nextParagraphIndex}][id]" value="new">
            <input type="hidden" name="order[paragraphs][${nextParagraphIndex}]" value="${elementOrderCounter}" class="component-order">
            <label class="form-label">Custom Paragraph</label>
            <textarea name="elements[paragraph][${nextParagraphIndex}][content]" class="form-control" rows="3"></textarea>
            <button type="button" class="btn btn-sm btn-danger mt-1 remove-element">Remove Paragraph</button>
        </div>
        `);
        nextParagraphIndex++;
    }

    // Remove category
    if (e.target.classList.contains('remove-category')) {
        const button = e.target;
        const id = button.dataset.id;

        if (id && id !== 'new') {
            componentsContainer.insertAdjacentHTML('beforeend', `
                <input type="hidden" name="deleted_categories[]" value="${id}">
            `);
        }

        button.closest('.category-block').remove();
    }

    // Remove element
    if (e.target.classList.contains('remove-element')) {
        const button = e.target;
        const id = button.dataset.id;

        if (id && id !== 'new') {
            componentsContainer.insertAdjacentHTML('beforeend', `
                <input type="hidden" name="deleted_elements[]" value="${id}">
            `);
        }

        button.closest('.space-block, .title-block, .paragraph-block').remove();
    }

    // Unit toggle
    if (e.target.classList.contains('enable-unit')) {
        const unitDropdown = e.target.closest('.mb-3').querySelector('.unit-dropdown');
        unitDropdown.style.display = e.target.checked ? 'block' : 'none';
    }

    // Generate table
    if (e.target.classList.contains('generate-table')) {
        const block = e.target.closest('.category-block');
        const rows = parseInt(block.querySelector('.table-rows').value);
        const cols = parseInt(block.querySelector('.table-cols').value);
        const tableArea = block.querySelector('.table-area');

        // Get category index
        let categoryIndex;
        const nameInput = block.querySelector('input[name^="categories["][name$="][name]"]');
        if (nameInput) {
            const match = nameInput.name.match(/categories\[(\d+)\]/);
            if (match) {
                categoryIndex = match[1];
            }
        }

        if (!categoryIndex) return;

        // Save existing values
        const oldInputs = tableArea.querySelectorAll('input');
        const existingValues = {};
        oldInputs.forEach(input => {
            const match = input.name.match(/categories\[\d+\]\[table\]\[(\d+)\]\[(\d+)\]/);
            if (match) {
                const row = parseInt(match[1]);
                const col = parseInt(match[2]);
                if (!existingValues[row]) existingValues[row] = {};
                existingValues[row][col] = input.value;
            }
        });

        // Generate table HTML
        let tableHTML = '<table class="table table-bordered">';
        for (let r = 0; r < rows; r++) {
            tableHTML += '<tr>';
            for (let c = 0; c < cols; c++) {
                const val = (existingValues[r] && existingValues[r][c]) ? existingValues[r][c] : '';
                tableHTML += `<td><input type="text" name="categories[${categoryIndex}][table][${r}][${c}]" class="form-control" value="${val}" /></td>`;
            }
            tableHTML += '</tr>';
        }
        tableHTML += '</table>';
        tableArea.innerHTML = tableHTML;
    }
});

// Event handler for changes
document.addEventListener('change', function(e) {
    // Value type changes
    if (e.target.name.includes('[value_type]')) {
        const block = e.target.closest('.category-block');
        const extraDiv = block.querySelector('.value-type-extra');

        // Get category index
        let categoryIndex;
        const match = e.target.name.match(/categories\[(\d+)\]/);
        if (match) {
            categoryIndex = match[1];
        } else {
            return;
        }

        if (e.target.value === 'range' || e.target.value === 'text') {
            extraDiv.innerHTML = `
                <div class="mb-3">
                    <div class="form-check mb-2">
                        <input class="form-check-input enable-unit" type="checkbox" id="unit_edit_${categoryIndex}_enabled">
                        <label class="form-check-label" for="unit_edit_${categoryIndex}_enabled">Enable Unit</label>
                    </div>
                    <div class="unit-dropdown" style="display: none;">
                        <label class="form-label">Unit</label>
                        <select name="categories[${categoryIndex}][unit]" class="form-select form-control">
                            <option value="">--Select Unit--</option>
                            <option value="mg/dL">mg/dL</option>
                            <option value="mmol/L">mmol/L</option>
                            <option value="g/L">g/L</option>
                            <option value="IU/L">IU/L</option>
                            <option value="ng/mL">ng/mL</option>
                            <option value="µg/mL">µg/mL</option>
                            <option value="mmHg">mmHg</option>
                            <option value="mEq/L">mEq/L</option>
                            <option value="%">%</option>
                        </select>
                    </div>
                </div>`;
        } else {
            extraDiv.innerHTML = '';
        }
    }

    // Reference type changes
    if (e.target.name.includes('[reference_type]')) {
        const block = e.target.closest('.category-block');
        const extraDiv = block.querySelector('.reference-extra');

        // Get category index
        let categoryIndex;
        const match = e.target.name.match(/categories\[(\d+)\]/);
        if (match) {
            categoryIndex = match[1];
        } else {
            return;
        }

        if (e.target.value === 'minmax') {
            extraDiv.innerHTML = `
                <div class="mb-3">
                    <label class="form-label">Min Value</label>
                    <input type="text" name="categories[${categoryIndex}][min_value]" class="form-control" />
                </div>
                <div class="mb-3">
                    <label class="form-label">Max Value</label>
                    <input type="text" name="categories[${categoryIndex}][max_value]" class="form-control" />
                </div>`;
        } else if (e.target.value === 'table') {
            extraDiv.innerHTML = `
                <div class="row g-2 align-items-end">
                    <div class="col-auto">
                        <label class="form-label">Rows</label>
                        <input type="number" class="form-control table-rows" value="2" min="1" />
                    </div>
                    <div class="col-auto">
                        <label class="form-label">Columns</label>
                        <input type="number" class="form-control table-cols" value="2" min="1" />
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn btn-outline-secondary generate-table">Generate Table</button>
                    </div>
                </div>
                <div class="table-area mt-3"></div>`;
        } else {
            extraDiv.innerHTML = '';
        }
    }
});

// Add AJAX form submission
$('#edit-test-form').submit(function(e) {
    e.preventDefault();

    // Show loading indicator
    const saveButton = $('#edit-test-form button[type="submit"]');
    const originalButtonText = saveButton.html();
    saveButton.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> Saving...');

    // Clear any previous error highlights
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').remove();

    $.ajax({
        url: $(this).attr('action'),
        method: 'POST',
        data: $(this).serialize(),
        success: function(response) {
            toastr.success(response.message || 'Test updated successfully!');

            // Redirect after a short delay
            setTimeout(function() {
                window.location.href = "{{ route('admin.allAvailableTest') }}";
            }, 1500);
        },
        error: function(xhr) {
            saveButton.prop('disabled', false).html(originalButtonText);

            if (xhr.status === 422) {
                // Validation errors
                const errors = xhr.responseJSON.errors;

                $.each(errors, function(key, message) {
                    // Convert dot notation to form field names
                    let fieldName = key;

                    // Try to find the corresponding input field
                    let field = $('[name="' + fieldName + '"]');
                    if (field.length === 0) {
                        // Try bracket notation for arrays
                        fieldName = key.replace(/\./g, '[').replace(/$/g, ']');
                        field = $('[name="' + fieldName + '"]');
                    }

                    if (field.length) {
                        field.addClass('is-invalid');
                        field.after('<div class="invalid-feedback">' + message[0] + '</div>');
                    }

                    // Show error in toast
                    toastr.error(message[0]);
                });
            } else {
                // General error
                toastr.error(xhr.responseJSON?.message || 'An error occurred. Please try again.');
            }
        }
    });
});

// Initialize toastr options
toastr.options = {
    "closeButton": true,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "timeOut": "8000"
};
</script>
@endpush
