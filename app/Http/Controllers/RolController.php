<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//Agregamos los modelos de spatie roles y permisos, asi como tambien una fachada
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Iluminate\Support\Facades\DB;

class RolController extends Controller
{
    function __construct(){
        $this->middleware('permission:ver-rol | crear-rol | editar-rol | borrar-rol', ['only'=>['index']]);
        $this->middleware('permission:crear-rol', ['only'=>['create, store']]);
        $this->middleware('permission:editar-rol', ['only'=>['edit, update']]);
        $this->middleware('permission:borrar-rol', ['only'=>['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Hacemos referencia al modelo de roles de spatie
        $roles = Role::paginate(5);
        //nos devolvera una vista en la carpeta roles que se llama index
        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $permission = Permission::get();
        return view ('roles.crear', compact('permission'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Para guardar los datos ingresados en el formulario,
        $this->validate($request, ['name' => 'required', 'permission' => 'required']);
        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permission'));

        return redirect()->route('roles.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table('role_has_permissions')->where('role_has_permissions.role_id', $id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();
        return view('roles.editar', compact('role', 'permission', 'rolePermissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $this->validate($request, ['name' => 'required', 'permission' => 'required']);

        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();

        $role->syncPermissions($request->input('permission'));
        return redirect()->route('roles.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        DB::table('roles')->where('id', $id)->delete();
        return redirect()->route('roles.index');

    }
}
