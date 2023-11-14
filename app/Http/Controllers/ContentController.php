<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContentController extends Controller
{
    public function index()
    {
        return view('admin.content.view-content');
    }

    public function create()
    {
        return view('admin.content.create-content');
    }

    public function getContentType()
    {
        $content = DB::table('lookups')->where('lookups.parent', config('lookup.lookup_item.content'))->get();

        return response()->json([
            'success' => true,
//            'pending' => $pending,
            'content' => $content,
        ], 200);
    }

    public function store(Request $request)
    {
        if ($request->is_active == 'on') {
            $is_active = 1;
        } else {
            $is_active = 0;
        }
        if ($request->is_published == 'on') {
            $is_published = 1;
        } else {
            $is_published = 0;
        }
        $contents = Content::create([
            'content_type' => $request->content_type,
            'meta_tag' => $request->meta_tag,
            'meta_description' => $request->meta_description,
            'keywords' => $request->keywords,
            'is_active' => $is_active,
            'content' => $request->contents,
            'is_published' => $is_published,
            'created_by' => $request->hiddenUser,
        ]);
        return response()->json([
            'msg' => 'Content stored successfully',
            'getcontent' => $contents,
            'success' => true,
        ], 200);
    }

    public function show()
    {
        $content =  DB::table('contents')
            ->join('users', 'contents.created_by', '=', 'users.id')
            ->join('lookups', 'contents.content_type', '=', 'lookups.id')
            ->select('contents.*','users.first_name','users.last_name','lookups.name')
            ->get();
        return response()->json([
            'success' => true,
            'data' => $content,
        ], 200);
    }

    public function individualData($id){
        $contentInfo = DB::table('contents')
            ->join('users', 'contents.created_by', '=', 'users.id')
            ->join('lookups', 'contents.content_type', '=', 'lookups.id')
            ->select('contents.*','users.first_name','users.last_name','lookups.name')
            ->where('contents.id',$id)
            ->first();
        return response()->json(['data'=>$contentInfo,'success'=>true]);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
