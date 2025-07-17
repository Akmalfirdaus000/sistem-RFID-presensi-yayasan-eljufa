<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RFID;
use App\Models\User; // Pastikan Anda menambahkan ini
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminRfidController extends Controller
{
     public function index()
     {
         $rfids = RFID::all();
         return view('admin.rfid.index', compact('rfids'));
     }

     public function create()
     {
         return view('admin.rfid.add');
     }

     public function store(Request $request)
     {
         $request->validate([
             'id_rfid' => 'required|unique:rfids,id_rfid',
             'rfid' => 'required|unique:rfids,rfid',
             'status' => 'required|in:active,inactive',
         ]);

         RFID::create($request->only(['id_rfid', 'rfid', 'status']));

         return redirect()->route('admin.rfid.index')->with('message', 'RFID berhasil ditambahkan.');
     }

     public function edit($id)
     {
         $rfid = RFID::findOrFail($id);
         return view('admin.rfid.edit', compact('rfid'));
     }

     public function update(Request $request, $id)
     {
         $request->validate([
             'rfid' => 'required|unique:rfids,rfid,' . $id . ',id_rfid',
             'status' => 'required|in:active,inactive',
         ]);

         $rfid = RFID::findOrFail($id);
         $rfid->update($request->only(['rfid', 'status']));

         return redirect()->route('admin.rfid.index')->with('message', 'RFID berhasil diperbarui.');
     }

     public function destroy($id)
     {
         $rfid = RFID::findOrFail($id);
         $rfid->delete();

         return redirect()->route('admin.rfid.index')->with('message', 'RFID berhasil dihapus.');
     }
}
