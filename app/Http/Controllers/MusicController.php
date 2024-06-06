<?php

namespace App\Http\Controllers;

use App\Models\MusicCard;
use App\Models\MusicInfo;
use Carbon\Carbon;
use getID3;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Type\Integer;

class MusicController extends Controller
{
    public function index()
    {
        $cards = auth()->user()->musicCards;
        $myArrayCard = [];
        foreach ($cards as $card) {
            $musicList = $card->musics;
            $str="";
            foreach ($musicList as $music) {
                $str .= '<li class="mb-2">
                <div class="container p-2 d-flex justify-content-between align-items-center"
                    style="background-color: #25262C; color:#f2f2f2;
            border-radius: 8px;">
                    <div class="elementMusicIcon ">
                    </div>
                    <div class="theBtmConttrolleTheMusicStartOrNot" data-statu="0"
                        onclick="funcPlayOrPausetheMusicList(this)">
                    </div>
                    <div class="MusictextTitles">' . $music->name . '</div>
                    <div class="MusictextTitles">' . $music->duree . ' min</div>
                    <div class="MusictextTitles">
                        <button type="button" data-id="' . $music->id . '" class=" m-0 p-1 btn btn-outline-danger"><i
                                class="bx bxs-trash p-0 m-0 bx-sm"></i></button>
                    </div>
                </div>
                <audio class="theMusic"
                    src="' . Storage::url($music->musicUrl) . '">
                </audio>
            </li>';
            }
            $myArrayCard[] = $str;

        }
        return view('music.index', ["cards" => $cards,"musicList"=>$myArrayCard]);
    }

    public function form(Request $req)
    {
        if ($req->statu == "creatCard") {
            $timeStart = $req->timeStart;
            $timeEnd = $req->timeEnd;
            $userId = auth()->user()->id;

            $card = MusicCard::create([
                'from' => $timeStart,
                'to' => $timeEnd,
                'UserId' => $userId
            ]);
            return response()->json(['success' => true, 'timeStart' => $timeStart, 'timeEnd' => $timeEnd, 'userId' => $userId, 'id' => $card->id]);
        } else if ($req->statu == "deleteCard") {
            $card = MusicCard::find($req->id);
            $this->deleteRestOfTHeMusic($card->musics);
            $card->delete();

            return response()->json(['success' => true]);
        } else if ($req->statu == "deleteMusic") {
            $music = MusicInfo::find($req->id);
            if (Storage::exists($music->musicUrl)) {
                Storage::delete($music->musicUrl);
            }
            $music->delete();
            return response()->json(['success' => false]);
        } else if ($req->statu == "AddMusic" && $req->hasFile('theMusic')) {
            $file = $req->file('theMusic');
            $originalName = $file->getClientOriginalName();
            $fileName = time() . '_' . $originalName;
            $file->storeAs('public/musics', $fileName);

            $musicLengthFormatted = $this->getStrinfDuree($this->getMusicDuration($file->getRealPath()));

            $music = MusicInfo::create([
                'idCard' => $req->idCard,
                'name' => $originalName,
                'duree' => $musicLengthFormatted,
                'musicUrl' => 'public/musics/' . $fileName
            ]);


            return redirect()->back();
        }
        return null;
    }

    private function getMusicDuration($filePath)
    {
        $getID3 = new getID3();
        $fileInfo = $getID3->analyze($filePath);

        if (isset($fileInfo['playtime_seconds'])) {
            return $fileInfo['playtime_seconds'];
        }

        return 0; // Default value if duration cannot be determined
    }

    private function getStrinfDuree($duration)
    {
        $minutes = floor($duration / 60);
        $seconds = $duration % 60;
        return sprintf('%d:%02d', $minutes, $seconds);
    }

    private function deleteRestOfTHeMusic($list){
        foreach ($list as $req) {
            $music = MusicInfo::find($req->id);
            if (Storage::exists($music->musicUrl)) {
                Storage::delete($music->musicUrl);
            }
            $music->delete();
        }
    }
}
