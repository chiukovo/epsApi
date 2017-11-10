<?php

namespace App\Services;

use App\Repositories\ActivityRepositories;
use App\Repositories\CommunityRepositories;
use App\Repositories\GadreRepositories;
use App\Repositories\LiceRepositories;
use App\Repositories\ParcRepositories;
use App\Repositories\ReadRepositories;
use App\Repositories\SchshipRepositories;
use App\Repositories\RaceRepositories;
use App\Repositories\ExhiRepositories;
use App\Repositories\ShowRepositories;

class ShareServices
{
    public static function getShareData($selfType, $userId, $search = '')
    {
        switch ($selfType) {
            case 1:
                # 活動紀錄...
                return ActivityRepositories::getShareByFilters([
                    'Stu_Id' => $userId,
                ], $search);
                break;
            case 2:
                # 參與社團...
                return CommunityRepositories::getShareByFilters([
                    'Stu_Id' => $userId,
                ], $search);
                break;
            case 3:
                # 幹部經歷...
                return GadreRepositories::getShareByFilters([
                    'Stu_Id' => $userId,
                ], $search);
                break;
            case 4:
                # 專業證照...
                return LiceRepositories::getShareByFilters([
                    'Stu_Id' => $userId,
                ], $search);
                break;
            case 5:
                # 實習經驗...
                return ParcRepositories::getShareByFilters([
                    'Stu_Id' => $userId,
                ], $search);
                break;
            case 6:
                # 工讀經驗...
                return ReadRepositories::getShareByFilters([
                    'Stu_Id' => $userId,
                ], $search);
                break;
            case 7:
                # 獎學金...
                return SchshipRepositories::getShareByFilters([
                    'Stu_Id' => $userId,
                ], $search);
                break;
            case 8:
                # 競賽獲獎...
                return RaceRepositories::getShareByFilters([
                    'Stu_Id' => $userId,
                ], $search);
                break;
            case 9:
                # 參展記錄...
                return ExhiRepositories::getShareByFilters([
                    'Stu_Id' => $userId,
                ], $search);
                break;
            case 10:
                # 演出記錄...
                return ShowRepositories::getShareByFilters([
                    'Stu_Id' => $userId,
                ], $search);
                break;
        }

        return [];
    }
}