<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{

    public function __construct(){
        $this->middleware('auth')->except(['show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
        return view('user.show')->with([
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        // 87
        abort_unless(Gate::allows('update', $user), 403);

        return view('user.edit')->with([
            'user'=>$user,
            'message_success' => Session::get('message_success'),
            'message_warning' => Session::get('message_warning')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, User $user)
    {

        // 87
        abort_unless(Gate::allows('update', $user), 403);

        // 73
        $request->validate([
            'motto' => 'required|min:3',
            'image' => 'mimes:jpeg,jpg,bmp,png,gif',
            // Khong validate about_me
        ]);

        if($request->image){
            $this->saveImages($request->image, $user->id);
        }

        $user->update([
            'motto'=>$request['motto'],
            'about_me'=>$request['about_me']
        ]);

        return redirect('/home')->with([
            'message_success'=> 'Your user profile was updated.'
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
        abort_unless(Gate::allows('delete', $user), 403);
    }


    // 73
    public function saveImages($imageInput, $user_id){
        $image = Image::make($imageInput);

        if($image->width() > $image->height()){
            // landcape image
            $image->widen(500)
                ->save(public_path() . "/img/users/" . $user_id . "_large.jpg")
                ->widen(300)->pixelate(12)
                ->save(public_path() . "/img/users/" . $user_id . "_pixelated.jpg");

            // T???o h??nh ???nh thumbnail
            // L???y l???i instance c???a h??nh ???nh t???i l??n
            $image = Image::make($imageInput);
            $image->widen(60)
                ->save(public_path() . '/img/users/' . $user_id . '_thumb.jpg');
        }else{
            // portrait image
            $image->heighten(500)
                ->save(public_path() . "/img/users/" . $user_id . "_large.jpg")
                ->heighten(300)->pixelate(12)
                ->save(public_path() . "/img/users/" . $user_id . "_pixelated.jpg");

            // T???o h??nh ???nh thumbnail
            // L???y l???i instance c???a h??nh ???nh t???i l??n
            $image = Image::make($imageInput);
            $image->heighten(60)
                ->save(public_path() . '/img/users/' . $user_id . '_thumb.jpg');
        }
    }

    public function deleteImages($user_id){
        // Delete large image
        if(file_exists(public_path() . "/img/users/" . $user_id . "_large.jpg")){
            unlink(public_path() . "/img/users/" . $user_id . "_large.jpg");
        }

        // Delete pixelated image
        if(file_exists(public_path() . "/img/users/" . $user_id . "_pixelated.jpg")){
            unlink(public_path() . "/img/users/" . $user_id . "_pixelated.jpg");
        }

        // Delete thumb image
        if(file_exists(public_path() . "/img/users/" . $user_id . "_thumb.jpg")){
            unlink(public_path() . "/img/users/" . $user_id . "_thumb.jpg");
        }

        // after deletion, return
        return back()->with([
            'message_success' => 'The image was deleted'
        ]);
    }


}
