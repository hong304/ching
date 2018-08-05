<?php

namespace App\Http\Controllers;

use App\Mail\NewsletterMail;
use App\Models\Image;
use App\Models\Newsletter;
use App\Models\NewsletterModule;
use App\Models\NewsletterTextModule;
use App\Models\NewsletterUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Yajra\Datatables\Facades\Datatables;

class AdminNewsletterController extends Controller
{

    public function showIndex()
    {
        return view('admin.newsletter.newsletter-list');
    }

    public function getNewsletter($id)
    {
        return Newsletter::with(['newsletter_module' => function ($query) {
            $query->with('text_module');
        }])->with('cover_image')
            ->where('id', $id)
            ->first();
    }

    public function ajaxGetNewsletterData(Request $request)
    {
        $newsletter = Newsletter::select('id', 'name', 'no_of_sent', 'created_at', 'updated_at');

        return Datatables::of($newsletter)
            ->addColumn('count', function ($newsletter) {
                return NewsletterUser::where('newsletter_id', $newsletter->id)->count();
            })
            ->addColumn('edit', function ($newsletter) {
                return '<a href="' . route("adminNewsletter.edit", $newsletter->id) . '" ><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>';
            })
            ->addColumn('delete', function ($newsletter) {
                if ($newsletter->no_of_sent == 0) {
                    return '<a href="javascript:void(0);" onclick="deleteNewsletter(' . $newsletter->id . ')"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>';
                }
                return "-";
            })
            ->addColumn('preview', function ($newsletter) {
                return '<a href="' . route("adminNewsletter.preview", $newsletter->id) . '" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i> Preview</a>';
            })
            ->addColumn('send', function ($newsletter) {
                if (Auth::id() == env('CHING_ID')) {
                    return "-";
                }
                return '<a href="' . route("adminNewsletter.send", $newsletter->id) . '"><i class="fa fa-envelope-o" aria-hidden="true"></i> Send</a>';
            })
            ->make();
    }

    public function showEditNewsletter(Request $request)
    {
        $newsletter = $this->getNewsletter($request->id);
        return view('admin.newsletter.edit-newsletter', compact('newsletter'));
    }

    public function editNewsletter(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'subject' => 'required',
            'cover_image' => 'image|mimes:jpeg,png,jpg|dimensions:min_width=580',
            'cover_image_alt' => 'required',
            'text_module_content' => 'required',
            'scheduled_hour' => 'numeric',
            'scheduled_minute' => 'numeric',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $successMessage = "Newsletter is created.";
        $newsletter = new Newsletter();
        if ($request->id) {
            $newsletter = $this->getNewsletter($request->id);
            $successMessage = "Newsletter is edited.";
        }

        $newsletter->name = $request->name;
        $newsletter->subject = $request->subject;

        if ($request->file('cover_image')) {
            if ($newsletter->cover_image_id) {
                Image::destroy($newsletter->cover_image_id);
            }

            $cover_image_id = Image::resizeAndSaveImageToCDN($request->file('cover_image'), 580);
            if ($cover_image_id) {
                $newsletter->cover_image_id = $cover_image_id;
            } else {
                return back()
                    ->withErrors("Cover Image Upload Failed, please upload again.")
                    ->withInput();
            }
        }
        $newsletter->cover_image_alt = $request->cover_image_alt;
        $newsletter->no_of_sent = 0;
        if ($request->scheduled_date){
            $sendTime = new \DateTime($request->scheduled_date);
            $sendHour =  ($request->scheduled_hour)? $request->scheduled_hour : 0;
            $sendMinute =  ($request->scheduled_minute)? $request->scheduled_minute : 0;
            $newsletter->send_time = $sendTime->setTime($sendHour, $sendMinute, 0);
        }else{
            $newsletter->send_time = null;
        }

        $newsletter->save();

        $newsletterModule = new NewsletterModule();
        $textModule = new NewsletterTextModule();
        if ($request->id) {
            foreach ($newsletter->newsletter_module as $module) {
                $newsletterModule = $module;
                if (strcmp($module->table_name, "text") == 0) {
                    $textModule = $module->text_module;
                }

            }
        }

        $textModule->content = $request->text_module_content;
        $textModule->save();

        $newsletterModule->newsletter_id = $newsletter->id;
        $newsletterModule->table_name = 'text';
        $newsletterModule->module_id = $textModule->id;
        $newsletterModule->order = 1;
        $newsletterModule->save();


        return redirect()
            ->route('adminNewsletter.index')
            ->with('message', $successMessage)
            ->with('status', 'success');
    }

    public function showCreateNewsletter(Request $request)
    {
        return view('admin.newsletter.create-newsletter');
    }

    public function deleteNewsletter(Request $request)
    {
        $newsletter = $this->getNewsletter($request->id);

        if ($newsletter->no_of_send == 0) {

            Image::destroy($newsletter->cover_image_id);

            foreach ($newsletter->newsletter_module as $key => $module) {
                if (strcmp($module->table_name, "text") == 0) {
                    NewsletterTextModule::destroy($module->text_module->id);
                }
                NewsletterModule::destroy($module->id);
            }

            Newsletter::destroy($request->id);

            return redirect()
                ->route('adminNewsletter.index')
                ->with('message', 'Newsletter with id ' . $request->id . ' is deleted.')
                ->with(('status'), 'success');
        }

        return redirect()
            ->route('adminNewsletter.index')
            ->withErrors("This Newsletter had been sent out before, you cannot delete it.");

    }

    public function previewNewsletter(Request $request)
    {

        $newsletter = $this->getNewsletter($request->id);

        return view('emails.newsletter', compact('newsletter'));
    }

    public function showSendNewsletter(Request $request)
    {
        if (Auth::id() == env('CHING_ID')) {
            return redirect()->route('adminNewsletter.index');
        }
        $id = $request->id;
        return view('admin.newsletter.send-newsletter', compact('id'));
    }

    public function sendTestNewsletter(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'test_emails' => 'required',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $newsletter = $this->getNewsletter($request->id);

        $newsletter->userId = 0;

        $message = (new NewsletterMail($newsletter))->onConnection('database')->onQueue('emails');

        $emailArray = explode(",", $request->test_emails);
        foreach ($emailArray as $email) {
            Mail::bcc(trim($email))
                ->queue($message);
        }

        return redirect()
            ->route('adminNewsletter.index')
            ->with('message', 'Newsletter with id ' . $request->id . ' is sent for test.')
            ->with('status', 'success');

    }


    public function sendNewsletter(Request $request)
    {
        $newsletter = $this->getNewsletter($request->id);

        $newsletter->no_of_sent = $newsletter->no_of_sent + 1;
        $newsletter->send_time = null;
        $newsletter->save();

        User::select('id', 'email')->where('activated', true)->chunk(1000, function ($emailList) use ($newsletter) {

            foreach ($emailList as $email) {
                $newsletter->userId = $email['id'];
                $message = (new NewsletterMail($newsletter))->onConnection('database')->onQueue('emails');
                Mail::bcc($email['email'])
                    ->queue($message);
            }
        });

        return redirect()
            ->route('adminNewsletter.index')
            ->with('message', 'Newsletter with id ' . $request->id . ' is sent.')
            ->with(('status'), 'success');
    }

    public function newsletterWatchCount(Request $request)
    {

        $newsletterUser = NewsletterUser::where('newsletter_id', $request->newsletterId)->where('user_id', $request->uid)->first();
        if ($newsletterUser) {
            $newsletterUser->count = $newsletterUser->count + 1;
            $newsletterUser->save();
        } else {
            $newsletterUser = new NewsletterUser();
            $newsletterUser->user_id = $request->uid;
            $newsletterUser->newsletter_id = $request->newsletterId;
            $newsletterUser->count = 1;
            $newsletterUser->save();
        }

        $img = \Images::canvas(1, 1, '#ffffff');
        return $img->response('png', 70);
    }
}

;