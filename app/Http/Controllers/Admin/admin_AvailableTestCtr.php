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
        $AvailableTestsSubcategory = subcategory::with('availableTests')->get();
        $AvailableTests=AvailableTest::all();
// dd($AvailableTests,$AvailableTestsSubcategory);
        return view('Users.Admin.AvailableTests.AllTests',compact('AvailableTests','AvailableTestsSubcategory'));
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
            DB::beginTransaction();

            $testsData = $request->input('tests', []);

            foreach ($testsData as $testData) {
                // Create the test
                $test = AvailableTest_New::create([
                    'name' => $testData['name'] ?? '',
                    'specimen' => $testData['specimen'] ?? null,
                    'cost' => $testData['cost'] ?? null,
                    'price' => $testData['price'] ?? null,
                ]);

                $displayOrder = 1;

                // Process categories
                if (isset($testData['categories'])) {
                    foreach ($testData['categories'] as $categoryData) {
                        // Determine if unit is enabled (if the unit field exists and is not empty)
                        $unitEnabled = isset($categoryData['unit']) && !empty($categoryData['unit']);

                        // Create category
                        $category = TestCategory_New::create([
                            'availableTests_id' => $test->id,
                            'name' => $categoryData['name'] ?? '',
                            'value_type' => $categoryData['value_type'] ?? 'range',
                            'unit_enabled' => $unitEnabled, // New field
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
                    }
                }

                // Process custom spaces
                if (isset($testData['custom_space'])) {
                    foreach ($testData['custom_space'] as $space) {
                        TestElement_New::create([
                            'availableTests_id' => $test->id,
                            'type' => 'space',
                            'content' => null,
                            'display_order' => $displayOrder++,
                        ]);
                    }
                }

                // Process custom titles
                if (isset($testData['custom_title'])) {
                    foreach ($testData['custom_title'] as $title) {
                        if (!empty($title)) {
                            TestElement_New::create([
                                'availableTests_id' => $test->id,
                                'type' => 'title',
                                'content' => $title,
                                'display_order' => $displayOrder++,
                            ]);
                        }
                    }
                }

                // Process custom paragraphs
                if (isset($testData['custom_paragraph'])) {
                    foreach ($testData['custom_paragraph'] as $paragraph) {
                        if (!empty($paragraph)) {
                            TestElement_New::create([
                                'availableTests_id' => $test->id,
                                'type' => 'paragraph',
                                'content' => $paragraph,
                                'display_order' => $displayOrder++,
                            ]);
                        }
                    }
                }
            }

            DB::commit();

            return redirect()->back()->with('success', 'Test template created successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error creating test template: ' . $e->getMessage())->withInput();
        }
    }


}
