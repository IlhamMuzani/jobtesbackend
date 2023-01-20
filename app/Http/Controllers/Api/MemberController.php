<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MemberController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'username' => 'required',
        ], [
            'username.required' => 'Username tidak boleh kosong!',
            'password.required' => 'Password tidak boleh kosong!',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return $this->response(FALSE, $error);
        }

        $username = $request->username;
        $password = $request->password;

        $user = User::where([
            ['username', $username],
            ['role', 'member']
        ])->first();
        if ($user) {
            if (password_verify($password, $user->password)) {
                return $this->response(TRUE, array('Berhasil login, Selamat Datang ' . $user->name), array($user));
            } else {
                return $this->response(FALSE, array('Username atau password tidak sesuai!'));
            }
        } else {
            return $this->response(FALSE, array('Pengguna tidak ditemukan!'));
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'nama' => 'required',
            'lahir' => 'required',
            'gender' => 'required|in:L,P',
            'alamat' => 'required',
            'password' => 'required|min:8|confirmed',
            'role' => ''
        ], [
            'username.required' => 'Username tidak boleh kosong!',
            'username.unique' => 'Username sudah digunakan!',
            'username.username' => 'Username yang dimasukan salah!',
            'nama.required' => 'Nama tidak boleh kosong!',
            'lahir.required' => 'Tanggal lahir harus ditambahkan!',
            'gender.required' => 'Jenis kelamin harus dipilih!',
            'gender.in' => 'Jenis kelamin yang dimasukan salah!',
            'alamat.required' => 'Alamat tidak boleh kosong!',
            'password.required' => 'Password tidak boleh kosong !',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return $this->response(FALSE, $error);
        }

        $dailyreport = User::create(array_merge($request->all(), [
            'password' => bcrypt($request->password)
        ]));

        if ($dailyreport) {
            return $this->response(TRUE, array('Berhasil menambahkan data member'));
        } else {
            return $this->response(FALSE, array('Gagal menambahkan data member'));
        }
    }

    public function detail($id)
    {
        $user = User::where([
            ['role', 'member'],
            ['id', $id],
        ])->first();

        if ($user) {
            return $this->response(TRUE, array('Berhasil menampilkan data'), array($user));
        } else {
            return $this->response(FALSE, array('Gagal menampilkan data!'));
        }
    }

    public function update_profil(Request $request, $id)
    {
        $data = User::where('id', $id)->first();

        if ($data->foto) {
            $validator = Validator::make($request->all(), [
                'username' => 'required|username|unique:users,username,' . $id,
                'nama' => 'required',
                'lahir' => 'required',
                'gender' => 'required|in:L,P',
                'alamat' => 'required',
            ], [
                'username.required' => 'Username tidak boleh kosong!',
                'username.unique' => 'Username sudah digunakan!',
                'username.username' => 'Username yang dimasukan salah!',
                'nama.required' => 'Nama tidak boleh kosong!',
                'lahir.required' => 'Tanggal lahir harus ditambahkan!',
                'gender.required' => 'Jenis kelamin harus dipilih!',
                'gender.in' => 'Jenis kelamin yang dimasukan salah!',
                'alamat.required' => 'Alamat tidak boleh kosong!',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'username' => 'required|unique:users',
                'nama' => 'required',
                'lahir' => 'required',
                'gender' => 'required|in:L,P',
                'alamat' => 'required',
            ], [
                'username.required' => 'Username tidak boleh kosong!',
                'username.unique' => 'Username sudah digunakan!',
                'username.username' => 'Username yang dimasukan salah!',
                'nama.required' => 'Nama tidak boleh kosong!',
                'lahir.required' => 'Tanggal lahir harus ditambahkan!',
                'gender.required' => 'Jenis kelamin harus dipilih!',
                'gender.in' => 'Jenis kelamin yang dimasukan salah!',
                'alamat.required' => 'Alamat tidak boleh kosong!',
            ]);
        }

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return $this->response(FALSE, $error);
        }

        $update = User::where('id', $id)->update([
            'username' => $request->username,
            'nama' => $request->nama,
            'lahir' => $request->lahir,
            'gender' => $request->gender,
            'alamat' => $request->alamat,
        ]);

        if ($update) {
            return $this->response(TRUE, array('Berhasil memperbarui Profile'));
        } else {
            return $this->response(FALSE, array('Gagal memperbarui Profile'));
        }
    }

    public function password(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:8|confirmed',
        ], [
            'password.required' => 'Password tidak boleh kosong!',
            'password.min' => 'Password minimal 8 karakter!',
            'password.confirmed' => 'Konfirmasi password tidak sesuai!',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return $this->response(FALSE, $error);
        }

        $update = User::where('id', $id)->update([
            'password' => bcrypt($request->password)
        ]);

        if ($update) {
            return $this->response(TRUE, array('Berhasil memperbarui Password'));
        } else {
            return $this->response(FALSE, array('Gagal memperbarui Password'));
        }
    }

    public function destroy($id)
    {
        $anak = User::where('id', $id)->first();

        if ($anak) {
            $anak->delete();
            return $this->response(TRUE, array('Berhasil menghapus data anak'));
        } else {
            return $this->response(FALSE, array('Gagal menghapus data anak!'));
        }
    }


    public function response($status, $message, $data = null)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ]);
    }
}
