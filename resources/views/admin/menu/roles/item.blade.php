<tr>
    <td class="text-xs px-4 py-3 whitespace-nowrap {{ ($is_child) ? 'pl-7 capitalize' : 'font-medium uppercase' }}">
        {{ $menu['name'] }}
    </td>
    @foreach ($roles as $role)
        <td class="text-center">
            <input type="checkbox" name="menu_rol[]"
            value="{{ $role['id'] }}"
            class="border-2 border-gray-300 rounded-md"
            {{in_array($role['id'], array_column($menuRoles[$menu["id"]], "id"))? "checked" : ""}}
            >
        </td>
    @endforeach
</tr>
@foreach ($menu['submenu'] as $key => $submenu)
    @include('admin.menu.roles.item', ['menu' => $submenu, 'is_child' => true])
@endforeach
