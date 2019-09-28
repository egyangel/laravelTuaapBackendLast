<?php

namespace App\Http\Controllers;

use App\Events\ApplicationUpdatedByUser;
use Illuminate\Http\Request;
use App\MyApp;
use Image;
use Illuminate\Support\Str;
use Storage;

class MyAppController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $myapps = MyApp::all();
        return view('myapps.myapps' , compact('myapps'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('myapps.addnewapp');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $validator = validator()->make($data, [
            'appname'               => 'required|min:6',
            'logoapp'               => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'splash'                => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'appidentificationkey'  => 'required|unique:my_apps',
        ]);

        if (request()->hasFile('logoapp'))
        {
            $logo = request('logoapp');
            $logoapp_name = time() . '.' . request('logoapp')->getClientOriginalExtension();
            $public_path  = 'uploads/logo/' . $logoapp_name;
            Image::make($logo)->resize(200,200)->save($public_path);
        }else
        {
            $logoapp_name = 'logo.png';
        }


        if (request()->hasFile('splash'))
        {
            $splash = request('splash');
            $splash_name = time() . '.' . request('splash')->getClientOriginalExtension();
            $public_path = 'uploads/splash/' . $splash_name;
            Image::make($splash)->resize(200,200)->save($public_path);
        }else
        {
            $splash_name = 'splash.png';
        }

        // $data['appidentificationkey'] = Str::uuid();

        $data['appidentificationkey'] = $this->generateAppidentificationkey();
        $data['logoapp']  =  $logoapp_name;
        $data['splashscreen']   =  $splash_name;
        $myapp = MyApp::create($data);
        event(new ApplicationUpdatedByUser($myapp));

        return redirect('/myapp')->with('success', 'MyApp Created!');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $myapp = MyApp::find($id);
        return view('myapps.myapp' , compact('myapp'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $myapp   = MyApp::find($id);
        return view('myapps.editapp', compact('myapp'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $myapp = MyApp::find($id);
        $data = $request->all();
        $validator = validator()->make($data, [
            'appname'               => 'required|min:6',
            'logoapp'               => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'splash'                => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
            if (request()->hasFile('logoapp'))
            {
                if($myapp->logoapp !==  'logo.png'){
                    Storage::delete('logo/'. $myapp->logoapp);
                }
                $logo = request('logoapp');
                $logoapp_name = time() . '.' . request('logoapp')->getClientOriginalExtension();
                $public_path  = 'uploads/logo/' . $logoapp_name;
                Image::make($logo)->resize(200,200)->save($public_path);

                $data['logoapp']  =  $logoapp_name;
            }


            if (request()->hasFile('splash'))
            {
                if($myapp->splashscreen !==  'splash.png'){
                    Storage::delete('splash/'. $myapp->splashscreen);
                }
                $splash = request('splash');
                $splash_name = time() . '.' . request('splash')->getClientOriginalExtension();
                $public_path = 'uploads/splash/' . $splash_name;
                Image::make($splash)->resize(200,200)->save($public_path);

                $data['splashscreen']   =  $splash_name;
            }

        $myapp->update($data);
        return redirect('/myapp')->with('success', 'MyApp Created!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $myapp     = MyApp::find($id);
        if($myapp->logoapp !==  'logo.png'){
           Storage::delete('logo/'. $myapp->logoapp);
        }
        if($myapp->splashscreen !==  'splash.png'){
           Storage::delete('splash/'. $myapp->splashscreen);
        }

        $myapp->delete();
        return back() ;
    }


//////////////// Generate App Id Notification ////////////
    public function generateAppidentificationkey()
    {
        $record = MyApp::all()->last();

        if (empty($record)) {
            $nextAppidentificationkey = 11;
        }
        else {
            $x = $record->appidentificationkey;
            $x = $x + 1;
            $nextAppidentificationkey = $x;
        }
        return $nextAppidentificationkey;

    }

}
