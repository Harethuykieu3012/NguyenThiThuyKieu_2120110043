<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Topic;
use App\Models\Link;
use Illuminate\Support\Str;
use App\Http\Requests\TopicStoreRequest;
use App\Http\Requests\TopicUpdateRequest;
use Illuminate\Support\Facades\File;

class TopicController extends Controller
{
    // GET admin/topic, admin/topic/index
    public function index()
    {
        $list_topic = Topic::where('status', '!=', 0)->orderBy('created_at', 'desc')->get();
        return view('backend.topic.index', compact('list_topic'));
    }
    // GET admin/topic/trash
    public function trash()
    {
        $list_topic = Topic::where('status', '=', 0)->orderBy('created_at', 'desc')->get();
        return view('backend.topic.trash', compact('list_topic'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $list_topic = Topic::where('status', '!=', 0)->orderBy('created_at', 'desc')->get();
        $html_parent_id = '';
        $html_sort_order = '';
        foreach ($list_topic as $item) {
            $html_parent_id .= '<option value="' . $item->id . '">' . $item->name . '</option>';
            $html_sort_order .= '<option value="' . $item->sort_order . '">Sau:' . $item->name . '</option>';
        }
        return view('backend.topic.create', compact('html_parent_id', 'html_sort_order'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TopicStoreRequest $request)
    {
        $topic = new Topic();
        $topic->title = $request->title;
        $topic->slug = Str::slug($topic->title = $request->title, '-');
        $topic->metakey = $request->metakey;
        $topic->metadesc = $request->metadesc;
        $topic->parent_id = $request->parent_id;
        $topic->sort_order = $request->sort_order;
        $topic->status = $request->status;
        $topic->created_at = date('Y-m-d H:i:s');
        $topic->create_by = 1;
        //Upload file
        if ($request->has('image')) {
            $path_dir = "images/topic"; // nơi lưu trữ
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension(); // lấy phần mở rộng của tập tin 
            $filename = $topic->slug . '.' . $extension; // lấy tên slug  + phần mở rộng 
            $file->move($path_dir, $filename);

            $topic->image = $filename;
        }
        // End upload
        if ($topic->save()) {
            $link = new Link();
            $link->slug = $topic->slug;
            $link->tableid = $topic->id;
            $link->type = 'topic';
            $link->save();
            return redirect()->route('topic.index')->with('message', ['type' => 'success', 'msg' => 'Thêm mẫu tin thành công !']);
        } else
            return redirect()->route('topic.index')->with('message', ['type' => 'danger', 'msg' => 'Thêm mẫu tin không thành công !']);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $topic = Topic::find($id);
        if ($topic == null) {
            return redirect()->route('topic.index')->with('message', ['type' => 'danger', 'msg'
            => 'Mẫu tin không tồn tại!']);
        } else {
            return view('backend.topic.show', compact('topic'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $topic = Topic::find($id);
        $list_topic = Topic::where('status', '!=', 0)->orderBy('created_at', 'desc')->get();
        $html_parent_id = '';
        $html_sort_order = '';
        foreach ($list_topic as $item) {
            $html_parent_id .= '<option value="' . $item->id . '">' . $item->name . '</option>';
            $html_sort_order .= '<option value="' . $item->sort_order . '">Sau:' . $item->name . '</option>';
        }
        return view('backend.topic.edit', compact('topic', 'html_parent_id', 'html_sort_order'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TopicUpdateRequest $request, string $id)
    {
        $topic = Topic::find($id);
        // $topic = new Topic;
        $topic->name = $request->name;
        $topic->slug = Str::slug($topic->name = $request->name, '-');
        $topic->metakey = $request->metakey;
        $topic->metadesc = $request->metadesc;
        $topic->parent_id = $request->parent_id;
        $topic->sort_order = $request->sort_order;
        $topic->status = $request->status;
        $topic->updated_at = date('Y-m-d H:i:s');
        $topic->updated_by = 1;
        if ($request->has('image')) {
            $path_dir = "images/topic/";
            if (File::exists(($path_dir . $topic->image))) {
                File::delete(($path_dir . $topic->image));
            }

            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension(); // lấy phần mở rộng của tập tin
            $filename = $topic->slug . '.' . $extension; // lấy tên slug  + phần mở rộng 
            $file->move($path_dir, $filename);
            $topic->image = $filename;
        }
        //end upload file
        if ($topic->save()) {
            $link = Link::where([['type', '=', 'topic'], ['table_id', '=', $id]])->first();
            //  $link->slug = $topic->slug;
            $link->save();
            return redirect()->route('topic.index')->with('message', ['type' => 'success', 'msg' => 'Sửa mẫu tin thành công !']);
        } else
            return redirect()->route('topic.index')->with('message', ['type' => 'danger', 'msg' => 'Sửa mẫu tin không thành công !']);
    }


    //get:adim/topic/destroy/
    public function destroy(string $id)
    {
        $topic = Topic::find($id);
        //thong tin hinh xoa
        $path_dir = "images/topic/";
        $path_image_delete = $path_dir . $topic->image;
        if ($topic == null) {
            return redirect()->route('topic.trash')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại!']);
        }
        if ($topic->delete()) {
            //xoa hinh
            if (File::exists($path_image_delete)) {
                File::delete($path_image_delete);
            }
        }
        $link = Link::where([['type', '=', 'topic'], ['table_id', '=', $id]])->first();
        $link->delete();
        return redirect()->route('topic.index')->with('message', ['type' => 'success', 'msg' => 'Xóa mẫu tin thành công !']);
    }
    //get:adim/topic/status/1
    public function status($id)
    {
        $topic = Topic::find($id);
        if ($topic == null) {
            return redirect()->route('topic.index')->with('message', ['type' => 'danger', 'msg'
            => 'Mẫu tin không tồn tại!']);

            //chuyen huong bao loi
        }
        $topic->status = ($topic->status == 1) ? 2 : 1;
        $topic->updated_at = date('Y-m-d H:i:s');
        $topic->updated_by = 1;
        $topic->save();
        return redirect()->route('topic.index')->with('message', ['type' => 'success', 'msg'
        => 'Thay đổi trang thái thành công']);
    }
    //get:adim/topic/delete/1
    public function delete($id)
    {
        $topic = Topic::find($id);
        if ($topic == null) {
            return redirect()->route('topic.index')->with('message', ['type' => 'danger', 'msg'
            => 'Mẫu tin không tồn tại!']);

            //chuyen huong bao loi
        }
        $topic->status = 0;
        $topic->updated_at = date('Y-m-d H:i:s');
        $topic->updated_by = 1;
        $topic->save();
        return redirect()->route('topic.index')->with('message', ['type' => 'success', 'msg'
        => 'Xóa vào thùng rác']);
    }
    //get:adim/topic/restore/1
    public function restore($id)
    {
        $topic = Topic::find($id);
        if ($topic == null) {
            return redirect()->route('topic.trash')->with('message', ['type' => 'danger', 'msg'
            => 'Mẫu tin không tồn tại!']);

            //chuyen huong bao loi
        }
        $topic->status = 2;
        $topic->updated_at = date('Y-m-d H:i:s');
        $topic->updated_by = 1;
        $topic->save();
        return redirect()->route('topic.trash')->with('message', ['type' => 'success', 'msg'
        => 'Thay đổi trang thái thành công']);
    }
}
