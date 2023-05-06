<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Topic;

use Illuminate\Support\Str;
use App\Http\Requests\PageStoreRequest;
use App\Http\Requests\PageUpdateRequest;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    // GET admin/post, admin/post/index
    public function index()
    {
        $list_post = Post::where([['status', '!=', 0], ['type', '=', 'post']])->orderBy('created_at', 'desc')->get();
        return view('backend.post.index', compact('list_post'));
    }
    // GET admin/post/trash
    public function trash()
    {
        $list_post = Post::where([['status', '=', 0], ['type', '=', 'post']])->orderBy('created_at', 'desc')->get();
        return view('backend.post.trash', compact('list_post'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $list_topic = Topic::where('status', '!=', 0)->get();
        $html_topic_id = '';

        foreach ($list_topic as $item) {
            $html_topic_id .= '<option value="' . $item->id . '">' . $item->name . '</option>';
        }
        return view('backend.post.create', compact('html_topic_id'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PageStoreRequest $request)
    {
        $post = new Post;
        $post->title = $request->title;
        $post->slug = Str::slug($post->title = $request->title, '-');
        $post->topic_id = $request->topic_id;
        $post->metakey = $request->metakey;
        $post->metadesc = $request->metadesc;
        $post->detail = $request->detail;
        $post->type = 'post';
        $post->status = $request->status;
        $post->created_at = date('Y-m-d H:i:s');
        $post->created_by = 1;
        //xử lý upload hình
        if ($request->has('image')) {
            $path_dir = "images/post/";
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = $post->slug . '.' . $extension;
            $file->move($path_dir, $filename);
            //  echo $filename;
            $post->image = $filename;
        }

        if ($post->save()) {
            return redirect()->route('post.index')->with('message', ['type' => 'success', 'msg'
            => 'Thêm thành công']);
        } else {
            return redirect()->route('post.index')->with('message', ['type' => 'danger', 'msg'
            => 'Thêm không thành công']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $post = Post::find($id);
        if ($post == null) {
            return redirect()->route('post.index')->with('message', ['type' => 'danger', 'msg'
            => 'Mẫu tin không tồn tại!']);
        } else {
            return view('backend.post.show', compact('post'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = Post::find($id);
        $list_topic = Topic::where('status', '!=', 0)->get();
        $html_topic_id = '';

        foreach ($list_topic as $item) {
            if ($post->topic_id == $item->id) {
                $html_topic_id .= '<option selected value="' . $item->id . '">' . $item->name . '</option>';
            } else {
                $html_topic_id .= '<option value="' . $item->id . '">' . $item->name . '</option>';
            }
        }
        return view('backend.post.edit', compact('post', 'html_topic_id '));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PageUpdateRequest $request, string $id)
    {
        $post = Post::find($id);
        // $post = new Page;
        $post->title = $request->title;
        $post->slug = Str::slug($post->title = $request->title, '-');
        $post->metakey = $request->metakey;
        $post->detail = $request->detail;
        $post->metadesc = $request->metadesc;
        $post->type = 'post';
        $post->status = $request->status;
        $post->updated_at = date('Y-m-d H:i:s');
        $post->updated_by = 1;
        if ($request->has('image')) {
            $path_dir = "images/post/";
            if (File::exists(($path_dir . $post->image))) {
                File::delete(($path_dir . $post->image));
            }

            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension(); // lấy phần mở rộng của tập tin
            $filename = $post->slug . '.' . $extension; // lấy tên slug  + phần mở rộng 
            $file->move($path_dir, $filename);
            $post->image = $filename;
        }
        //end upload file
        if ($post->save()) {
            return redirect()->route('post.index')->with('message', ['type' => 'success', 'msg' => 'Sửa mẫu tin thành công !']);
        } else
            return redirect()->route('post.index')->with('message', ['type' => 'danger', 'msg' => 'Sửa mẫu tin không thành công !']);
    }


    //get:adim/post/destroy/
    public function destroy(string $id)
    {
        $post = Post::find($id);
        //thong tin hinh xoa
        $path_dir = "images/post/";
        $path_image_delete = $path_dir . $post->image;
        if ($post == null) {
            return redirect()->route('post.trash')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại!']);
        }
        if ($post->delete()) {
            //xoa hinh
            if (File::exists($path_image_delete)) {
                File::delete($path_image_delete);
            }
        }
        return redirect()->route('post.index')->with('message', ['type' => 'success', 'msg' => 'Xóa mẫu tin thành công !']);
    }
    //get:adim/post/status/1
    public function status($id)
    {
        $post = Post::find($id);
        if ($post == null) {
            return redirect()->route('post.index')->with('message', ['type' => 'danger', 'msg'
            => 'Mẫu tin không tồn tại!']);

            //chuyen huong bao loi
        }
        $post->status = ($post->status == 1) ? 2 : 1;
        $post->updated_at = date('Y-m-d H:i:s');
        $post->updated_by = 1;
        $post->save();
        return redirect()->route('post.index')->with('message', ['type' => 'success', 'msg'
        => 'Thay đổi trang thái thành công']);
    }
    //get:adim/post/delete/1
    public function delete($id)
    {
        $post = Post::find($id);
        if ($post == null) {
            return redirect()->route('post.index')->with('message', ['type' => 'danger', 'msg'
            => 'Mẫu tin không tồn tại!']);

            //chuyen huong bao loi
        }
        $post->status = 0;
        $post->updated_at = date('Y-m-d H:i:s');
        $post->updated_by = 1;
        $post->save();
        return redirect()->route('post.index')->with('message', ['type' => 'success', 'msg'
        => 'Xóa vào thùng rác']);
    }
    //get:adim/post/restore/1
    public function restore($id)
    {
        $post = Post::find($id);
        if ($post == null) {
            return redirect()->route('post.trash')->with('message', ['type' => 'danger', 'msg'
            => 'Mẫu tin không tồn tại!']);

            //chuyen huong bao loi
        }
        $post->status = 2;
        $post->updated_at = date('Y-m-d H:i:s');
        $post->updated_by = 1;
        $post->save();
        return redirect()->route('post.trash')->with('message', ['type' => 'success', 'msg'
        => 'Thay đổi trang thái thành công']);
    }
}
