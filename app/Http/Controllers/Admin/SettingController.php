<?php

namespace App\Http\Controllers\Admin;

use App\Settings;
use App\TrainingVideos;
use App\Traits\Features;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;

class SettingController extends Controller

{

    use Features;
    public function index()
    {

        $setting = Settings::get();

        $features = $this->getfeatures();

        if (empty($features)) {

            return redirect('MyDashboard')->with('error', "Something went wrong");
        } else {

            return view('templates.myadmin.setting')->with(['settings' => $setting, 'allfeatures' => $features]);
        }
    }

    public function update(Request $request)
    {

        $setting = Settings::get();

        $this->validate(
            $request,
            [
                'contact' => 'required',
                'email' => 'required',
                'address' => 'required',
                'facebook' => 'required',
                'youtube' => 'required',
                'instagram' => 'required',
                'twitter' => 'required',

            ],
            [
                'contact.required' => 'add contact',
                'email.required' => 'add email',
                'address.required' => 'add address',
                'facebook.required' => 'add facebook',
                'youtube.required' => 'add youtube',
                'instagram.required' => 'add instagram',
                'twitter.required' => 'add twitter',
            ]
        );

        if ($setting->isNotEmpty()) {

            $setting = Settings::find($request->get('id'));
            $setting->contact = $request->contact;
            $setting->email = $request->email;
            $setting->address = $request->address;
            $setting->facebook = $request->facebook;
            $setting->youtube = $request->youtube;
            $setting->instagram = $request->instagram;
            $setting->twitter = $request->twitter;
            $setting->save();

            return redirect('setting')->with('success', 'Updated Successfully');
        } else {
            $this->validate(
                $request,
                [
                    'contact' => 'required',
                    'email' => 'required',
                    'address' => 'required',
                    'facebook' => 'required',
                    'youtube' => 'required',
                    'instagram' => 'required',
                    'twitter' => 'required',

                ],
                [
                    'contact.required' => 'add contact',
                    'email.required' => 'add email',
                    'address.required' => 'add address',
                    'facebook.required' => 'add facebook',
                    'youtube.required' => 'add youtube',
                    'instagram.required' => 'add instagram',
                    'twitter.required' => 'add twitter',
                ]
            );
            $setting = new Settings();
            $setting->contact = $request->contact;
            $setting->email = $request->email;
            $setting->address = $request->address;
            $setting->facebook = $request->facebook;
            $setting->youtube = $request->youtube;
            $setting->instagram = $request->instagram;
            $setting->twitter = $request->twitter;
            $setting->save();

            return redirect('setting')->with('success', 'Added Successfully');
        }
    }

    public function training_videos()
    {

        $videos = TrainingVideos::get();

        $features = $this->getfeatures();

        if (empty($features)) {

            return redirect('MyDashboard')->with('error', "Something went wrong");
        } else {

            return view('templates.myadmin.videos')->with(['videos' => $videos, 'allfeatures' => $features]);
        }
    }


    public function add_video()
    {

        $features = $this->getfeatures();

        if (empty($features)) {

            return redirect('MyDashboard')->with('error', "Something went wrong");
        } else {

            return view('templates.myadmin.add_video')->with(['allfeatures' => $features]);
        }
    }

    public function store_video(Request $request)
    {

        $video = new TrainingVideos();

        $this->validate(
            $request,
            [
                'video' => 'required|mimes:mp4,mov,avi,wmv|max:102400',
                'thumbnail' => 'required',
            ],
            [
                'video.required' => 'Please select a video file.',
                'thumbnail.required' => 'Please select a file.',
                'video.mimes' => 'Only MP4, MOV, AVI, or WMV files are allowed.',
                'video.max' => 'Video size must not exceed 100MB.',
            ]
        );

        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = public_path('images/training');
            $file->move($path, $filename);
            $video->thumbnail = $filename;

        }

        if ($request->hasFile('video')) {
            $file = $request->file('video');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = public_path('videos/training');
            $file->move($path, $filename);
            $video->video = $filename;

        }

        $video->save();
        return redirect('training_videos')->with('success', 'Updated Successfully');
    }


    public function delete_video($id)
    {
        $video = TrainingVideos::find($id);

        if ($video) {
            $path = public_path('videos/training/' . $video->video);

            // Delete the video from the folder

            try {
                if (file_exists($path)) {
                    unlink($path);
                }
            } catch (Exception $e) {

            }

            $video->delete();

            return redirect()->back()->with('success', 'Video deleted successfully!');
        } else {
            return redirect()->back()->with('error', 'Video not found!');
        }
    }
}
