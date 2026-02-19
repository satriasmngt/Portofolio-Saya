<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /* ================= DATATABLE ================= */
    public function datatable(Request $request)
    {
        if ($request->ajax()) {

            $data = User::latest();

            return DataTables::of($data)

                ->addIndexColumn()

                ->addColumn('avatar', function ($row) {
                    return '<img src="https://ui-avatars.com/api/?name=' . urlencode($row->name) . '" 
                                width="35" class="rounded-circle">';
                })

                ->addColumn('actions', function ($row) {

                    $btn = '
                    <div class="d-flex gap-1 justify-content-center">

                        <button 
                            class="btn btn-warning btn-sm btn-edit"
                            data-id="' . $row->id . '"
                            data-name="' . $row->name . '"
                            data-email="' . $row->email . '"
                        >
                            Edit
                        </button>

                         <button 
            class="btn btn-danger btn-sm btn-delete"
            data-id="' . $row->id . '"
            data-name="' . $row->name . '"
        >
            Hapus
        </button>

                    </div>
                    ';

                    return $btn;
                })

                ->rawColumns(['avatar', 'actions'])
                ->make(true);
        }
    }

    /* ================= STORE ================= */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:4'
        ]);

        try {

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return redirect()->back()->with('success', 'User berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambah user');
        }
    }

    /* ================= UPDATE ================= */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:4'
        ]);

        try {

            $data = [
                'name' => $request->name,
                'email' => $request->email,
            ];

            if ($request->password) {
                $data['password'] = Hash::make($request->password);
            }

            $user->update($data);

            return redirect()->back()->with('success', 'User berhasil diupdate');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal update user');
        }
    }

    /* ================= DELETE ================= */
public function destroy($id)
{
    try {

        $user = User::findOrFail($id);

        // opsional: jangan bisa hapus diri sendiri
        if ($user->id == auth()->id()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tidak bisa menghapus akun sendiri'
            ]);
        }

        $user->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'User berhasil dihapus'
        ]);

    } catch (\Exception $e) {

        return response()->json([
            'status' => 'error',
            'message' => 'Gagal menghapus user'
        ]);
    }
}
}
