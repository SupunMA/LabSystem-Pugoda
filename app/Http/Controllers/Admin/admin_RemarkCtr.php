<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Remark; // Assuming you have a Remark model
use DataTables; // Make sure you have Yajra/Laravel-DataTables installed

class admin_RemarkCtr extends Controller
{
    public function addRemarks()
    {
        return view('Users.Admin.Remarks.addRemarks');
    }

    public function addingRemarks(Request $request)
    {
        try {
            $request->validate([
                'remark_description' => 'required|string|max:255|unique:remarks,remark_description',
            ]);

            Remark::create([
                'remark_description' => $request->remark_description,
            ]);

            // If it's an AJAX request, return JSON
            if ($request->ajax()) {
                return response()->json(['message' => 'Remark added successfully!'], 200);
            }

            // Fallback for non-AJAX requests (though the modal form is AJAX now)
            return redirect()->route('admin.allRemarks')->with('success', 'Remark added successfully!');

        } catch (ValidationException $e) {
            // If validation fails, return JSON response with errors for AJAX
            if ($request->ajax()) {
                return response()->json([
                    'message' => 'Validation Failed',
                    'errors' => $e->errors()
                ], 422); // 422 Unprocessable Entity
            }

            // Fallback for non-AJAX requests
            return redirect()->back()->withErrors($e->errors())->withInput();

        } catch (\Exception $e) {
            // Catch any other general exceptions during storage
            if ($request->ajax()) {
                return response()->json(['message' => 'Failed to add remark. ' . $e->getMessage()], 500);
            }
            return redirect()->back()->with('error', 'Failed to add remark.')->withInput();
        }
    }

    public function allRemarks(Request $request)
    {
        if ($request->ajax()) {
            $data = Remark::select('remark_id', 'remark_description')->get();
            return DataTables::of($data)
                ->addColumn('actions', function($row){
                    // This column will be handled by JavaScript to show buttons
                    return ''; // Empty as buttons are rendered on the client side
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
        return view('Users.Admin.Remarks.allRemarks');
    }

    public function deleteRemarks($ID)
    {
        $remark = Remark::find($ID);
        if ($remark) {
            $remark->delete();
            return redirect()->route('admin.allRemarks')->with('success', 'Remark deleted successfully!');
        }
        return redirect()->route('admin.allRemarks')->with('error', 'Remark not found!');
    }

    //new delete method for AJAX
    public function deleteRemarksAjax(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:remarks,remark_id',
        ]);

        $remark = Remark::find($request->id);

        if ($remark) {
            $remark->delete();
            return response()->json(['message' => 'Remark deleted successfully!'], 200);
        }

        return response()->json(['message' => 'Remark not found!'], 404);
    }



    public function updateRemarks(Request $request)
    {
        try {
            // Validate the request data
            $request->validate([
                'remark_id' => 'required|exists:remarks,remark_id',
                // unique:table,column,except_id,id_column
                // This ensures the description is unique, but ignores the current remark's description
                'remark_description' => 'required|string|max:255|unique:remarks,remark_description,' . $request->remark_id . ',remark_id',
            ]);

            $remark = Remark::find($request->remark_id);

            if (!$remark) {
                // This case should ideally be caught by 'exists:remarks,remark_id' validation,
                // but added as a double-check for robustness.
                if ($request->ajax()) {
                    return response()->json(['message' => 'Remark not found!'], 404);
                }
                return redirect()->back()->with('error', 'Remark not found!');
            }

            $remark->remark_description = $request->remark_description;
            $remark->save();

            // If it's an AJAX request, return JSON
            if ($request->ajax()) {
                return response()->json(['message' => 'Remark updated successfully!'], 200);
            }

            // Fallback for non-AJAX requests (if any)
            return redirect()->route('admin.allRemarks')->with('success', 'Remark updated successfully!');

        } catch (ValidationException $e) {
            // If validation fails, return JSON response with errors for AJAX
            if ($request->ajax()) {
                return response()->json([
                    'message' => 'Validation Failed',
                    'errors' => $e->errors()
                ], 422); // 422 Unprocessable Entity
            }

            // Fallback for non-AJAX requests
            return redirect()->back()->withErrors($e->errors())->withInput();

        } catch (\Exception $e) {
            // Catch any other general exceptions during storage
            if ($request->ajax()) {
                return response()->json(['message' => 'Failed to update remark. ' . $e->getMessage()], 500);
            }
            return redirect()->back()->with('error', 'Failed to update remark.')->withInput();
        }
    }
    public function checkRemarkUniqueness(Request $request)
    {
        $description = $request->input('description');
        $remarkId = $request->input('remark_id'); // Will be null for add modal, present for edit modal

        // For adding new remarks, simply check if the description exists
        $isUnique = !Remark::where('remark_description', $description)
                            ->when($remarkId, function ($query) use ($remarkId) {
                                // Exclude the current remark if checking for update
                                return $query->where('remark_id', '!=', $remarkId);
                            })
                            ->exists();

        return response()->json(['isUnique' => $isUnique]);
    }

    public function getRemarks()
    {
        try {
            $remarks = Remark::all(['remark_id', 'remark_description']);
            return response()->json(['success' => true, 'remarks' => $remarks]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to fetch remarks.', 'error' => $e->getMessage()], 500);
        }
    }

}
