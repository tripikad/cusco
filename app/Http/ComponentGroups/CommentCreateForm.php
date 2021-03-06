<?php

namespace App\Http\ComponentGroups;

use Illuminate\Http\Request;

class CommentCreateForm {

    public function render(Request $request)
    {

        return component('Block')
            ->is('withBackground')
            ->with('title', 'Add new comment')
            ->with('content', collect()
                ->push(component('FormHeader')
                    ->with('action', '/')
                    ->with('method', 'get')
                )
                ->push(component('FormTextarea')
                    ->with('name', 'body')
                    ->with('label', 'Body')
                    ->with('value', 'World')
                )
                ->push(component('FormButton')
                    ->with('title', 'Save')
                )
                ->push(component('FormFooter'))
            );

    }

}