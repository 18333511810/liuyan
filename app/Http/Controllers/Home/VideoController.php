<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Stream;
class VideoController extends Controller
{
    //直播开始
    public function play(Request $request,Stream $stream){
    	//开始制作拉流地址；
    	//rtmp://pili-live-rtmp.www.hanguophp.cn/<Hub>/<StreamKey>
    	$space = 'zibo0001';
    	$url = 'rtmp://pili-live-rtmp.www.hanguophp.cn/'.$space.'/'.$stream->stream_name;
    	return view('home.video.play',compact('url'));
    }
}
