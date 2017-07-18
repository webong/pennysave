<?php

namespace App\Services;

use App\Role;
use Illuminate\Support\HtmlString;

class RoleService
{

    public function select_roles($user_id, $current)
    {
        return $this->html_select_roles($user_id, $current);
    }

    public function html_select_roles($user_id, $current)
    {
        $select = $this->roles(null, $current);
        $select .= '<button type="button" name="update_role" class="btn btn-info btn-flat inline">Update</button>';
        $select .= '<input type="hidden" name="user" value="' . $user_id . '" />';
        return new HtmlString($select);
    }

    public function roles($external = null, $current = null)
    {
        $margin_right = (! is_null($external)) ? '' : 'margin-right-sm';
        $width_small = (! is_null($external)) ? 'width-full padding-extra' : 'width-contain';
        $role_select = (! is_null($external)) ? 'role_select[]' : 'role_select';
        $select = '<select name="' . $role_select . '" class="form-control types ' . $width_small .' '. $margin_right .'">';
        $select .= (! is_null($external)) ? '<option class="padding-left-md" value="none">Select Admin Type</option>' : '';
        foreach ($this->adminRoles() as $role) {
            $selected = ($role->id == $current || old('role_select') == $role->name) ? 'selected' : '';
            $select .= "<option class='padding-left-md' value='$role->name' $selected>$role->display_name</option>";
        }
        $select .= '</select>';
        return (! is_null($external)) ? new HtmlString($select) : $select;
    }

    public function getRole($idOrName)
    {
        return Role::where('id', $idOrName)->orWhere('name', $idOrName)->first();
    }

    public function getRoles()
    {
        return Role::all();
    }

    public function adminRoles()
    {
        return Role::where('name', '<>', 'user')->get();
    }
}
