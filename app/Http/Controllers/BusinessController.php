<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class BusinessController extends Controller
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
    public function store(Request $request,Business $business_info)
{
    
    $data['user_id'] = auth()->id;
    $request->validate([
        'business_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'business_Name' => 'required|string|max:255',
        'business_Address' => 'required|string|max:255',
        'business_Contact_Number' => 'required|integer',
        'business_Email' => 'required|string|max:255',
        'business_SocialMedia' => 'required|string|max:255'
    ]);

    $data = $request->all();
    
    if ($request->hasFile('business_image')) {
        $image = $request->file('business_image');
        $path = $image->store('public/business_logos');
        $data['business_image'] = basename($path);
    }


    $business_info = new Business($data);

    // $business_info->business_Name = $data['business_image'];
    // $business_info->business_Address = $data['business_Address'];
    // $business_info->business_Contact_Number = $data['business_Contact_Number'];
    // $business_info->business_Email = $data['business_Email'];
    // $business_info->business_SocialMedia = $data['business_SocialMedia'];

    return [
        'success' => (bool) $business_info->save()
    ];
}

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Business $business_info)
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

    $business_info = Business::findOrFail($id);
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
    public function destroy(int $id, Business $business_info)
    {
        return [
            'success' => (bool) $business_info -> where('id', $id)->delete()
        ];
    }
}
