<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Requests\MediaRequest;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
   protected $path = "private/images/";


    public function store(MediaRequest $mediaRequest){



    $originalName = time().$mediaRequest->image->hashName();
    $image = $mediaRequest->image;


    Storage::putFileAs($this->path, $image, $originalName);


     $media = new Media();
    $media->name = $mediaRequest->name;
    $media->description = $mediaRequest->description;
    $media->image = $originalName;
    $media->type = $mediaRequest->type;
    $media->save();


/*     $media = Media::create([
        'name' => $mediaRequest->name,
        'description' => $mediaRequest->description,
        'image' => $originalName,
        'type' => $mediaRequest->type
    ]); */

    return response()->json(['message' => 'url created successfully' , 'status' => 'true','data'=> $media ],200);
    }

    public function show($id){
        $media = Media::where('id',$id)->first();

        if($media->count() <= 0){return response()->json(['message' => 'Undefined Media', 'status' => 'false'],404);}
        if(Storage::exists($this->path.$media->image)){

            $disk = Storage::disk('local');
            $url = $disk->temporaryUrl(
                $this->path.$media->image,
                 now()->addMinutes(10),

            );
            $data['media'] = $media;
            $data['url'] = $url;

            return response()->json(['message' => 'url created successfully' , 'status' => 'true', 'data' => $data ],200);
        }

    }


    public function index(Request $request) {

        $imageName = $request->path;
        if(Storage::exists($this->path.$imageName)){
            return Storage::download($this->path.$imageName);
        }

        return  response()->json(['message'=> 'url is expired!' , 'status' => 'false']);
    }


    public function list(){
        $medias = Media::paginate(10);
        return response()->json([
            'message'=>'listing medias' ,
            'status' => 'true' ,
            'data' => $medias]);
    }
}
