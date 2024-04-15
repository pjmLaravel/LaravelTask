<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NoticeController extends Controller
{
    // 공지사항 작성
    public function addNotice()
    {

        return view('add-notice');
    }

    // 공지사항 작성 form

    public function addNoticeSubmit(Request $request)
    {
        $createdAt = Carbon::now();



        $notice = new Notice();
        $notice->subject = $request->subject;
        $notice->content = $request->content;
        $notice->created_at = $createdAt;
        $notice->save();

        return redirect()->route('admin.notice')
            ->with('post_create', '공지사항이 등록되었습니다.');
    }

    // 유저 공지사항 목록
    public function getAllNotice(Request $request)
    {
        $search = $request->input('search');

        $notice = DB::table('notices')
            ->select('subject', 'content', 'created_at', 'id')
            ->orderBy('created_at', 'desc')
            ->when($search, function ($query, $search) {
                $query->where('subject', 'like', "%$search%");
            })
            ->paginate(7);

        return view('notice', compact('notice'));
    }

    // 관리자 공지사항 목록 페이지
    public function getNotice(Request $request)
    {
        $search = $request->input('search');

        $notice = DB::table('notices')
            ->select('subject', 'content', 'created_at', 'id')
            ->orderBy('created_at', 'desc')
            ->when($search, function ($query, $search) {
                $query->where('subject', 'like', "%$search%");
            })
            ->paginate(7);

        return view('admin-notice', compact('notice'));
    }

    // 공지사항 글 보기

    public function getNoticeById($id)
    {

        $notice = DB::table('notices')
            ->select('subject', 'content', 'id')
            ->where('id', $id)
            ->first();

        if (!$notice) {
            // 게시물이 존재하지 않는 경우 예외 처리
            return redirect()->back()->with('error', '게시물을 찾을 수 없습니다.');
        }

        return view('single-notice', compact('notice'));
    }

    //  공지사항 삭제 (관리자)

    public function deleteNotice($id)
    {
        DB::table('notices')->where('id', $id)->delete();

        return redirect()->route('admin.notice')
            ->with('post_delete', '공지글이 삭제되었습니다.');
    }
}
