<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ReplyRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'post_id' => 'required|exists:posts,id',
            'title' => 'required|max:255',
            'body' => 'required',
        ];
    }

    public function all()
    {
        $input = parent::all();
        $input['user_id'] = auth()->user()->id;

        return $input;
    }
}
