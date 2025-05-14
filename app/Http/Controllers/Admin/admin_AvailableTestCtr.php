<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\AvailableTest;
use App\Models\subcategory;

use App\Models\AvailableTest_New;
use App\Models\TestCategory_New;
use App\Models\ReferenceRangeTable;
use App\Models\TestElement_New;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;
use DB;


class admin_AvailableTestCtr extends Controller
{


 //Authenticate all Admin routes
    public function __construct()
    {
        $this->middleware('checkAdmin');
       // $this->task = new branches;
    }


    //Client

    public function addAvailableTest()
    {
        return view('Users.Admin.AvailableTests.AddNewTest');
    }

    public function addingAvailableTest(Request $request)
    {
         $request->validate([
            'AvailableTestName' =>['required','string'],
            'resultDays' =>['required','integer'],
            'AvailableTestCost' =>['required','integer'],
            'SubCategoryName.*' => ['required', 'string'],
            'SubCategoryRangeMin.*' => ['required', 'numeric'],
            'SubCategoryRangeMax.*' => ['required', 'numeric'],
            'Units.*' => ['required', 'string']

         ]);


         $AvailableTest = new AvailableTest();

         $AvailableTest->AvailableTestName = $request->AvailableTestName;
         $AvailableTest->resultDays = $request->resultDays;
         $AvailableTest->AvailableTestCost = $request->AvailableTestCost;


        //Getting next available test ID
        $tableName = 'available_tests';
        $nextId = DB::select("SHOW TABLE STATUS LIKE '$tableName'")[0]->Auto_increment;

        $dataInputsName = $request->input('SubCategoryName');
        $dataInputsRangeMin = $request->input('SubCategoryRangeMin');
        $dataInputsRangeMax = $request->input('SubCategoryRangeMax');
        $dataInputsUnits = $request->input('Units');


        if($dataInputsName!=null){
            $AvailableTest->save();
            $count = count($dataInputsName);

            if ($nextId) {

                for ($i = 0; $i < $count; $i++) {
                    $subcategory = new subcategory();
                    $subcategory->SubCategoryName=$dataInputsName[$i];
                    $subcategory->SubCategoryRangeMin=$dataInputsRangeMin[$i];
                    $subcategory->SubCategoryRangeMax=$dataInputsRangeMax[$i];
                    $subcategory->Units=$dataInputsUnits[$i];
                    $subcategory->AvailableTestID=$nextId;

                    $subcategory->save();
                }


            } else {
                return "No users found.";
            }
        return redirect()->back()->with('message','Added Available Test Successfully');

        }



        return redirect()->back()->with('message','Error! Could not save the data! Please Add Sub Category');
        //->route('your_url_where_you_want_to_redirect');
    }


    public function allAvailableTest()
    {
        // $AvailableTestsSubcategory = subcategory::with('availableTests')->get();
        // $AvailableTests=AvailableTest::all();
// dd($AvailableTests,$AvailableTestsSubcategory);
        // return view('Users.Admin.AvailableTests.AllTests',compact('AvailableTests','AvailableTestsSubcategory'));
        return view('Users.Admin.AvailableTests.AllTests');
    }

    public function deleteAvailableTest($ID)
    {
        //dd($branchID);
        $delete = AvailableTest::find($ID);
        $delete->delete();
        return redirect()->back()->with('message','Deleted Successful');
    }

    public function updateAvailableTest(Request $request)
    {

        $request->validate([
            'AvailableTestName' =>['required','string'],
            'resultDays' =>['required','integer'],
            'AvailableTestCost' =>['required','integer']
        ]);

        AvailableTest::where('tlid', $request->id)
        ->update([
                    'AvailableTestName' => $request->AvailableTestName,
                    'resultDays'=> $request->resultDays,
                    'AvailableTestCost'=> $request->AvailableTestCost

                ]);

        return redirect()->back()->with('message','Updated Successfully');

    }

    /**
     * Store a newly created test in storage.
     */
    public function store(Request $request)
    {
        try {
            // Prepare validation rules for each test
            $testsData = $request->input('tests', []);
            $rules = [];
            $messages = [];

            foreach ($testsData as $key => $test) {
                $rules["tests.{$key}.name"] = [
                    'required',
                    Rule::unique('availabletests', 'name')
                ];
                $messages["tests.{$key}.name.unique"] = "The test name '{$test['name']}' already exists.";
            }

            // Validate the request
            $validator = Validator::make($request->all(), $rules, $messages);

            // If validation fails, return the errors via AJAX
            if ($validator->fails()) {
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'errors' => $validator->errors(),
                        'message' => 'Validation failed. Please check the form.'
                    ], 422);
                }

                return redirect()->back()->withErrors($validator)->withInput();
            }


            DB::beginTransaction();

        foreach ($testsData as $testData) {
            // Create the test
            $test = AvailableTest_New::create([
                'name' => $testData['name'] ?? '',
                'specimen' => $testData['specimen'] ?? null,
                'price' => $testData['price'] ?? null,
            ]);

            // Get element order if available
            $elementOrder = isset($testData['element_order']) ? $testData['element_order'] : [];

            // Create a list of all elements with their types and data
            $allElements = [];

            // Add categories to elements list
            if (isset($testData['categories'])) {
                foreach ($testData['categories'] as $index => $categoryData) {
                    $orderKey = "category_{$index}";
                    $order = isset($elementOrder[$orderKey]) ? (int)$elementOrder[$orderKey] : 999999;
                    $allElements[] = [
                        'type' => 'category',
                        'data' => $categoryData,
                        'order' => $order,
                        'index' => $index
                    ];
                }
            }

            // Add spaces to elements list
            if (isset($testData['custom_space'])) {
                foreach ($testData['custom_space'] as $index => $space) {
                    $orderKey = "space_{$index}";
                    $order = isset($elementOrder[$orderKey]) ? (int)$elementOrder[$orderKey] : 999999;
                    $allElements[] = [
                        'type' => 'space',
                        'data' => null,
                        'order' => $order,
                        'index' => $index
                    ];
                }
            }

            // Add titles to elements list
            if (isset($testData['custom_title'])) {
                foreach ($testData['custom_title'] as $index => $title) {
                    if (!empty($title)) {
                        $orderKey = "title_{$index}";
                        $order = isset($elementOrder[$orderKey]) ? (int)$elementOrder[$orderKey] : 999999;
                        $allElements[] = [
                            'type' => 'title',
                            'data' => $title,
                            'order' => $order,
                            'index' => $index
                        ];
                    }
                }
            }

            // Add paragraphs to elements list
            if (isset($testData['custom_paragraph'])) {
                foreach ($testData['custom_paragraph'] as $index => $paragraph) {
                    if (!empty($paragraph)) {
                        $orderKey = "paragraph_{$index}";
                        $order = isset($elementOrder[$orderKey]) ? (int)$elementOrder[$orderKey] : 999999;
                        $allElements[] = [
                            'type' => 'paragraph',
                            'data' => $paragraph,
                            'order' => $order,
                            'index' => $index
                        ];
                    }
                }
            }

            // Sort all elements by their order
            usort($allElements, function($a, $b) {
                return $a['order'] - $b['order'];
            });

            // Now create all elements in the correct order
            $displayOrder = 1;

            foreach ($allElements as $element) {
                switch ($element['type']) {
                    case 'category':
                        $categoryData = $element['data'];
                        $unitEnabled = isset($categoryData['unit']) && !empty($categoryData['unit']);

                        $category = TestCategory_New::create([
                            'availableTests_id' => $test->id,
                            'name' => $categoryData['name'] ?? '',
                            'value_type' => $categoryData['value_type'] ?? 'range',
                            'unit_enabled' => $unitEnabled,
                            'unit' => $unitEnabled ? $categoryData['unit'] : null,
                            'reference_type' => $categoryData['reference_type'] ?? 'none',
                            'min_value' => isset($categoryData['min_value']) ? $categoryData['min_value'] : null,
                            'max_value' => isset($categoryData['max_value']) ? $categoryData['max_value'] : null,
                            'display_order' => $displayOrder++,
                        ]);

                        // Process reference range table if applicable
                        if (isset($categoryData['table'])) {
                            foreach ($categoryData['table'] as $rowIndex => $rowData) {
                                foreach ($rowData as $colIndex => $cellValue) {
                                    ReferenceRangeTable::create([
                                        'test_categories_id' => $category->id,
                                        'row' => $rowIndex,
                                        'column' => $colIndex,
                                        'value' => $cellValue ?? '',
                                    ]);
                                }
                            }
                        }
                        break;

                    case 'space':
                        TestElement_New::create([
                            'availableTests_id' => $test->id,
                            'type' => 'space',
                            'content' => null,
                            'display_order' => $displayOrder++,
                        ]);
                        break;

                    case 'title':
                        TestElement_New::create([
                            'availableTests_id' => $test->id,
                            'type' => 'title',
                            'content' => $element['data'],
                            'display_order' => $displayOrder++,
                        ]);
                        break;

                    case 'paragraph':
                        TestElement_New::create([
                            'availableTests_id' => $test->id,
                            'type' => 'paragraph',
                            'content' => $element['data'],
                            'display_order' => $displayOrder++,
                        ]);
                        break;
                }
            }
        }

        DB::commit();

            // Return success response
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Test template created successfully!'
                ]);
            }

            return redirect()->back()->with('success', 'Test template created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error creating test template: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'Error creating test template: ' . $e->getMessage())->withInput();
        }
    }

    public function allTests()
{
    try {
        $tests = AvailableTest_New::select([
            'id',
            'name',
            'specimen',
            'price',
            'created_at'
        ])
        ->where('is_internal', true) // Fetch rows where is_internal is false
        ->get();

        return DataTables::of($tests)
            ->addColumn('actions', function ($test) {
                $actions = '<div class="btn-group">';
                $actions .= '<button type="button" class="btn btn-info btn-sm viewBtn" data-id="'.$test->id.'" data-name="'.$test->name.'"><i class="fas fa-eye"></i></button>';
                $actions .= '<button type="button" class="btn btn-primary btn-sm editBtn"
                                data-id="'.$test->id.'"
                                data-name="'.htmlspecialchars($test->name, ENT_QUOTES).'"
                                data-specimen="'.$test->specimen.'"
                                data-price="'.$test->price.'">
                                <i class="fas fa-edit"></i>
                            </button>';

// Add View Template button
$actions .= '<a href="'.route('admin.viewTestReport', ['id' => $test->id]).'" class="btn btn-secondary btn-sm" target="_blank">
                <i class="fas fa-file-alt"></i>
            </a>';


                $actions .= '<button type="button" class="btn btn-danger btn-sm deleteBtn" data-id="'.$test->id.'" data-name="'.htmlspecialchars($test->name, ENT_QUOTES).'"><i class="fas fa-trash"></i></button>';
                $actions .= '</div>';
                return $actions;
            })
            ->addColumn('specimen', function ($test) {
                if (empty($test->specimen)) return '<span class="text-muted">Not specified</span>';
                return ucfirst($test->specimen);
            })
            ->addColumn('categories_count', function ($test) {
                return '<div class="rounded-circle bg-success text-white d-inline-flex justify-content-center align-items-center" style="width: 25px; height: 25px;">' . $test->categories()->count() . '</div>';

            })
            ->addColumn('price', function ($test) {
                if (empty($test->price)) return '<span class="text-muted">-</span>';
                return number_format($test->price, 2);
            })
            ->editColumn('created_at', function ($test) {
                return $test->created_at ? $test->created_at->format('M d, Y') : '';
            })
            ->rawColumns(['actions', 'specimen', 'categories_count', 'price'])
            ->make(true);
    } catch (\Exception $e) {
        \Log::error('DataTables error: ' . $e->getMessage());
        return response()->json(['error' => 'An error occurred while fetching data'], 500);
    }
}
    /**
     * Show test details (for modal view)
     */
    public function getTestDetails($id)
    {
        try {
            // Add debugging to trace the issue
            \Log::info("Loading test details for ID: {$id}");

            $test = AvailableTest_New::with(['categories.referenceRangeTable', 'elements'])
                ->findOrFail($id);

            \Log::info("Test loaded: " . $test->name);
            \Log::info("Categories count: " . $test->categories->count());

            return view('Users.Admin.AvailableTests.components.test_details', compact('test'))->render();
        } catch (\Exception $e) {
            \Log::error("Error in getTestDetails: " . $e->getMessage());
            \Log::error($e->getTraceAsString());

            return '<div class="alert alert-danger">
                    <p><i class="fas fa-exclamation-triangle mr-2"></i> Error loading test details:</p>
                    <p>'.$e->getMessage().'</p>
                  </div>';
        }
    }

    /**
     * Update test basic information
     */
    public function updateTest(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'test_id' => 'required|exists:availableTests,id',
                'name' => [
                    'required',
                    Rule::unique('availableTests', 'name')->ignore($request->test_id)
                ],
                'specimen' => 'nullable|string',
                'price' => 'nullable|numeric|min:0',
            ], [
                'name.required' => 'Test name is required.',
                'name.unique' => 'This test name already exists.',
                'price.numeric' => 'Price must be a valid number.'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            $test = AvailableTest_New::findOrFail($request->test_id);

            $test->update([
                'name' => $request->name,
                'specimen' => $request->specimen,
                'price' => $request->price
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Test updated successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating test: ' . $e->getMessage()
            ], 500);
        }
    }


        /**
     * Show the test edit form
     */
/**
 * Show the form for editing the specified test.
 */
public function editTest($id)
{
    try {
        $test = AvailableTest_New::with(['categories.referenceRangeTable', 'elements'])
                    ->findOrFail($id);

        // Calculate max indices for JavaScript
        $catIndex = $test->categories->count();
        $spaceIndex = $test->elements->where('type', 'space')->count();
        $titleIndex = $test->elements->where('type', 'title')->count();
        $paragraphIndex = $test->elements->where('type', 'paragraph')->count();

        return view('Users.Admin.AvailableTests.components.test_EditFull', compact('test', 'catIndex', 'spaceIndex', 'titleIndex', 'paragraphIndex'));
    } catch (\Exception $e) {
        return redirect()->route('Users.Admin.AvailableTests.AllTests')->with('error', 'Error loading test: ' . $e->getMessage());
    }
}

/**
 * Update the specified test in storage with all its components.
 */
/**
 * Update the specified test in storage with all its components.
 */
public function updateTestFull(Request $request, $id)
{
    try {
        // Validate test name uniqueness
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                Rule::unique('availabletests', 'name')->ignore($id)
            ]
        ], [
            'name.unique' => "The test name '{$request->name}' already exists."
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors(),
                    'message' => 'Validation failed. Please check the form.'
                ], 422);
            }

            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        // Find the test
        $test = AvailableTest_New::findOrFail($id);

        // Update basic test info
        $test->update([
            'name' => $request->name,
            'specimen' => $request->specimen,
            'price' => $request->price,
        ]);

        // Collect all components with their order values
        $allComponents = [];

        // Add categories to the components array
        if ($request->has('categories')) {
            foreach ($request->categories as $index => $categoryData) {
                $orderValue = $request->input("order.categories.{$index}", 999999);
                $allComponents[] = [
                    'type' => 'category',
                    'order_value' => intval($orderValue),
                    'data' => $categoryData,
                    'index' => $index
                ];
            }
        }

        // Add spaces to the components array
        if ($request->has('elements') && isset($request->elements['space'])) {
            foreach ($request->elements['space'] as $index => $spaceData) {
                $orderValue = $request->input("order.spaces.{$index}", 999999);
                $allComponents[] = [
                    'type' => 'space',
                    'order_value' => intval($orderValue),
                    'data' => $spaceData,
                    'index' => $index
                ];
            }
        }

        // Add titles to the components array
        if ($request->has('elements') && isset($request->elements['title'])) {
            foreach ($request->elements['title'] as $index => $titleData) {
                $orderValue = $request->input("order.titles.{$index}", 999999);
                $allComponents[] = [
                    'type' => 'title',
                    'order_value' => intval($orderValue),
                    'data' => $titleData,
                    'index' => $index
                ];
            }
        }

        // Add paragraphs to the components array
        if ($request->has('elements') && isset($request->elements['paragraph'])) {
            foreach ($request->elements['paragraph'] as $index => $paragraphData) {
                $orderValue = $request->input("order.paragraphs.{$index}", 999999);
                $allComponents[] = [
                    'type' => 'paragraph',
                    'order_value' => intval($orderValue),
                    'data' => $paragraphData,
                    'index' => $index
                ];
            }
        }

        // Sort components by their order_value
        usort($allComponents, function($a, $b) {
            return $a['order_value'] - $b['order_value'];
        });

        // Temporarily update existing items with high display_order values
        DB::table('test_categories')
            ->where('availableTests_id', $test->id)
            ->update(['display_order' => DB::raw('display_order + 10000')]);

        DB::table('availableTest_elements')
            ->where('availableTests_id', $test->id)
            ->update(['display_order' => DB::raw('display_order + 10000')]);

        // Process all components in the sorted order
       // Process all components in the sorted order
foreach ($allComponents as $component) {
    $newOrder = $component['order_value']; // Use the order_value from the form

    switch ($component['type']) {
        case 'category':
            $categoryData = $component['data'];
            if (isset($categoryData['id']) && $categoryData['id'] !== 'new') {
                $category = TestCategory_New::find($categoryData['id']);
                if ($category) {
                    $category->update([
                        'name' => $categoryData['name'] ?? '',
                        'value_type' => $categoryData['value_type'] ?? 'range',
                        'unit_enabled' => isset($categoryData['unit']) && !empty($categoryData['unit']),
                        'unit' => isset($categoryData['unit']) && !empty($categoryData['unit']) ? $categoryData['unit'] : null,
                        'reference_type' => $categoryData['reference_type'] ?? 'none',
                        'min_value' => $categoryData['min_value'] ?? null,
                        'max_value' => $categoryData['max_value'] ?? null,
                        'display_order' => $newOrder,
                    ]);
                }
            } else {
                $category = TestCategory_New::create([
                    'availableTests_id' => $test->id,
                    'name' => $categoryData['name'] ?? '',
                    'value_type' => $categoryData['value_type'] ?? 'range',
                    'unit_enabled' => isset($categoryData['unit']) && !empty($categoryData['unit']),
                    'unit' => isset($categoryData['unit']) && !empty($categoryData['unit']) ? $categoryData['unit'] : null,
                    'reference_type' => $categoryData['reference_type'] ?? 'none',
                    'min_value' => $categoryData['min_value'] ?? null,
                    'max_value' => $categoryData['max_value'] ?? null,
                    'display_order' => $newOrder,
                ]);
            }
            break;

        case 'space':
            $spaceData = $component['data'];
            if (isset($spaceData['id']) && $spaceData['id'] !== 'new') {
                $space = TestElement_New::find($spaceData['id']);
                if ($space) {
                    $space->update([
                        'display_order' => $newOrder,
                    ]);
                }
            } else {
                TestElement_New::create([
                    'availableTests_id' => $test->id,
                    'type' => 'space',
                    'content' => null,
                    'display_order' => $newOrder,
                ]);
            }
            break;

        case 'title':
            $titleData = $component['data'];
            if (isset($titleData['id']) && $titleData['id'] !== 'new') {
                $title = TestElement_New::find($titleData['id']);
                if ($title) {
                    $title->update([
                        'content' => $titleData['content'] ?? '',
                        'display_order' => $newOrder,
                    ]);
                }
            } else {
                if (!empty($titleData['content'])) {
                    TestElement_New::create([
                        'availableTests_id' => $test->id,
                        'type' => 'title',
                        'content' => $titleData['content'],
                        'display_order' => $newOrder,
                    ]);
                }
            }
            break;

        case 'paragraph':
            $paragraphData = $component['data'];
            if (isset($paragraphData['id']) && $paragraphData['id'] !== 'new') {
                $paragraph = TestElement_New::find($paragraphData['id']);
                if ($paragraph) {
                    $paragraph->update([
                        'content' => $paragraphData['content'] ?? '',
                        'display_order' => $newOrder,
                    ]);
                }
            } else {
                if (!empty($paragraphData['content'])) {
                    TestElement_New::create([
                        'availableTests_id' => $test->id,
                        'type' => 'paragraph',
                        'content' => $paragraphData['content'],
                        'display_order' => $newOrder,
                    ]);
                }
            }
            break;
    }
}

        // Handle deleted categories
        if ($request->has('deleted_categories')) {
            foreach ($request->deleted_categories as $categoryId) {
                $category = TestCategory_New::find($categoryId);
                if ($category) {
                    // Delete reference range table entries first
                    ReferenceRangeTable::where('test_categories_id', $category->id)->delete();
                    // Then delete the category
                    $category->delete();
                }
            }
        }

        // Handle deleted elements
        if ($request->has('deleted_elements')) {
            foreach ($request->deleted_elements as $elementId) {
                TestElement_New::where('id', $elementId)->delete();
            }
        }

        DB::commit();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Test template updated successfully!'
            ]);
        }

        return redirect()->route('admin.allAvailableTest')->with('success', 'Test template updated successfully!');

    } catch (\Exception $e) {
        DB::rollBack();

        if ($request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating test template: ' . $e->getMessage()
            ], 500);
        }

        return redirect()->back()->with('error', 'Error updating test template: ' . $e->getMessage())->withInput();
    }
}


/**
 * Get test template structure
 */
public function getTestTemplateStructure($id)
{
    try {
        $test = AvailableTest_New::with(['categories.referenceRangeTable', 'elements'])
            ->findOrFail($id);

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

        return response()->json([
            'success' => true,
            'test' => $test,
            'components' => $components
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error loading test template: ' . $e->getMessage()
        ], 500);
    }
}



    public function deleteTest(Request $request)
{
    try {
        DB::beginTransaction();

        $test = AvailableTest_New::findOrFail($request->test_id);
        $testName = $test->name;

        // First delete all related reference range tables
        foreach ($test->categories as $category) {
            ReferenceRangeTable::where('test_categories_id', $category->id)->delete();
        }

        // Delete all related categories
        TestCategory_New::where('availableTests_id', $test->id)->delete();

        // Delete all related test elements
        TestElement_New::where('availableTests_id', $test->id)->delete();

        // Finally delete the test itself
        $test->delete();

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => "Test '{$testName}' has been deleted successfully."
        ]);

    } catch (\Exception $e) {
        DB::rollBack();

        return response()->json([
            'success' => false,
            'message' => 'Error deleting test: ' . $e->getMessage()
        ], 500);
    }
}

//view report
// In your controller
/**
 * Display a preview of the test report
 */
public function viewTestReport($id)
{
    try {
        // Get the test and its associated data
        $test = AvailableTest_New::with([
            'categories' => function($q) {
                $q->orderBy('display_order');
            },
            'elements' => function($q) {
                $q->orderBy('display_order');
            }
        ])->findOrFail($id);

        // Load reference tables for categories
        foreach($test->categories as $category) {
            if ($category->reference_type === 'table') {
                // Get the reference table data
                $tableData = ReferenceRangeTable::where('test_categories_id', $category->id)
                    ->get();

                // Find the number of columns
                $maxColumn = $tableData->max('column');

                // Organize data into a proper grid
                $referenceTable = [];
                foreach ($tableData as $cell) {
                    if (!isset($referenceTable[$cell->row])) {
                        $referenceTable[$cell->row] = array_fill(0, $maxColumn + 1, '');
                    }
                    $referenceTable[$cell->row][$cell->column] = $cell->value;
                }

                $category->referenceTable = $referenceTable;
            }
        }

        // Collect all elements in display order
        $allElements = [];

        // Add categories
        foreach ($test->categories as $category) {
            $allElements[] = [
                'type' => 'category',
                'data' => $category,
                'order' => $category->display_order
            ];
        }

        // Add other elements
        foreach ($test->elements as $element) {
            $allElements[] = [
                'type' => $element->type,
                'data' => $element,
                'order' => $element->display_order
            ];
        }

        // Sort elements by display order
        usort($allElements, function($a, $b) {
            return $a['order'] - $b['order'];
        });

        // Prepare test results
        $testResults = [];
        foreach ($allElements as $element) {
            switch ($element['type']) {
                case 'category':
                    $category = $element['data'];

                    // Generate sample result based on value type
                    $result = $this->generateSampleResult($category);

                    // Generate reference range
                    $reference = $this->formatReference($category);

                    $testResults[] = [
                        'name' => $category->name,
                        'result' => $result,
                        'reference' => $reference,
                        'isCategory' => true
                    ];
                    break;

                case 'title':
                    $testResults[] = [
                        'name' => $element['data']->content,
                        'result' => '',
                        'reference' => '',
                        'isTitle' => true
                    ];
                    break;

                case 'paragraph':
                    $testResults[] = [
                        'name' => '',
                        'result' => $element['data']->content,
                        'reference' => '',
                        'isParagraph' => true
                    ];
                    break;

                case 'space':
                    $testResults[] = [
                        'name' => '',
                        'result' => '',
                        'reference' => '',
                        'isSpace' => true
                    ];
                    break;
            }
        }

        // Sample data for the preview
        $sampleData = [
            'patientName' => 'Sample Patient',
            'age' => '45',
            'gender' => 'Male',
            'reportId' => 'DEMO-'.date('Ymd').'-'.$id,
            'reportDate' => date('Y-m-d'),
            'specimenType' => $test->specimen,
            'testName' => $test->name, // Added test name here
            'testResults' => $testResults
        ];

        // Return the view with the sample data
        return view('Users.labReport', compact('sampleData'));

    } catch (\Exception $e) {
        \Log::error('Report preview error: ' . $e->getMessage());
        return back()->with('error', 'Failed to generate report preview: ' . $e->getMessage());
    }
}

/**
 * Generate a sample result based on category type
 */
private function generateSampleResult($category)
{
    switch ($category->value_type) {
        case 'negpos':
            return rand(0, 1) ? 'Negative' : 'Positive';

        case 'text':
            $sampleTexts = ['Normal', 'No abnormality detected', 'Within normal limits'];
            return $sampleTexts[array_rand($sampleTexts)];

        case 'range':
            // Generate a random number within or near the reference range
            if ($category->reference_type === 'minmax' && $category->min_value !== null && $category->max_value !== null) {
                $min = floatval($category->min_value);
                $max = floatval($category->max_value);
                $value = $min + (mt_rand() / mt_getrandmax()) * ($max - $min);
                $value = round($value, 1);

                if ($category->unit_enabled && $category->unit) {
                    return $value . ' ' . $category->unit;
                }
                return $value;
            }

            return mt_rand(50, 150);
    }
}

/**
 * Format reference range for display
 */
private function formatReference($category)
{
    if ($category->reference_type === 'none') {
        return '-';
    } else if ($category->reference_type === 'minmax') {
        $range = '';
        if ($category->min_value !== null && $category->max_value !== null) {
            $range = "{$category->min_value} - {$category->max_value}";
        } else if ($category->min_value !== null) {
            $range = "> {$category->min_value}";
        } else if ($category->max_value !== null) {
            $range = "< {$category->max_value}";
        }

        if ($category->unit_enabled && $category->unit && !empty($range)) {
            $range .= " {$category->unit}";
        }

        return $range;
    } else if ($category->reference_type === 'table') {
        // Return the reference table
        return [
            'isTable' => true,
            'data' => $category->referenceTable
        ];
    }

    return '';
}



//External Available tests
    public function addExternalAvailableTest()
    {
        return view('Users.Admin.AvailableTests.addexternalTest');
    }

    public function allExternalAvailableTest()
    {
        return view('Users.Admin.AvailableTests.allExternalTest');
    }

     public function addingExternalAvailableTest(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'name' => 'required|string|max:255',
            'specimen' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'is_internal' => 'required|boolean',
        ]);

        // Create a new available test
        $availableTest = AvailableTest_New::create([
            'name' => $request->name,
            'specimen' => $request->specimen,
            'price' => $request->price,
            'is_internal' => $request->is_internal,
        ]);

        // Return a success response
        return response()->json([
            'message' => 'Test added successfully!',
            'data' => $availableTest
        ], 201);
    }

    public function getExternalAvailableTest()
    {
        try {
            $tests = AvailableTest_New::select([
                'id',
                'name',
                'specimen',
                'price',
                'created_at'
            ])
            ->where('is_internal', false) // Fetch rows where is_internal is false
            ->get();

            return DataTables::of($tests)
                ->addColumn('actions', function ($test) {
                    $actions = '<div class="btn-group">';
                    $actions .= '<button type="button" class="btn btn-primary btn-sm editBtn"
                                    data-id="'.$test->id.'"
                                    data-name="'.htmlspecialchars($test->name, ENT_QUOTES).'"
                                    data-specimen="'.$test->specimen.'"
                                    data-price="'.$test->price.'">
                                    <i class="fas fa-edit"></i>
                                </button>';
                    $actions .= '<button type="button" class="btn btn-danger btn-sm deleteBtn" data-id="'.$test->id.'" data-name="'.htmlspecialchars($test->name, ENT_QUOTES).'"><i class="fas fa-trash"></i></button>';
                    $actions .= '</div>';
                    return $actions;
                })
                ->addColumn('specimen', function ($test) {
                    if (empty($test->specimen)) return '<span class="text-muted">Not specified</span>';
                    return ucfirst($test->specimen);
                })
                ->addColumn('price', function ($test) {
                    if (empty($test->price)) return '<span class="text-muted">-</span>';
                    return number_format($test->price, 2);
                })
                ->editColumn('created_at', function ($test) {
                    return $test->created_at ? $test->created_at->format('M d, Y') : '';
                })
                ->rawColumns(['actions', 'specimen', 'categories_count', 'price'])
                ->make(true);
        } catch (\Exception $e) {
            \Log::error('DataTables error: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while fetching data'], 500);
        }
    }



}
