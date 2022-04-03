<?php

namespace App\Http\Controllers;

use App\Models\WordModel;
use Doctrine\Inflector\Rules\Word;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;


class WordController extends Controller
{
    function  getAllWords()
    {
        // ini_set('memory_limit', '-1');
        try {
            $data = WordModel::all();
            $res['status'] = 1;
            $res['data'] = $data;
        } catch (\Throwable $th) {
            $res['status'] = 0;
        }
        // echo json_encode($data);
        return response($res);
    }
    function  getWordDetail($id)
    {
        try {
            $data = WordModel::FindOrFail($id);
            if ($data->count() == 0)
                $res['status'] = 0;
            else {
                $res['status'] = 1;
                $res['data'] = $data;
            }
        } catch (\Throwable $th) {
            $res['status'] = 0;
        }
        return response($res);
    }

    function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'word' => ['required', 'string',  'not_regex:/<(?:(?!input)[^>])*>(?:<\\/[^>]*>)?/'],
        ], [
            'numeric' => 'Only numbers are allowed here',
            'required' => 'This field is required',
            'not_regex' => 'The format is invalid',
        ]);

        if ($validator->fails()) {
            $res['status'] = 0;
        } else {
            try {
                WordModel::create(['word' => $request->word]);
                $res['status'] = 1;
            } catch (\Throwable $th) {
                $res['status'] = 0;
            }
        }
        return response($res, 201);
    }

    function delete(WordModel $word_id)
    {
        $word_id->delete();
        return response('', Response::HTTP_NO_CONTENT);
    }

    function update(Request $request, WordModel $word_id)
    {
        $validator = Validator::make($request->all(), [
            'word' => ['required', 'string',  'not_regex:/<(?:(?!input)[^>])*>(?:<\\/[^>]*>)?/'],
        ], [
            'numeric' => 'Only numbers are allowed here',
            'required' => 'This field is required',
            'not_regex' => 'The format is invalid',
        ]);
        if ($validator->fails()) {
            $res['status'] = 0;
        } else {
            try {
                $word_id->update($request->all());
                $res['status'] = 1;
            } catch (\Throwable $th) {
                $res['status'] = 0;
            }
        }
    }
}
