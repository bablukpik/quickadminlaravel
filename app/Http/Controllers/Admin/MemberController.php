<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Redirect;
use Schema;
use App\Member;
use App\Http\Requests\CreateMemberRequest;
use App\Http\Requests\UpdateMemberRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\FileUploadTrait;


class MemberController extends Controller {

	/**
	 * Display a listing of member
	 *
     * @param Request $request
     *
     * @return \Illuminate\View\View
	 */
	public function index(Request $request)
    {
        $member = Member::all();

		return view('admin.member.index', compact('member'));
	}

	/**
	 * Show the form for creating a new member
	 *
     * @return \Illuminate\View\View
	 */
	public function create()
	{
	    
	    
	    return view('admin.member.create');
	}

	/**
	 * Store a newly created member in storage.
	 *
     * @param CreateMemberRequest|Request $request
	 */
	public function store(CreateMemberRequest $request)
	{
	    $request = $this->saveFiles($request);
		Member::create($request->all());

		return redirect()->route('admin.member.index');
	}

	/**
	 * Show the form for editing the specified member.
	 *
	 * @param  int  $id
     * @return \Illuminate\View\View
	 */
	public function edit($id)
	{
		$member = Member::find($id);
	    
	    
		return view('admin.member.edit', compact('member'));
	}

	/**
	 * Update the specified member in storage.
     * @param UpdateMemberRequest|Request $request
     *
	 * @param  int  $id
	 */
	public function update($id, UpdateMemberRequest $request)
	{
		$member = Member::findOrFail($id);

        $request = $this->saveFiles($request);

		$member->update($request->all());

		return redirect()->route('admin.member.index');
	}

	/**
	 * Remove the specified member from storage.
	 *
	 * @param  int  $id
	 */
	public function destroy($id)
	{
		Member::destroy($id);

		return redirect()->route('admin.member.index');
	}

    /**
     * Mass delete function from index page
     * @param Request $request
     *
     * @return mixed
     */
    public function massDelete(Request $request)
    {
        if ($request->get('toDelete') != 'mass') {
            $toDelete = json_decode($request->get('toDelete'));
            Member::destroy($toDelete);
        } else {
            Member::whereNotNull('id')->delete();
        }

        return redirect()->route('admin.member.index');
    }

}
