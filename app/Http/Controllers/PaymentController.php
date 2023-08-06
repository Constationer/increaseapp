<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class PaymentController extends Controller
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
            $member = Member::where('user_id', $this->user->id)
                ->orderBy('status', 'asc')
                ->take(4)
                ->get();
            $success = Payment::where('user_id', $this->user->id)->where('status', 'Approved')->count();
            $waiting = Payment::where('user_id', $this->user->id)->where('status', 'Waiting')->count();
            $team = $this->user->team;
            return view('payment.index_member', compact('member', 'success', 'waiting', 'team'));
        } else {
            return view('payment.index_admin');
        }
    }

    public function getData()
    {
        $data = Payment::with('user');

        return DataTables::of($data)
            ->editColumn('action', function ($data) {
                if ($data->status == 'Waiting') {
                    return '<button class="btn btn-success" onclick="approvePayment(' . $data->id
                        .
                        ')" ><i class="fas fa-check"></i></button>' .
                        '<button class="btn btn-danger" onclick="rejectPayment(' . $data->id .
                        ')" ><i class="fas fa-times"></i></button>';
                }
            })
            ->editColumn('photo', function ($data) {
                return '<a class= "badge badge-sm btn-primary" href="' . asset('uploaded/payment/photo/' . $data->photo) . '">Photo</a>';
            })
            ->rawColumns(['action', 'photo'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $rules = [
            'method' => 'required',
            'category' => 'required',
            'stage' => 'required',
            'photo' => 'image|mimes:jpeg,png,jpg|max:2048',
        ];

        $messages = [];

        $request->validate($rules, $messages);

        if ($request->hasFile('photo')) {
            $imageName = time() . '.' . $request->photo->extension();
            $request->photo->move(public_path('uploaded/payment/photo/'), $imageName);
        }

        Payment::create([
            'user_id'       => $this->user->id,
            'method'        => $request->input('method'),
            'category'      => $request->input('category'),
            'stage'         => $request->input('stage'),
            'status'        => 'Waiting',
            'photo'         => $imageName,
        ]);

        return redirect()->route('payment.index');
    }

    public function approve($id)
    {
        $payment = Payment::find($id);
        if (!$payment) {
            return response()->json(['success' => false, 'message' => 'Payment not found.'], 404);
        }

        try {
            $data = Payment::findoRfail($id);
            $data->status = 'Approved';
            $data->save();
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors());
        }

        return response()->json(['success' => true, 'message' => 'Data Payment Successfully Approved!']);
    }

    public function reject($id)
    {
        $payment = Payment::find($id);
        if (!$payment) {
            return response()->json(['success' => false, 'message' => 'Payment not found.'], 404);
        }

        try {
            $data = Payment::findoRfail($id);
            $data->status = 'Rejected';
            $data->save();
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors());
        }

        return response()->json(['success' => true, 'message' => 'Data Payment Successfully Rejected!']);
    }
}
