<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ProposalController extends Controller
{
    private $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    public function index()
    {
        if ($this->user->role == 'Member') {
            $success = Proposal::where('user_id', $this->user->id)->count();
            return view('proposal.index_member', compact('success'));
        } else {
            return view('proposal.index_admin');
        }
    }

    public function getData()
    {
        $data = Proposal::with('user');

        return DataTables::of($data)
            ->addColumn('action', function ($data) {
                //
            })
            ->editColumn('proposal', function ($data) {
                return '<a class= "badge badge-sm btn-primary" href="' . asset('uploaded/proposal/' . $data->proposal) . '">File</a>';
            })
            ->rawColumns(['action', 'proposal'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $rules = [
            'proposal' => 'required|file|mimes:pdf|max:2048', // Only allow PDF files up to 2MB (2048 KB)
        ];

        $messages = [];

        $request->validate($rules, $messages);

        if ($request->hasFile('proposal')) {
            $pdfName = time() . '.' . $request->proposal->getClientOriginalExtension();
            $request->proposal->move(public_path('uploaded/proposal/'), $pdfName);
        }

        Proposal::create([
            'user_id'       => $this->user->id,
            'proposal'      => $pdfName,
        ]);

        return redirect()->route('proposal.index');
    }

    public function destroy($id)
    {
        $member = Proposal::find($id);
        if (!$member) {
            return response()->json(['success' => false, 'message' => 'Proposal not found.'], 404);
        }

        $member->delete();
        return response()->json(['success' => true, 'message' => 'Data Proposal Successfully Deleted!']);
    }
}
