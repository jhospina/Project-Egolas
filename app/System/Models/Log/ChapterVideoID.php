<?php

namespace App\System\Models\Log;

use Illuminate\Database\Eloquent\Model;
use App\System\Library\Complements\DateUtil;

class ChapterVideoID extends Model {

    protected $table = 'log_chapter_video_id';
    public $timestamps = false;

    const ATTR_CHAPTER_ID = "chapter_id";
    const ATTR_VIDEO_ID = "video_id";
    const ATTR_DATE = "date";

    static function add($chapter_id, $video_id) {
        $log = new ChapterVideoID;
        $log->chapter_id=$chapter_id;
        $log->video_id = $video_id;
        $log->date=DateUtil::getCurrentTime();
        $log->save();
    }

}
