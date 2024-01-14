<?php
/**
 * Controller genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\Http\Controllers\LA;

use App\Helpers\ThumbnailCreator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
use DB;
use Validator;
use Yajra\DataTables\Datatables;
use Collective\Html\FormFacade as Form;
use Dwij\Laraadmin\Models\Module;
use Dwij\Laraadmin\Models\ModuleFields;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Intervention\Image\Facades\Image;
use App\Models\Attachment;

class AttachmentsController extends Controller
{
	public $show_action = true;
	public $view_col = 'customer_id';
	public $listing_cols = ['id', 'customer_id', 'attachment_name', 'attachment'];

	public function __construct() {
		// Field Access of Listing Columns
		if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() >= 5.3) {
			$this->middleware(function ($request, $next) {
				$this->listing_cols = ModuleFields::listingColumnAccessScan('Attachments', $this->listing_cols);
				return $next($request);
			});
		} else {
			$this->listing_cols = ModuleFields::listingColumnAccessScan('Attachments', $this->listing_cols);
		}
		$this->middleware('permission:Attachments-view|Attachments-create|Attachments-edit|Attachments-delete', ['only' => ['index','show']]);
		$this->middleware('permission:Attachments-create', ['only' => ['create','store']]);
		$this->middleware('permission:Attachments-edit', ['only' => ['edit','update']]);
		$this->middleware('permission:Attachments-delete', ['only' => ['destroy']]);
	}

	/**
	 * Display a listing of the Attachments.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$module = Module::get('Attachments');

		if(Module::hasAccess("Attachments", "view")) {
			return View('la.attachments.index', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'module' => $module
			]);
		} else {
            return redirect(config('laraadmin.adminRoute')."/");
        }
	}

	/**
	 * Show the form for creating a new attachment.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created attachment in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if(Module::hasAccess("Attachments", "create")) {

			$rules = Module::validateRules("Attachments", $request);

			$validator = Validator::make($request->all(), $rules);

			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}

			$insert_id = Module::insert("Attachments", $request);

			return redirect()->back();

		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	public function storeAjax(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'attachment_name' => 'required',
            'attachment_file' => 'required|mimes:jpeg,png,pdf|max:2048',
            'customer_id' => 'required',
        ], [
            'attachment_name.required' => 'حقل اسم المرفق مطلوب',
            'attachment_file.required' => 'حقل الملف المرفق مطلوب',
            'attachment_file.mimes' => 'يجب أن يكون الملف المرفق من نوع jpeg، png، أو pdf',
            'attachment_file.max' => 'حجم الملف المرفق لا يجب أن يتجاوز 2048 كيلوبايت',
            'customer_id.required' => 'حقل معرّف الزبون مطلوب',
        ]);


        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $attachment = new Attachment();
        $attachment->attachment_name = $request->input('attachment_name');
        $attachment->customer_id = $request->input('customer_id');


        if ($request->hasFile('attachment_file')) {
            $file = $request->file('attachment_file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $fileName);
            $attachment->attachment = 'uploads/' . $fileName;
			ThumbnailCreator::createThumbnail(public_path('uploads/' . $fileName), public_path('uploads/thumbnails/' . $fileName), 100, 100);

        }

        $attachment->save();

        return response()->json(['message' => 'Attachment uploaded successfully','attachment_id'=>$attachment->id], 200);
    }

	public function deleteAjax(Request $request)
	{
		$attachmentId = $request->input('attachmentId');


        $attachment = Attachment::find($attachmentId);

        if (!$attachment) {

            return response()->json(['message' => 'Attachment not found'], 404);
        }


        $attachment->delete();

        return response()->json(['message' => 'Attachment deleted successfully']);
	}


	private function createThumbnail($sourceFile, $destinationFile, $maxWidth, $maxHeight)
    {
		list($width, $height, $imageType) = getimagesize($sourceFile);

		// Determine the image type and create an image resource accordingly
		switch ($imageType) {
			case IMAGETYPE_JPEG:
				$sourceImage = imagecreatefromjpeg($sourceFile);
				break;
			case IMAGETYPE_PNG:
				$sourceImage = imagecreatefrompng($sourceFile);
				break;
			case IMAGETYPE_GIF:
				$sourceImage = imagecreatefromgif($sourceFile);
				break;
			// Add support for other image types if needed
			default:
				throw new \Exception('Unsupported image type');
		}

		$thumbWidth = $width;
		$thumbHeight = $height;

		if ($width > $maxWidth) {
			$thumbWidth = $maxWidth;
			$thumbHeight = intval($height * ($maxWidth / $width));
		}

		if ($height > $maxHeight) {
			$thumbHeight = $maxHeight;
			$thumbWidth = intval($width * ($maxHeight / $height));
		}

		$thumbnail = imagecreatetruecolor($thumbWidth, $thumbHeight);


		if ($imageType === IMAGETYPE_PNG || $imageType === IMAGETYPE_GIF) {
			imagecolortransparent($thumbnail, imagecolorallocatealpha($thumbnail, 0, 0, 0, 127));
			imagealphablending($thumbnail, false);
			imagesavealpha($thumbnail, true);
		}

		imagecopyresized($thumbnail, $sourceImage, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $width, $height);


		switch ($imageType) {
			case IMAGETYPE_JPEG:
				imagejpeg($thumbnail, $destinationFile, 90);
				break;
			case IMAGETYPE_PNG:
				imagepng($thumbnail, $destinationFile);
				break;
			case IMAGETYPE_GIF:
				imagegif($thumbnail, $destinationFile);
				break;

		}

		imagedestroy($sourceImage);
		imagedestroy($thumbnail);
    }

	/**
	 * Display the specified attachment.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		if(Module::hasAccess("Attachments", "view")) {

			$attachment = Attachment::find($id);
			if(isset($attachment->id)) {
				$module = Module::get('Attachments');
				$module->row = $attachment;

				return view('la.attachments.show', [
					'module' => $module,
					'view_col' => $this->view_col,
					'no_header' => true,
					'no_padding' => "no-padding"
				])->with('attachment', $attachment);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("attachment"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Show the form for editing the specified attachment.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		if(Module::hasAccess("Attachments", "edit")) {
			$attachment = Attachment::find($id);
			if(isset($attachment->id)) {
				$module = Module::get('Attachments');

				$module->row = $attachment;

				return view('la.attachments.edit', [
					'module' => $module,
					'view_col' => $this->view_col,
				])->with('attachment', $attachment);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("attachment"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Update the specified attachment in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		if(Module::hasAccess("Attachments", "edit")) {

			$rules = Module::validateRules("Attachments", $request, true);

			$validator = Validator::make($request->all(), $rules);

			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();;
			}

			$insert_id = Module::updateRow("Attachments", $request, $id);

			return redirect()->route(config('laraadmin.adminRoute') . '.attachments.index');

		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Remove the specified attachment from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(Module::hasAccess("Attachments", "delete")) {
			Attachment::find($id)->delete();

			// Redirecting to index() method
			return redirect()->route(config('laraadmin.adminRoute') . '.attachments.index');
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Datatable Ajax fetch
	 *
	 * @return
	 */
	public function dtajax()
	{
		$values = DB::table('attachments')->select($this->listing_cols)->whereNull('deleted_at');
		$out = Datatables::of($values->orderBy('id','desc'))->addColumn('action', function ($user) {
			return '';
		})->make();
		$data = $out->getData();

		$fields_popup = ModuleFields::getModuleFields('Attachments');

		for($i=0; $i < count($data->data); $i++) {
			for ($j=0; $j < count($this->listing_cols); $j++) {
				$col = $this->listing_cols[$j];

				if($fields_popup[$col] != null && Str::startsWith($fields_popup[$col]->popup_vals, "@")) {
					$data->data[$i]->$col = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i]->$col);
				}
				if($col == $this->view_col) {
					$data->data[$i]->$col = '<a href="'.url(config('laraadmin.adminRoute') . '/attachments/'.$data->data[$i]->id).'">'.$data->data[$i]->$col.'</a>';
				}

				// else if($col == "author") {
				//    $data->data[$i]->$col;
				// }
			}

			if($this->show_action) {
				$output = '';
				if(Module::hasAccess("Attachments", "edit")) {
					$output .= '<a href="'.url(config('laraadmin.adminRoute') . '/attachments/'.$data->data[$i]->id.'/edit').'" class="btn btn-warning btn-xs" style=""><i class="fa fa-edit"></i></a>';
				}

				if(Module::hasAccess("Attachments", "delete")) {
					$output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.attachments.destroy', $data->data[$i]->id], 'method' => 'delete', 'style'=>'display:inline']);
					$output .= ' <button class="btn btn-danger deleteFormBtn btn-xs" type="submit"><i class="fa fa-times"></i></button>';
					$output .= Form::close();
				}
				$data->data[$i]->action = (string)$output;
			}
		$data->data[$i]->id = $i+1;
                }
		$out->setData($data);
		return $out;
	}
}
