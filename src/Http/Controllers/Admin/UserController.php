<?php

namespace Dealskoo\User\Http\Controllers\Admin;

use Dealskoo\User\Models\User;
use Dealskoo\Admin\Http\Controllers\Controller as AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends AdminController
{
    public function index(Request $request)
    {
        abort_if(!$request->user()->canDo('users.index'), 403);
        if ($request->ajax()) {
            return $this->table($request);
        } else {
            return view('user::admin.user.index');
        }
    }

    private function table(Request $request)
    {
        $start = $request->input('start', 0);
        $limit = $request->input('length', 10);
        $keyword = $request->input('search.value');
        $columns = ['id', 'name', 'slug', 'email', 'country_id', 'source', 'status', 'created_at', 'updated_at'];
        $column = $columns[$request->input('order.0.column', 0)];
        $desc = $request->input('order.0.dir', 'desc');
        $query = User::query();
        if ($keyword) {
            $query->where('name', 'like', '%' . $keyword . '%');
            $query->orWhere('slug', 'like', '%' . $keyword . '%');
            $query->orWhere('email', 'like', '%' . $keyword . '%');
        }
        $query->orderBy($column, $desc);
        $count = $query->count();
        $users = $query->skip($start)->take($limit)->get();
        $rows = [];
        $can_view = $request->user()->canDo('users.show');
        $can_edit = $request->user()->canDo('users.edit');
        $can_login = $request->user()->canDo('users.login');
        foreach ($users as $user) {
            $row = [];
            $row[] = $user->id;
            $row[] = '<img src="' . $user->avatar_url . '" alt="' . $user->name . '" title="' . $user->name . '" class="me-2 rounded-circle"><p class="m-0 d-inline-block align-middle font-16">' . $user->name . '</p>';
            $row[] = $user->slug;
            $row[] = $user->email;
            $row[] = $user->country->name;
            $row[] = $user->source;
            $row[] = $user->status ? '<span class="badge bg-success">' . __('user::user.active') . '</span>' : '<span class="badge bg-danger">' . __('user::user.inactive') . '</span>';
            $row[] = $user->created_at->format('Y-m-d H:i:s');
            $row[] = $user->updated_at->format('Y-m-d H:i:s');

            $login_link = '';
            if ($can_login) {
                $login_link = '<a href="' . route('admin.users.login', $user) . '" class="action-icon" target="_blank"><i class="mdi mdi-view-dashboard"></i></a>';
            }

            $view_link = '';
            if ($can_view) {
                $view_link = '<a href="' . route('admin.users.show', $user) . '" class="action-icon"><i class="mdi mdi-eye"></i></a>';
            }

            $edit_link = '';
            if ($can_edit) {
                $edit_link = '<a href="' . route('admin.users.edit', $user) . '" class="action-icon"><i class="mdi mdi-square-edit-outline"></i></a>';
            }
            $row[] = $login_link . $view_link . $edit_link;
            $rows[] = $row;
        }
        return [
            'draw' => $request->draw,
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
            'data' => $rows
        ];
    }

    public function show(Request $request, $id)
    {
        abort_if(!$request->user()->canDo('users.show'), 403);
        $user = User::query()->findOrFail($id);
        return view('user::admin.user.show', ['user' => $user]);
    }

    public function edit(Request $request, $id)
    {
        abort_if(!$request->user()->canDo('users.edit'), 403);
        $user = User::query()->findOrFail($id);
        return view('user::admin.user.edit', ['user' => $user]);
    }

    public function update(Request $request, $id)
    {
        abort_if(!$request->user()->canDo('users.edit'), 403);
        $user = User::query()->findOrFail($id);
        $user->status = $request->boolean('status', false);
        $user->save();
        return back()->with('success', __('admin::admin.update_success'));
    }

    public function login(Request $request, $id)
    {
        abort_if(!$request->user()->canDo('users.login'), 403);
        $user = User::query()->findOrFail($id);
        Auth::guard('user')->login($user);
        return redirect(route('user.dashboard'));
    }
}
