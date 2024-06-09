<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\{DB,Storage};
use App\Models\{User, Asesor, Kelas, KelompokAsesor};
use App\Http\Requests\{StoreAsesorRequest,UpdateAsesorRequest};

class AsesorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.asesor.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAsesorRequest $request)
    {
        $validated = $request->validated();

        $faker = \Faker\Factory::create('id_ID');
        try {
            DB::beginTransaction();
            $validated['password'] = bcrypt($validated['nip']);
            $validated['username'] = strtolower(explode(" ",$validated['name'])[0]);

            $photo = $request->file('photo');
            $berkas = $request->file('surat_tugas');
            $gender = $request->input('jenis_kelamin');

            if($photo && !empty($photo)) {
                $validated['photo'] = $photo->store('profilePicture');
            }
            if($berkas && !empty($berkas)) {
                $validated['surat_tugas'] = $berkas->store('suratTugas');
            }

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $validated['password'],
                'username' => $validated['username'] . $faker->numerify('####'),
                'phone' => $validated['phone'],
                'jenis_kelamin' => empty($gender) ? null : $validated['jenis_kelamin'],
                'address' => $validated['address'],
                'photo' => empty($photo) ? null : $validated['photo'],
                'role' => 'Asesor'
            ]);
            if ($user) {
                $asesor = Asesor::create([
                    'user_id' => (int) $user['id'],
                    'nip' => $validated['nip'],
                    'surat_tugas' => empty($photo) ? null : $validated['surat_tugas']
                ]);
                if($asesor) {
                    DB::commit();
                    return response()->json(['status' => 'success', 'message' => 'Data asesor berhasil ditambahkan'], 200);
                } else {
                    DB::rollBack();
                    return response()->json(['status' => 'error', 'message' => 'Data asesor gagal disimpan'], 500);
                }
            } else {
                DB::rollBack();
                return response()->json(['status' => 'error', 'message' => 'Data asesor gagal disimpan'], 500);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($uuid)
    {
        $asesor = Asesor::with('user')
        ->firstWhere('uuid', $uuid);
        if(!empty($asesor)) {
            return response()->json(['status' => 'success', 'data' => $asesor], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Data asesor tidak ditemukan'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAsesorRequest $request, $uuid)
    {
        $validated = $request->validated();
        $request->validate([
            'nip' => 'unique:m_asesor,nip,'.$uuid.',uuid',
        ],$this->messageValidation());
        $data = Asesor::with('user')->firstWhere('uuid',$uuid);
        if(empty($data)) {
            return response()->json(['status' => 'error', 'message' => 'Data asesor tidak ditemukan'], 404);
        }
        $request->validate([
            'username' => 'unique:users,username,'.(int) $data['user_id'].',id',
            'phone' => 'nullable|unique:users,phone,'.(int) $data['user_id'].',id',
            'email' => 'unique:users,email,'.(int) $data['user_id'].',id',
        ],$this->messageValidation());

        try {
            DB::beginTransaction();
            $photo = $request->file('photo');
            $berkas = $request->file('surat_tugas');
            $password = $request->input('password');
            $gender = $request->input('jenis_kelamin');

            if($photo && !empty($photo)) {
                if($data->user['photo'] != null && Storage::exists($data->user['photo'])) {
                    Storage::delete($data->user['photo']);
                }
                $validated['photo'] = $photo->store('profilePicture');
            }

            if($berkas && !empty($berkas)) {
                if($data['surat_tugas'] != null && Storage::exists($data['surat_tugas'])) {
                    Storage::delete($data['surat_tugas']);
                }
                $validated['surat_tugas'] = $berkas->store('suratTugas');
            }

            if(!empty($password)) {
                $validated['password'] = bcrypt($password);
            }

            $user = User::whereId((int)$data['user_id'])->first();

            $asesorUpdate = $data->update([
                'nip' => $validated['nip'],
                'surat_tugas' => empty($berkas) ? $data['surat_tugas'] : $validated['surat_tugas']
            ]);
            $userUpdate = $user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => empty($password) ? $data->user['password'] : $validated['password'],
                'username' => $validated['username'],
                'phone' => $validated['phone'],
                'jenis_kelamin' => empty($gender) ? null : $validated['jenis_kelamin'],
                'address' => $validated['address'],
                'photo' => empty($photo) ? $data->user['photo'] : $validated['photo'],
                'status' => $validated['status']
            ]);
            if ($asesorUpdate && $userUpdate) {
                DB::commit();
                return response()->json(['status' => 'success', 'message' => 'Data asesor berhasil diubah'], 200);
            } else {
                DB::rollBack();
                return response()->json(['status' => 'error', 'message' => 'Data asesor gagal diubah'], 500);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'Server Error 500'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($uuid)
    {
        try {
            DB::beginTransaction();
            $data = Asesor::with('user')->firstWhere('uuid',$uuid);
            if(empty($data)) {
                DB::rollBack();
                return response()->json(['status' => 'error', 'message' => 'Data asesor tidak ditemukan'], 404);
            }
            if($data['surat_tugas'] != null && Storage::exists($data['surat_tugas'])) {
                Storage::delete($data['surat_tugas']);
            }
            if($data->user['photo'] != null && Storage::exists($data->user['photo'])) {
                Storage::delete($data->user['photo']);
            }
            if($data->delete() && User::destroy($data['user_id'])) {
                DB::commit();
                return response()->json(['status' => 'success','message' => 'Data asesor berhasil dihapus'], 200);
            } else {
                DB::rollBack();
                return response()->json(['status' => 'error', 'message' => 'Data asesor gagal dihapus'], 500);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'Data asesor gagal dihapus'], 500);
        }
    }

    public function datatable()
    {
        $data = Asesor::with(['kelompokAsesor','user'])->latest()->get();
        return response()->json(['status' => 'success', 'data' => $data], 200);
    }

    public function list()
    {
        $data = Asesor::with(['kelompokAsesor','user'])->latest()->get();
        return response()->json(['status' => 'success', 'data' => $data], 200);
    }

    public function listByUUID($uuid)
    {
        $kelasId = Kelas::with('kelompokAsesor')
            ->where('uuid',$uuid)
            ->pluck('id');
        if(isset($kelasId)) {
            $result = KelompokAsesor::with(['asesor','kelas'])
            ->where('kelas_id', $kelasId)
            ->latest()
            ->get();
            return response()->json(['status' => 'success', 'data' => $result, 'totalRecord' => count($result)], 200);
        } else {
            return response()->json(['status' => 'success', 'message' => 'Data kelas tidak ditemukan'], 404);
        }
    }
}
