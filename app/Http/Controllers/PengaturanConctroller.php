<?php

namespace App\Http\Controllers;

use App\Models\Pengaturan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\{DB,Storage};

class PengaturanConctroller extends Controller
{
    public function index()
    {
        $pengaturan = Pengaturan::first();
        return view('dashboard.pengaturan.index',compact('pengaturan'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'application_name' => ['required', 'string', 'max:255'],
            'application_short_name' => ['required','string','max:255'],
            'application_email' => ['required','email','max:255'],
            'application_contact' => ['required','string','max:20'],
            'application_footer' => ['required','string','max:255'],
            'application_prefix_title' => ['required','string','max:255'],
            'application_description' => ['required'],
            'instagram_account' => ['nullable','string','max:255'],
            'facebook_account' => ['nullable','string','max:255'],
            'whatsapp_account' => ['nullable','string','max:255'],
            'twitter_account' => ['nullable','string','max:255'],
            'youtube_account' => ['nullable','string','max:255'],
            'linkedin_account' => ['nullable','string','max:255'],
            'application_logo' => [
                'nullable',
                File::types(['jpg', 'jpeg','png'])
                    ->min('1kb')
                    ->max('2mb')
                ],
            'application_icon' => [
                'nullable',
                File::types(['ico'])
                    ->min('1kb')
                    ->max('1mb')
                ]
        ], $this->messageValidation());

        if ($validator->fails()) {
            return response()->json(['message' => $validator->messages(), 'errors' => $validator->errors()], 422);
        }
        $validated = $validator->validated();

        try {
            DB::beginTransaction();
            $logo = $request->file('application_logo');
            $favicon = $request->file('application_icon');
            $data = Pengaturan::first();

            if($logo && !empty($logo)) {
                if($data['application_logo'] != null && Storage::exists($data['application_logo'])) {
                    Storage::delete($data['application_logo']);
                }
                $validated['application_logo'] = $logo->store('logoWeb');
            }
            if($favicon && !empty($favicon)) {
                if($data['application_icon'] != null && Storage::exists($data['application_icon'])) {
                    Storage::delete($data['application_icon']);
                }
                $validated['application_icon'] = $favicon->store('faviconWeb');
            }
            $result = $data->update($validated);
            if($result) {
                DB::commit();
                return response()->json(['status' => 'success', 'message' => 'Pengaturan berhasil diubah'], 200);
            } else {
                DB::rollBack();
                return response()->json(['status' => 'error', 'message' => 'Pengaturan gagal diubah'], 500);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], 500);
        }
    }

    public function datatable()
    {
        $data = Pengaturan::first();
        return response()->json(['status' => 'success', 'data' => $data], 200);
    }

    public function deleteImage($type)
    {
            $image = $type === 'logo' ? 'logo' : 'favicon';
            $data = Pengaturan::first();

            if($image ==='logo') {
                if($data['application_logo'] != null && Storage::exists($data['application_logo'])) {
                    Storage::delete($data['application_logo']);
                    $result = $data->update([
                        'application_logo' => null
                    ]);
                }
            }
            if($image === 'favicon') {
                if($data['application_icon'] != null && Storage::exists($data['application_icon'])) {
                    Storage::delete($data['application_icon']);
                    $result = $data->update([
                        'application_icon' => null
                    ]);
                }
            }
        if($result) {
            return response()->json(['status' => 'success', 'message'=>'Data berhasil dihapus'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Data gagal dihapus'], 500);
        }
    }
}
