<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::withCount('products')->orderBy('name')->paginate(30);

        return view('tenant.categories.index', compact('categories'));
    }

    public function store(Request $request): mixed
    {
        $tenantId = auth()->user()->tenant_id;

        $request->validate([
            'name' => [
                'required', 'string', 'max:255',
                Rule::unique('categories')->where('tenant_id', $tenantId),
            ],
            'parent_id' => ['nullable', 'exists:categories,id'],
        ], [
            'name.unique' => 'Ya existe una categoría con ese nombre.',
        ]);

        $category = Category::create($request->only('name', 'parent_id'));

        if ($request->expectsJson()) {
            return response()->json(['id' => $category->id, 'name' => $category->name]);
        }

        return back()->with('success', 'Categoría creada correctamente.');
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $tenantId = auth()->user()->tenant_id;

        $request->validate([
            'name' => [
                'required', 'string', 'max:255',
                Rule::unique('categories')->where('tenant_id', $tenantId)->ignore($category->id),
            ],
        ], [
            'name.unique' => 'Ya existe una categoría con ese nombre.',
        ]);

        $category->update(['name' => $request->name]);

        return back()->with('success', 'Categoría actualizada.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        if ($category->products()->exists()) {
            return back()->withErrors(['delete' => 'No puedes eliminar una categoría con productos asignados.']);
        }

        if ($category->children()->exists()) {
            return back()->withErrors(['delete' => 'No puedes eliminar una categoría con subcategorías.']);
        }

        $category->delete();

        return back()->with('success', 'Categoría eliminada.');
    }
}
