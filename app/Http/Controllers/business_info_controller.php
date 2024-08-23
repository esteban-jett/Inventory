<?php

namespace App\Http\Controllers;

use App\Models\business_info;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class business_info_controller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request,business_info $business_info)
{
    $request->validate([
        'businesslogo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'businessname' => 'required|string|max:255',
        'businessemail' => 'required|string|max:255',
        'businessphone' => 'required|integer',
        'businesstelephone' => 'required|integer',
        'businessfb' => 'required|string|max:255',
        'businessig' => 'required|string|max:255',
        'businessx' => 'required|string|max:255',
    ]);

    $data = $request->all();
    
    if ($request->hasFile('businesslogo')) {
        $image = $request->file('businesslogo');
        $path = $image->store('public/business_logos');
        $data['businesslogo'] = basename($path);
    }

    $business_info->businessname = $data['businessname'];
    $business_info->businessemail = $data['businessemail'];
    $business_info->businessphone = $data['businessphone'];
    $business_info->businesstelephone = $data['businesstelephone'];
    $business_info->businessfb = $data['businessfb'];
    $business_info->businessig = $data['businessig'];
    $business_info->businessx = $data['businessx'];

    return [
        'success' => (bool) $business_info->save()
    ];
}

    /**
     * Display the specified resource.
     */
    public function show(Request $request, business_info $business_info)
    {
        return $business_info->paginate(10);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(int $id, Request $request)
{
    $request->validate([
        'businesslogo' => 'nullable|string|max:255',
        'businessname' => 'string|max:255',
        'businessemail' => 'string|max:255',
        'businessphone' => 'integer',
        'businesstelephone' => 'integer',
        'businessfb' => 'string|max:255',
        'businessig' => 'string|max:255',
        'businessx' => 'string|max:255',
    ]);

    $business_info = business_info::findOrFail($id);
    $data = $request->all();

    if ($request->hasFile('businesslogo')) {
        // Delete the old image if it exists
        if ($business_info->businesslogo) {
            Storage::delete('public/business_logos/' . $business_info->businesslogo);
        }
        $image = $request->file('businesslogo');
        $path = $image->store('public/business_logos');
        $data['businesslogo'] = basename($path);
    }

    if (isset($data['businessname'])) {
        $business_info->businessname = $data['businessname'];
    }
    if (isset($data['businessemail'])) {
        $business_info->businessemail = $data['businessemail'];
    }
    if (isset($data['businessphone'])) {
        $business_info->businessphone = $data['businessphone'];
    }
    if (isset($data['businesstelephone'])) {
        $business_info->businesstelephone = $data['businesstelephone'];
    }
    if (isset($data['businessfb'])) {
        $business_info->businessfb = $data['businessfb'];
    }
    if (isset($data['businessig'])) {
        $business_info->businessig = $data['businessig'];
    }
    if (isset($data['businessx'])) {
        $business_info->businessx = $data['businessx'];
    }

    return [
        'success' => (bool) $business_info->save()
    ];
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id, business_info $business_info)
    {
        return [
            'success' => (bool) $business_info -> where('id', $id)->delete()
        ];
    }
}
