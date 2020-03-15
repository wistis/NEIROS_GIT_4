<?php

namespace App\Http\Controllers;

use App\Projects_tag;
use App\Tag;
use App\Widget_tags;
use Auth;
class TagsController extends Controller
{
    static function addtag($tags_array, $project_id)
    {
        $user = Auth::user();
        for ($i = 0; $i < count($tags_array); $i++) {

            $flight = Tag:: firstOrNew(['name' => trim($tags_array[$i]),'my_company_id'=> $user->my_company_id]);
            $flight->save();
            $project_tag = Projects_tag::firstOrNew(['tag_id' => $flight->id, 'project_id' => $project_id,'my_company_id'=> $user->my_company_id]);
            $project_tag->save();
        }


    }

    static function addtag_widget($tags_array, $project_id)
    {
$user=Auth::user();
        for ($i = 0; $i < count($tags_array); $i++) {

            $flight = Tag::firstOrNew(['name' => trim($tags_array[$i]),'my_company_id'=> $user->my_company_id]);
            $flight->save();
            $project_tag = Widget_tags::firstOrNew(['tag_id' => $flight->id, 'project_id' => $project_id,'my_company_id'=> $user->my_company_id]);
            $project_tag->save();
        }


    }


}
