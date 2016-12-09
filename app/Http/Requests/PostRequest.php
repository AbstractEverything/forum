<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class PostRequest extends Request
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
            'forum_id' => 'required|exists:forums,id',
            'title' => 'required|max:255',
            'body' => 'required',
            'pinned' => ['regex:/^(0|1)$/'],
            'closed' => ['regex:/^(0|1)$/'],
        ];
    }

    public function all()
    {
        $input = parent::all();
        $user = auth()->user();

        $input['user_id'] = $user->id;

        if ( ! $user->can('modify-posts'))
        {
            $input['pinned'] = 0;
            $input['closed'] = 0;
        }

        return $input;
    }
}
