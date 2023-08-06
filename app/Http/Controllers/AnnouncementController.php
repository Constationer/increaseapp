<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AnnouncementController extends Controller
{
    public function index()
    {
        return view('announcement.index');
    }

    public function getData()
    {
        $data = Announcement::all();

        return DataTables::of($data)
            ->addColumn('action', function ($data) {
                //
            })
            ->rawColumns(['action', 'isi'])
            ->make(true);
    }

    public function create()
    {
        return view('announcement.create');
    }
    public function store(Request $request)
    {
        // Define validation rules
        $rules = [
            'judul' => 'required',
            'isi' => 'required',
        ];

        $messages = [];

        $request->validate($rules, $messages);

        Announcement::create([
            'judul'        => $request->input('judul'),
            'isi'          => $request->input('isi'),
        ]);

        return redirect()->route('announcement.index');
    }

    public function edit($id)
    {
        $data = Announcement::findoRfail($id);

        return view('announcement.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        try {
            $data = Announcement::findoRfail($id);
            $data->judul = $request->judul;
            $data->isi = $request->isi;
            $data->save();

            return redirect()->route('announcement.index');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors());
        }
    }

    public function destroy($id)
    {
        $data = Announcement::find($id);
        if (!$data) {
            return response()->json(['success' => false, 'message' => 'Announcement not found.'], 404);
        }

        $data->delete();
        return response()->json(['success' => true, 'message' => 'Data Announcement Successfully Deleted!']);
    }
}
