<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menus = Menu::with('childs')->where('parent_id', null)->get();
        return view('menu.index', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parent_menus = Menu::where('parent_id', null)->get();

        return view('menu.create', compact('parent_menus'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string|min:2|max:50|unique:menus',
            'parent' => 'nullable|numeric',
            'link_url' => 'nullable'
        ]);

        $menu = new Menu();
        $menu->title = $request->title;
        $menu->parent_id = $request->parent ?? null;

        $menu->link_url = $request->link_url;

        $menu->save();

        session()->flash('status', 'Menu created successfully!');
        return redirect()->route('menu.index');
    }

    public function sortableMenu(Request $request)
    {
        if (!$request->sortable_menu) {
            session()->flash('status', 'Nothing changed!');
            return redirect()->back();
        }
        // Decode sortable menu
        $menus = json_decode($request->sortable_menu);

        // Delete old data
        Menu::truncate();

        foreach ($menus as $m) {
            // Store parent menu
            $menu = new Menu();
            $menu->title = $m->title;
            $menu->parent_id = null;
            $menu->link_url = $m->link_url ?? null;
            $menu->save();

            if (isset($m->children) && $m->children) {
                foreach ($m->children as $c) {
                    // Store child menu
                    $child = new Menu();
                    $child->title = $c->title;
                    $child->parent_id = $menu->id;
                    $child->link_url = $c->link_url ?? null;
                    $child->save();
                }
            }
        }

        session()->flash('status', 'Menu reordered successfully!');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show(Menu $menu)
    {
        if (request()->ajax()) {
            return response()->json(['menu' => $menu], 200);
        } else {
            abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $menu)
    {
        $parent_menus = Menu::where('parent_id', null)->get();

        return view('menu.edit', compact('menu', 'parent_menus'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Menu $menu)
    {
        $this->validate($request, [
            'title' => 'required|string|min:2|max:50|unique:menus,title,' . $menu->id,
            'parent' => 'nullable|numeric',
            'link_url' => 'nullable'
        ]);

        $menu->title = $request->title;
        $menu->parent_id = $request->parent ?? null;

        $menu->link_url = $request->link_url ?? '#';

        $menu->save();

        if ($request->ajax()) {
            return response()->json(['menu' => $menu], 200);
        }
        session()->flash('status', 'Menu updated successfully!');
        return redirect()->route('menu.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
    {
        $menu->delete();

        session()->flash('status', 'Menu deleted successfully!');
        return redirect()->route('menu.index');
    }
}