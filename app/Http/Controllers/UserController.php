<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\User;
use App\Models\Privilege;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (Auth::user()->id_priv == 1) {
            $data = User::all();
            $priv = Privilege::all();

            $log = new Log;
            $log->id_user = Auth::user()->id;
            $log->aktivitas = 'Mengakses halaman pengguna';
            $log->save();

            return view('user.index', compact('data', 'priv'));
        } else {
            return redirect()->back()->with('error', 'Maaf, anda tidak memiliki akses.');
        }
    }

    public function store(Request $request)
    {
        if (Auth::user()->id_priv == 1) {
            $request->validate([
                'name' => 'required|string|max:255|unique:users',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
                'nama_lengkap' => 'required|string|max:255',
                'no_telp' => 'required|string|max:13',
                'alamat' => 'required|string',
                'id_priv' => 'required|exists:priv,id_priv',
                'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ], [
                'name.required' => 'Username wajib diisi',
                'name.unique' => 'Username sudah digunakan',
                'email.required' => 'Email wajib diisi',
                'email.email' => 'Format email tidak valid',
                'email.unique' => 'Email sudah digunakan',
                'password.required' => 'Password wajib diisi',
                'password.min' => 'Password minimal 8 karakter',
                'nama_lengkap.required' => 'Nama lengkap wajib diisi',
                'no_telp.required' => 'Nomor telepon wajib diisi',
                'no_telp.max' => 'Nomor telepon maksimal 13 karakter',
                'alamat.required' => 'Alamat wajib diisi',
                'id_priv.required' => 'Hak akses wajib dipilih',
                'id_priv.exists' => 'Hak akses tidak valid',
                'foto.required' => 'Foto wajib diupload',
                'foto.image' => 'File harus berupa gambar',
                'foto.mimes' => 'Format foto harus jpeg, png, atau jpg',
                'foto.max' => 'Ukuran foto maksimal 2MB',
            ]);

            $file = $request->foto;
            if ($file != null) {
                $extension = $file->getClientOriginalExtension();
                $mimetype = $file->getClientMimeType();
                $filegambar = $file->getFilename().'.'.$extension;
                Storage::disk('public')->put('/gambar/profil/'.$file->getFilename().'.'.$extension, File::get($file));
            } else {
                $filegambar = null;
            }

            $user = new User;
            $user->name = $request->name;
            $user->nama_lengkap = $request->nama_lengkap;
            $user->email = $request->email;
            $user->no_telp = $request->no_telp;
            $user->alamat = $request->alamat;
            $user->password = bcrypt($request->password);
            $user->id_priv = $request->id_priv;
            if ($filegambar != null) {
                $user->foto = $filegambar;
            }
            $user->save();
            
            $log = new Log;
            $log->id_user = Auth::user()->id;
            $log->aktivitas = 'Menambahkan user';
            $log->save();

            return redirect('/user')->with('success', 'User berhasil ditambahkan.');
        } else {
            return redirect()->back()->with('error', 'Maaf, anda tidak memiliki akses.');
        }
    }

    public function update(Request $request)
    {
        if (Auth::user()->id_priv == 1) {
            $request->validate([
                'name' => 'required|string|max:255|unique:users,name,'.$request->id,
                'email' => 'required|string|email|max:255|unique:users,email,'.$request->id,
                'nama_lengkap' => 'required|string|max:255',
                'no_telp' => 'required|string|max:13',
                'alamat' => 'required|string',
                'id_priv' => 'required|exists:priv,id_priv',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ], [
                'name.required' => 'Username wajib diisi',
                'name.unique' => 'Username sudah digunakan',
                'email.required' => 'Email wajib diisi',
                'email.email' => 'Format email tidak valid',
                'email.unique' => 'Email sudah digunakan',
                'nama_lengkap.required' => 'Nama lengkap wajib diisi',
                'no_telp.required' => 'Nomor telepon wajib diisi',
                'no_telp.max' => 'Nomor telepon maksimal 13 karakter',
                'alamat.required' => 'Alamat wajib diisi',
                'id_priv.required' => 'Hak akses wajib dipilih',
                'id_priv.exists' => 'Hak akses tidak valid',
                'foto.image' => 'File harus berupa gambar',
                'foto.mimes' => 'Format foto harus jpeg, png, atau jpg',
                'foto.max' => 'Ukuran foto maksimal 2MB',
            ]);

            $file = $request->foto;
            if ($file != null) {
                $extension = $file->getClientOriginalExtension();
                $mimetype = $file->getClientMimeType();
                $filegambar = $file->getFilename().'.'.$extension;
                Storage::disk('public')->put('/gambar/profil/'.$file->getFilename().'.'.$extension, File::get($file));
            } else {
                $filegambar = null;
            }
            
            if ($request->foto) {
                Storage::delete('public/gambar/profil/'.$request->foto_lama);
            }

            $user = User::find($request->id);
            $user->name = $request->name;
            $user->nama_lengkap = $request->nama_lengkap;
            $user->email = $request->email;
            $user->no_telp = $request->no_telp;
            $user->alamat = $request->alamat;
            $user->id_priv = $request->id_priv;
            if ($filegambar != null) {
                $user->foto = $filegambar;
            }
            $user->save();

            $log = new Log;
            $log->id_user = Auth::user()->id;
            $log->aktivitas = 'Memperbarui user '.$request->name;
            $log->save();

            return redirect('/user')->with('success', 'User berhasil diperbarui.');
        } else {
            return redirect()->back()->with('error', 'Maaf, anda tidak memiliki akses.');
        }
    }

    public function updatePassword(Request $request)
    {
        if (Auth::user()->id_priv == 1) {
            $request->validate([
                'password' => 'required|string|min:8',
            ], [
                'password.required' => 'Password wajib diisi',
                'password.min' => 'Password minimal 8 karakter',
            ]);

            $user = User::find($request->id);
            $user->password = bcrypt($request->password);
            $user->save();

            $log = new Log;
            $log->id_user = Auth::user()->id;
            $log->aktivitas = 'Memperbarui password user '.$request->name;
            $log->save();

            return redirect('/user')->with('success', 'Password user berhasil diperbarui.');
        } else {
            return redirect()->back()->with('error', 'Maaf, anda tidak memiliki akses.');
        }
    }

    public function destroy($id)
    {
        if (Auth::user()->id_priv == 1) {
            $user = User::where('id', $id)->first();
            Storage::delete('public/gambar/profil/'.$user->foto);
            
            $log = new Log;
            $log->id_user = Auth::user()->id;
            $log->aktivitas = 'Menghapus user '.$user->name;
            $log->save();

            $user->delete();
            
            return redirect('/user')->with('success', 'User berhasil dihapus.');
        } else {
            return redirect()->back()->with('error', 'Maaf, anda tidak memiliki akses.');
        }
    }

    public function profil()
    {
        $user = Auth::user();
        return view('user.profil', compact('user'));
    }

    public function updateProfil(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:users,name,'.Auth::id(),
            'email' => 'required|string|email|max:255|unique:users,email,'.Auth::id(),
            'nama_lengkap' => 'required|string|max:255',
            'no_telp' => 'required|string|max:13',
            'alamat' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'password' => 'nullable|string|min:8',
        ], [
            'name.required' => 'Username wajib diisi',
            'name.unique' => 'Username sudah digunakan',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah digunakan',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi',
            'no_telp.required' => 'Nomor telepon wajib diisi',
            'no_telp.max' => 'Nomor telepon maksimal 13 karakter',
            'alamat.required' => 'Alamat wajib diisi',
            'foto.image' => 'File harus berupa gambar',
            'foto.mimes' => 'Format foto harus jpeg, png, atau jpg',
            'foto.max' => 'Ukuran foto maksimal 2MB',
            'password.min' => 'Password minimal 8 karakter',
        ]);

        $file = $request->foto;
        if ($file != null) {
            $extension = $file->getClientOriginalExtension();
            $mimetype = $file->getClientMimeType();
            $filegambar = $file->getFilename().'.'.$extension;
            Storage::disk('public')->put('/gambar/profil/'.$file->getFilename().'.'.$extension, File::get($file));
        } else {
            $filegambar = null;
        }
        
        if ($request->foto) {
            Storage::delete('public/gambar/profil/'.$request->foto_lama);
        }

        $user = Auth::user();
        $user->name = $request->name;
        $user->nama_lengkap = $request->nama_lengkap;
        $user->email = $request->email;
        $user->no_telp = $request->no_telp;
        $user->alamat = $request->alamat;
        if ($filegambar != null) {
            $user->foto = $filegambar;
        }
        if (!empty($request->password)) {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        $log = new Log;
        $log->id_user = $user->id;
        $log->aktivitas = 'Memperbarui profil';
        $log->save();

        return redirect('/user/profil')->with('success', 'Profil berhasil diperbarui.');
    }

    public function updateProfilPass(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8',
        ], [
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 8 karakter',
        ]);

        $user = Auth::user();
        $user->password = bcrypt($request->password);
        $user->save();

        $log = new Log;
        $log->id_user = $user->id;
        $log->aktivitas = 'Mengganti password';
        $log->save();

        return redirect('/user/profil')->with('success', 'Password berhasil diganti.');
    }
} 