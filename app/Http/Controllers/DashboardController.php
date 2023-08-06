<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Member;
use App\Models\Payment;
use App\Models\Proposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function index()
    {
        $totalMember = Member::count();
        $totalPayment = Payment::where('status', 'Waiting')->count();
        $totalProposal = Proposal::count();
        $totalAnnouncement = Announcement::count();
        $announcement = Announcement::orderBy('created_at', 'desc')->get();

        return view('dashboard', compact('announcement', 'totalMember', 'totalPayment', 'totalProposal', 'totalAnnouncement'));
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/'); // Redirect to the desired page after logout, e.g., home page
    }
}
