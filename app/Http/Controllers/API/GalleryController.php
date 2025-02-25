<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gallery;
use App\Models\GalleryAttachment;
use App\Models\GalleryType;
class GalleryController extends Controller
{
    // get gallery and attach galleryAttachment
    public function getGalleryWithAttachments()
    {
        $gallery = Gallery::with('attachments')->get();
        return response()->json($gallery);
    }
    // get GalleryAttachment with gallery and type
    public function getGalleryAttachmentWithGalleryNameAndType(Request $request, $type_id=0)
    {
        if($type_id == 0){
            $galleryAttachment = GalleryAttachment::with('gallery.type')->get();
        }else{
            $galleryAttachment = GalleryAttachment::whereHas('gallery', function($query) use ($type_id) {
                $query->where('type_id', $type_id);
            })->with('gallery.type')->get();
        }
        // set path to image
        $galleryAttachment->map(function($item){
            $item->path = url('/'.$item->path);
            // image
            $item->image = $item->path;
            return $item;
        });
        $data['galleryAttachment'] = $galleryAttachment;
        // get type status =1
        $data['galleryType'] = GalleryType::where('status', 1)->get();
        return response()->json(['status' => 200, 'data'=>$data]);
    }
    // GalleryAttachment with gallery name
    public function getGalleryAttachmentWithGalleryName()
    {
        // $galleryAttachment = GalleryAttachment::with('gallery')->limit(8)->get();
        // // set path to image
        // $galleryAttachment->map(function($item){
        //     $item->path = url('/'.$item->path);
        //     $item->gallery_title = $item->gallery->title;
        //     $item->gallery_description = $item->gallery->description;
        //     return $item;
        // });
        // return response()->json($galleryAttachment);
        
        
        // $galleries = Gallery::with(['attachments' => function ($query) {
        //     $query->orderBy('created_at', 'asc'); // Ensures first image is at the top
        // }])->get();
        
        // // Format the response
        // $formattedData = $galleries->map(function ($gallery) {
        //     $attachments = $gallery->attachments;
        
        //     return [
        //         'gallery_id' => $gallery->id,
        //         'gallery_title' => $gallery->title,
        //         'gallery_description' => $gallery->description,
        //         'path' => $attachments->isNotEmpty() ? url('/' . $attachments->first()->path) : null, // First attachment image
        //         'attachments' => $attachments->map(function ($attachment) {
        //             return [
        //                 'id' => $attachment->id,
        //                 'path' => url('/' . $attachment->path),
        //             ];
        //         }),
        //     ];
        // });
        // return response()->json($formattedData);
        $galleryTypes = Gallery::select('type_id')
            ->groupBy('type_id')
            ->get();
            
            
        $formattedData = $galleryTypes->map(function ($galleryType) {
            $firstGallery = Gallery::with(['attachments' => function ($query) {
                    $query->orderBy('created_at', 'asc'); // Get first image
                }])
                ->where('type_id', $galleryType->type_id)
                ->orderBy('created_at', 'asc') // Get the first gallery of that type
                ->first();
                
            return [
                'gallery_id' => $galleryType->type_id,
                'gallery_title' => $firstGallery->type ? $firstGallery->type->title : null,
                'gallery_id' => $firstGallery ? $firstGallery->id : null,
                'gallery_description' => $firstGallery ? $firstGallery->description : null,
                'path' => ($firstGallery && $firstGallery->attachments->isNotEmpty()) 
                    ? url('/' . $firstGallery->attachments->first()->path) 
                    : null, // First attachment image
            ];
        });

        return response()->json($formattedData);
    }

}
