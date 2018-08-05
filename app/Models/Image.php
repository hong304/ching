<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\File;
use Storage;
use Cache;

class Image extends Model
{
	use SoftDeletes;
	/*
	 * ============================================================================================================================================
	 * Settings
	 * ============================================================================================================================================
	 */
	public $incrementing = false;  // cannot use auto increment as might get collisions - don't worry, an event listener makes one automatically
	protected $dates = [
		'created_at',
		'updated_at',
		'last_touch_at',
		'deleted_at'
	];
	
	/*
	 * ============================================================================================================================================
	 * Relationships
	 * ============================================================================================================================================
	 */
	
	public function recipe()
	{
		return $this->hasOne('App\Models\Recipe');
	}
	
	public function video()
	{
		return $this->hasOne('App\Models\Video');
	}
	
	public function blog()
	{
		return $this->hasOne('App\Models\Blog');
	}
	
	public function newsletter()
	{
		return $this->hasOne('App\Models\Newsletter');
	}
	
	public function edmBlogImage()
	{
		return $this->hasOne('App\Models\RegularEDM');
	}
	
	public function edmInstagramImage1()
	{
		return $this->hasOne('App\Models\RegularEDM');
	}
	
	public function edmInstagramImage2()
	{
		return $this->hasOne('App\Models\RegularEDM');
	}
	
	public function edmInstagramImage3()
	{
		return $this->hasOne('App\Models\RegularEDM');
	}
	
	public function edmInstagramImage4()
	{
		return $this->hasOne('App\Models\RegularEDM');
	}
	
	public function edmRecipeImage()
	{
		return $this->hasOne('App\Models\RegularEDM', 'recipe_image_id');
	}
	
	/*
	 * ============================================================================================================================================
	 * Custom getters / setters
	 * ============================================================================================================================================
	 */
	
	// get the url of the image on CDN or local machine (usually used in a view)
	public function url($image = false, $size = 'original')
	{
		
		
		if ($image == false) $image = $this;
		
		// change from SQL query every touch to caching last touch and scheduled job writes to
		// DB every 5 minutes
		$touch_arr = Cache::get('image_touches');
		if ($touch_arr === null) $touch_arr = [];
		$touch_arr[$image->id] = time();
		Cache::put('image_touches', $touch_arr, 30);
		
		if (app()->environment() !== 'production') {
			return Storage::url($image->sub_dir . '/' . $image->file_name);
		} else {
			
			if (request()->secure()) {
				$pre = config('cdn.https');
			} else {
				$pre = config('cdn.http');
			}
			return $pre . '/img/' . $size . '/' . $image->file_name;
			
		}
		
	}
	
	
	/*
	 * ============================================================================================================================================
	 * STATIC HELPERS BELOW (useful in views)
	 * ============================================================================================================================================
	 */
	
	// convenience for views mostly without having to load the image model
	static public function imgUrl($image_id, $size = 'original')
	{
		
		if ($image = Image::find($image_id)) {
			return $image->url($image, $size);
		} else {
			return 'image_not_found'; // TODO send back a URL of a placeholder non-found image
		}
		
	}
	
	static public function newImageToCDN($filename, $folder = '')
	{
		if ($folder == '') $folder = date('Y');
		
		
		$image = new Image();
		$data = getimagesize($filename);
		$image->sub_dir = $folder;
		$image->name = "";
		$image->width = $data[0];
		$image->height = $data[1];
		if (is_string($filename)) {
			$info = pathinfo($filename);
			$image->file_name = strtolower(str_random(16)) . '.' . $info['extension'];
			$filename = new \Illuminate\Http\File($filename);
		} else {
			$image->file_name = strtolower(str_random(16)) . '.' . $filename->getClientOriginalExtension();
		}
		$image->save();
		
		// get extension and mame lowercase - jpeg, png
		
		if (app()->environment() !== 'production') {
			$disk = Storage::disk('public');
		} else {
			$disk = Storage::disk('origin');
		}
		
		if ($disk->putFileAs($folder, $filename, $image->file_name)) {
			$image->save();
			return $image->id;
		} else {
			return false;
		}
		
		
	}
	
	static public function resizeAndSaveImageToCDN($file, $width = null, $height = null)
	{
		if (!$width && !$height)
			return false;
		
		$temp_image = \Images::make($file)->resize($width, $height, function ($constraint) {
			$constraint->aspectRatio();
		});
		
		$image_name = strtolower(str_random(16)) . '.' . $file->getClientOriginalExtension();
		$temp_image->save(public_path('images/' . $image_name));
		
		$saved_image_uri = $temp_image->dirname . '/' . $temp_image->basename;
		
		
		$folder = date('Y');
		if (app()->environment() !== 'production') {
			$disk = Storage::disk('public');
		} else {
			$disk = Storage::disk('origin');
		}
		
		$image = new Image();
		$image->sub_dir = $folder;
		$image->name = "";
		$image->width = $temp_image->width();
		$image->height = $temp_image->height();
		$image->file_name = $image_name;
		
		if ($disk->putFileAs($folder, new \Illuminate\Http\File($saved_image_uri), $image_name)) {
			$image->save();
			//Delete temporary intervention image as we have moved it to filesystem.
			$temp_image->destroy();
			unlink($saved_image_uri);
			return $image->id;
		} else {
			return false;
		}
	}
	
}
