<?php

namespace App\Http\Controllers;

use App\Http\Middleware\CheckRole;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class MemberController extends Controller
{
    public function index()
    {
        $max = Member::where('user_id', Auth::user()->id)->count();
        return view('member.index', compact('max'));
    }

    public function getData()
    {
        $checker = Auth::user();
        if ($checker->role == 'Member') {
            $data = Member::with('user')->where('user_id', $checker->id)->get();
        } else {
            $data = Member::with('user');
        }

        return DataTables::of($data)
            ->addColumn('action', function ($data) {
                //
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        return view('member.create');
    }
    public function store(Request $request)
    {
        // Define validation rules
        $rules = [
            'status' => 'required|in:Leader,Member',
            'name' => 'required',
            'gender' => 'required|in:Male,Female',
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'nationality' => 'required',
            'university' => 'required',
            'major' => 'required',
            'photo' => 'image|mimes:jpeg,png,jpg|max:2048',
        ];

        $messages = [];

        $request->validate($rules, $messages);

        if ($request->hasFile('photo')) {
            $imageName = time() . '.' . $request->photo->extension();
            $request->photo->move(public_path('uploaded/member/photo/'), $imageName);
        }

        Member::create([
            'user_id'       => Auth::user()->id,
            'status'        => $request->input('status'),
            'name'          => $request->input('name'),
            'gender'        => $request->input('gender'),
            'address'       => $request->input('address'),
            'phone'         => $request->input('phone'),
            'email'         => $request->input('email'),
            'nationality'   => $request->input('nationality'),
            'university'    => $request->input('university'),
            'major'         => $request->input('major'),
            'photo'         => $imageName,
        ]);

        return redirect()->route('member.index');
    }

    public function edit($id)
    {
        $data = Member::findoRfail($id);

        return view('member.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        try {
            $data = Member::findoRfail($id);
            $data->status = $request->status;
            $data->name = $request->name;
            $data->gender = $request->gender;
            $data->address = $request->address;
            $data->phone = $request->phone;
            $data->email = $request->email;
            $data->nationality = $request->nationality;
            $data->university = $request->university;
            $data->major = $request->major;
            // $data->photo = $request->golongan;
            $data->save();

            return redirect()->route('member.index');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors());
        }
    }

    public function destroy($id)
    {
        $member = Member::find($id);
        if (!$member) {
            return response()->json(['success' => false, 'message' => 'Member not found.'], 404);
        }

        $member->delete();
        return response()->json(['success' => true, 'message' => 'Data Member Successfully Deleted!']);
    }
}
