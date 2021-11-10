<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdminCertificate;
use Carbon\Carbon;
use Image;

class AdminCertificateController extends Controller
{
    public function index()
    {
        $certificates=AdminCertificate::all();
        return view('backend.pages.certificate.certificate',compact('certificates'));
    }
    public function store(Request $request)
    {
        $signature = $request->file('signature');
        $name_gen=hexdec(uniqid()).'.'.$signature->getClientOriginalExtension();
        Image::make($signature)->save('uploads/certificate/'.$name_gen);
        $save_url = 'uploads/certificate/'.$name_gen;
        AdminCertificate::insert([

            'user_name' => $request->user_name,
            'language' => $request->language,
            'course_name' => $request->course_name,
            'trainer_name' => $request->trainer_name,
            'date' => $request->date,
            'signature' => $save_url,
            'created_at' => Carbon::now(),
        ]);

        $notification=array(
            'message'=>'Success',
            'alert-type'=>'success'
        );
        return Redirect()->back()->with($notification);
    }
    public function view()
    {
        $mpdf=new \Mpdf\Mpdf([
        'default_font_size'=>12,
        'default_font'=>'nikosh',
    ]);
    $mpdf->WriteHTML($this->pdfHTML());

    $mpdf->Output('htmltopdf.pdf',"D");
    }
    public function pdfHTML(){
        $output="<h1>নাই</h1>";
        return $output;
    }

}
