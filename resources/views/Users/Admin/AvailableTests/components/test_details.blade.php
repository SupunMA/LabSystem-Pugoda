<div class="container-fluid p-0">
    <div class="row">
        <div class="col-md-6">
            <table class="table table-bordered">
                <tr>
                    <th style="width: 160px" class="bg-light">Test Name</th>
                    <td>{{ $test->name }}</td>
                </tr>
                <tr>
                    <th class="bg-light">Specimen</th>
                    <td>{{ ucfirst($test->specimen ?? 'Not specified') }}</td>
                </tr>
                <tr>
                    <th class="bg-light">Price</th>
                    <td>{{ $test->price ? number_format($test->price, 2) : 'Not specified' }}</td>
                </tr>
                <tr>
                    <th class="bg-light">Created</th>
                    <td>{{ $test->created_at->format('M d, Y h:i A') }}</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-12">
            <h5 class="mb-3">Test Components</h5>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="thead-light">
                        <tr>
                            <th style="width: 15%">Component Type</th>
                            <th style="width: 25%">Name/Content</th>
                            <th style="width: 60%">Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            // Combine categories and elements to sort by display order
                            $components = collect();

                            if($test->categories) {
                                foreach($test->categories as $category) {
                                    $components->push([
                                        'type' => 'category',
                                        'display_order' => $category->display_order,
                                        'data' => $category
                                    ]);
                                }
                            }

                            if($test->elements) {
                                foreach($test->elements as $element) {
                                    $components->push([
                                        'type' => $element->type,
                                        'display_order' => $element->display_order,
                                        'data' => $element
                                    ]);
                                }
                            }

                            $components = $components->sortBy('display_order');
                        @endphp

                        @forelse($components as $component)
                            <tr>
                                @if($component['type'] === 'category')
                                    <td>
                                        <span class="badge badge-primary">Category</span>
                                    </td>
                                    <td>{{ $component['data']->name }}</td>
                                    <td>
                                        <ul class="list-unstyled">
                                            <li><strong>Value Type:</strong> {{ ucfirst($component['data']->value_type) }}</li>

                                            @if($component['data']->unit_enabled)
                                                <li><strong>Unit:</strong> {{ $component['data']->unit }}</li>
                                            @endif

                                            <li>
                                                <strong>Reference:</strong>
                                                @if($component['data']->reference_type === 'minmax')
                                                    {{ $component['data']->min_value }} - {{ $component['data']->max_value }}
                                                    @if($component['data']->unit_enabled)
                                                        {{ $component['data']->unit }}
                                                    @endif
                                                @elseif($component['data']->reference_type === 'table')
                                                    <button type="button" class="btn btn-xs btn-info view-reference-table"
                                                            data-toggle="collapse"
                                                            data-target="#reference-table-{{ $component['data']->id }}">
                                                        Show Reference Table
                                                    </button>

                                                    <div class="collapse mt-2" id="reference-table-{{ $component['data']->id }}">
                                                        @php
                                                            $tableData = $component['data']->referenceRangeTable;
                                                            if($tableData && $tableData->count() > 0) {
                                                                $rows = $tableData->max('row') + 1;
                                                                $columns = $tableData->max('column') + 1;
                                                                $tableValues = [];

                                                                foreach ($tableData as $cell) {
                                                                    $tableValues[$cell->row][$cell->column] = $cell->value;
                                                                }
                                                        @endphp

                                                        <table class="table table-sm table-bordered">
                                                            @for ($r = 0; $r < $rows; $r++)
                                                                <tr>
                                                                    @for ($c = 0; $c < $columns; $c++)
                                                                        <td>{{ $tableValues[$r][$c] ?? '' }}</td>
                                                                    @endfor
                                                                </tr>
                                                            @endfor
                                                        </table>

                                                        @php
                                                            } else {
                                                        @endphp
                                                        <div class="text-muted">No table data available</div>
                                                        @php
                                                            }
                                                        @endphp
                                                    </div>
                                                @else
                                                    <span class="text-muted">Not specified</span>
                                                @endif
                                            </li>
                                        </ul>
                                    </td>
                                @elseif($component['type'] === 'space')
                                    <td><span class="badge badge-secondary">Space</span></td>
                                    <td><em class="text-muted">Visual separator</em></td>
                                    <td><hr class="my-1"></td>
                                @elseif($component['type'] === 'title')
                                    <td><span class="badge badge-info">Title</span></td>
                                    <td colspan="2">
                                        <h5>{{ $component['data']->content }}</h5>
                                    </td>
                                @elseif($component['type'] === 'paragraph')
                                    <td><span class="badge badge-success">Paragraph</span></td>
                                    <td colspan="2">
                                        <p class="mb-0">{{ $component['data']->content }}</p>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">No components found for this test</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
